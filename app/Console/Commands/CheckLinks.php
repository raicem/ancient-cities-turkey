<?php

namespace App\Console\Commands;

use App\Link;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TooManyRedirectsException;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class CheckLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'links:check
                            {--report-all : Report every failing link instead of only changes}
                            {--dry-run : Print the report without writing statuses or notifying Slack}
                            {--only= : Only check links whose URL contains this string (debugging)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks links in the system about their availability.';

    /**
     * Statuses that are worth a Slack notification. Reachable links and
     * self-inflicted rate limits are not.
     *
     * @var list<string>
     */
    private const NOTIFIABLE = ['dead', 'blocked', 'redirected', 'ssl', 'error'];

    /**
     * Public-resolver fallback results, keyed by host.
     *
     * @var array<string, string|null>
     */
    private array $dnsCache = [];

    /**
     * Execute the console command.
     */
    public function handle(Client $client): void
    {
        /** @var Collection<string, Collection<int, Link>> $linksByUrl */
        $linksByUrl = $this->linkQuery()->get()->groupBy('url');

        $lastRequestAt = [];
        $results = [];

        foreach ($linksByUrl as $url => $group) {
            $url = (string) $url;
            $this->info('Checking link: ' . $url);

            $results[$url] = $this->checkWithFallbacks($client, $url, $lastRequestAt);
        }

        $attachments = $this->buildReport($linksByUrl, $results, (bool) $this->option('report-all'));

        if ((bool) $this->option('dry-run')) {
            $this->renderReport($attachments);

            return;
        }

        foreach ($linksByUrl as $url => $group) {
            $result = $results[(string) $url];

            Link::whereIn('id', $group->pluck('id'))->update([
                'last_status' => $result['status'],
                'last_reason' => $result['reason'],
                'last_checked_at' => now(),
            ]);
        }

        if ($attachments === []) {
            return;
        }

        $webhook = (string) config('services.slack.webhook');

        if ($webhook === '') {
            $this->warn('SLACK_WEBHOOK is not configured; printing the report instead.');
            $this->renderReport($attachments);

            return;
        }

        $client->request('POST', $webhook, [
            'json' => [
                'text' => $this->option('report-all')
                    ? 'Link kontrolü: tam rapor'
                    : 'Link kontrolü: değişiklikler var',
                'attachments' => $attachments,
                'channel' => '#genel',
            ],
        ]);
    }

    /**
     * @param list<array{title: string, text: string}> $attachments
     */
    private function renderReport(array $attachments): void
    {
        foreach ($attachments as $attachment) {
            $this->info($attachment['title']);
            $this->line($attachment['text']);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder<Link>
     */
    private function linkQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = Link::query()->with('ruin')->orderBy('id');
        $only = (string) $this->option('only');

        if ($only !== '') {
            $query->where('url', 'like', '%' . $only . '%');
        }

        return $query;
    }

    /**
     * URLs to try for a stored link. Scheme-less URLs are tried as
     * https first (like browsers), then http.
     *
     * @return list<string>
     */
    public static function candidateUrls(string $url): array
    {
        if (! str_contains($url, '://')) {
            return ['https://' . $url, 'http://' . $url];
        }

        return [$url];
    }

    /**
     * Uses the candidates for scheme-less URLs, with a host delay before
     * every request and one retry for transient failures.
     *
     * @param array<string, float> $lastRequestAt
     * @return array{status: string, reason: ?string}
     */
    private function checkWithFallbacks(Client $client, string $url, array &$lastRequestAt): array
    {
        $result = ['status' => 'ok', 'reason' => null];

        foreach (self::candidateUrls($url) as $candidate) {
            $this->waitForHost($candidate, $lastRequestAt);
            $result = $this->checkUrl($client, $candidate);

            if ($result['status'] === 'ok') {
                return $result;
            }
        }

        return $result;
    }

    /**
     * @return array{status: string, reason: ?string}
     */
    private function checkUrl(Client $client, string $url): array
    {
        $attempt = 1;

        while (true) {
            $result = $this->attempt($client, $url);

            if ($result['status'] === 'ok'
                || ! $this->isRetryable($result)
                || $attempt >= (int) config('link_checker.max_attempts', 2)) {
                return $result;
            }

            $attempt++;
            sleep((int) config('link_checker.retry_delay_seconds', 3));
        }
    }

    /**
     * @return array{status: string, reason: ?string}
     */
    private function attempt(Client $client, string $url): array
    {
        try {
            return $this->request($client, $url);
        } catch (ConnectException $exception) {
            // The production host's resolver cannot reach some domains
            // (e.g. Turkish government sites). Fall back to a public
            // resolver before calling the link dead.
            if ($this->isDnsFailure($exception) && ($host = $this->hostOf($url)) !== null) {
                $ip = $this->resolveViaDoh($client, $host);

                if ($ip !== null) {
                    try {
                        return $this->request($client, $url, [$host => $ip]);
                    } catch (TransferException $retryException) {
                        return $this->classifyException($url, $retryException);
                    } catch (\Throwable $retryException) {
                        report($retryException);

                        return ['status' => 'error', 'reason' => 'check failed'];
                    }
                }
            }

            return $this->classifyException($url, $exception);
        } catch (TransferException $exception) {
            return $this->classifyException($url, $exception);
        } catch (\Throwable $exception) {
            report($exception);

            return ['status' => 'error', 'reason' => 'check failed'];
        }
    }

    /**
     * @param array<string, string> $resolve Host => IP overrides
     * @return array{status: string, reason: ?string}
     */
    private function request(Client $client, string $url, array $resolve = []): array
    {
        $options = [
            'timeout' => 20,
            'http_errors' => false,
            'allow_redirects' => [
                'max' => 5,
                'strict' => true,
                'referer' => false,
                'protocols' => ['http', 'https'],
                'track_redirects' => true,
            ],
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml',
                'Accept-Language' => 'en-US,en;q=0.9,tr;q=0.8',
            ],
        ];

        if ($resolve !== []) {
            $entries = [];

            foreach ($resolve as $host => $ip) {
                // Register the override for both web ports so http → https
                // redirects keep working without another DNS lookup.
                $entries[] = $host . ':80:' . $ip;
                $entries[] = $host . ':443:' . $ip;

                $port = $this->portOf($url);

                if ($port !== 80 && $port !== 443) {
                    $entries[] = $host . ':' . $port . ':' . $ip;
                }
            }

            $options['curl'] = [CURLOPT_RESOLVE => $entries];
        }

        $response = $client->request('GET', $url, $options);

        return $this->classifyStatus(
            $url,
            $response->getStatusCode(),
            $response->getHeaderLine('X-Guzzle-Redirect-History')
        );
    }

    private function resolveViaDoh(Client $client, string $host): ?string
    {
        if (array_key_exists($host, $this->dnsCache)) {
            return $this->dnsCache[$host];
        }

        $this->dnsCache[$host] = null;

        try {
            $response = $client->request('GET', 'https://cloudflare-dns.com/dns-query', [
                'query' => ['name' => $host, 'type' => 'A'],
                'headers' => ['Accept' => 'application/dns-json'],
                'timeout' => 10,
                'http_errors' => false,
            ]);

            $payload = json_decode((string) $response->getBody(), true);

            foreach ($payload['Answer'] ?? [] as $answer) {
                if (($answer['type'] ?? null) === 1 && isset($answer['data'])) {
                    return $this->dnsCache[$host] = (string) $answer['data'];
                }
            }
        } catch (\Throwable $exception) {
            report($exception);
        }

        return null;
    }

    private function isDnsFailure(ConnectException $exception): bool
    {
        $message = $exception->getMessage();

        return str_contains($message, 'Could not resolve host')
            || str_contains($message, 'name or service not known')
            || str_contains($message, 'getaddrinfo');
    }

    private function portOf(string $url): int
    {
        $port = parse_url($url, PHP_URL_PORT);

        if (is_int($port)) {
            return $port;
        }

        return parse_url($url, PHP_URL_SCHEME) === 'http' ? 80 : 443;
    }

    /**
     * @return array{status: string, reason: ?string}
     */
    private function classifyStatus(string $url, int $status, string $redirectHistory): array
    {
        if ($status < 400) {
            return $this->classifyRedirect($url, $redirectHistory) ?? ['status' => 'ok', 'reason' => null];
        }

        // web.archive.org answers 404 or 503 to server IPs even when the
        // snapshot plays fine in a browser, so it is not reliable enough
        // to call a link dead.
        if ($this->hostOf($url) === 'web.archive.org' && ($status >= 500 || $status === 404 || $status === 410)) {
            return ['status' => 'blocked', 'reason' => 'HTTP ' . $status . ' (archive.org)'];
        }

        if ($status === 404 || $status === 410 || $status >= 500) {
            return ['status' => 'dead', 'reason' => 'HTTP ' . $status];
        }

        if ($status === 429) {
            return ['status' => 'rate-limited', 'reason' => 'HTTP 429'];
        }

        return ['status' => 'blocked', 'reason' => 'HTTP ' . $status];
    }

    /**
     * @return array{status: string, reason: ?string}
     */
    private function classifyException(string $url, TransferException $exception): array
    {
        if ($exception instanceof TooManyRedirectsException) {
            return ['status' => 'blocked', 'reason' => 'redirect loop'];
        }

        $message = $exception->getMessage();

        if (str_contains($message, 'SSL') || str_contains($message, 'certificate')) {
            return ['status' => 'ssl', 'reason' => 'SSL error'];
        }

        if ($exception instanceof ConnectException) {
            if ($this->isDnsFailure($exception)) {
                return ['status' => 'dead', 'reason' => 'dns failure'];
            }

            return ['status' => 'dead', 'reason' => 'connection failed'];
        }

        if ($exception instanceof RequestException && $exception->getResponse() !== null) {
            return $this->classifyStatus($url, $exception->getResponse()->getStatusCode(), '');
        }

        return ['status' => 'blocked', 'reason' => 'request failed'];
    }

    /**
     * Flags links that now redirect to a different site, e.g. parked or
     * hijacked domains.
     *
     * @return null|array{status: string, reason: ?string}
     */
    private function classifyRedirect(string $url, string $redirectHistory): ?array
    {
        if ($redirectHistory === '') {
            return null;
        }

        $targets = array_values(array_filter(array_map('trim', explode(',', $redirectHistory))));

        if ($targets === []) {
            return null;
        }

        $finalHost = $this->hostOf((string) end($targets));
        $originalHost = $this->hostOf($url);

        if ($finalHost === null || $originalHost === null || $this->sameSite($originalHost, $finalHost)) {
            return null;
        }

        return ['status' => 'redirected', 'reason' => '→ ' . $finalHost];
    }

    /**
     * @param array{status: string, reason: ?string} $result
     */
    private function isRetryable(array $result): bool
    {
        if ($result['status'] === 'rate-limited') {
            return true;
        }

        if ($result['status'] !== 'dead') {
            return false;
        }

        $reason = $result['reason'] ?? '';

        return $reason === 'connection failed' || str_starts_with($reason, 'HTTP 5');
    }

    /**
     * Blocks failed checks from being reported again, and only notifies
     * about status changes: new failures and recoveries.
     *
     * @param Collection<string, Collection<int, Link>> $linksByUrl
     * @param array<string, array{status: string, reason: ?string}> $results
     * @return list<array{title: string, text: string}>
     */
    private function buildReport(Collection $linksByUrl, array $results, bool $reportAll): array
    {
        $titles = [
            'dead' => 'Ulaşılamayan linkler',
            'blocked' => 'Engellenen linkler',
            'redirected' => 'Farklı siteye yönlenen linkler',
            'ssl' => 'Sertifika sorunu olan linkler',
            'error' => 'Kontrol edilemeyen linkler',
            'rate-limited' => 'Oran sınırına takılan linkler',
            'recovered' => 'Düzelen linkler',
        ];

        $lines = ['dead' => [], 'blocked' => [], 'redirected' => [], 'ssl' => [], 'error' => [], 'rate-limited' => [], 'recovered' => []];
        $counts = ['dead' => 0, 'blocked' => 0, 'redirected' => 0, 'ssl' => 0, 'error' => 0, 'rate-limited' => 0];
        $knownBlocked = 0;

        foreach ($linksByUrl as $url => $group) {
            $url = (string) $url;
            $result = $results[$url];
            $status = $result['status'];
            $previous = $group->first()->last_status;
            $previousReason = $group->first()->last_reason;

            // Known bot-protection walls are counted separately, not as
            // actionable failures.
            $suppressed = ($status === 'blocked' || $status === 'rate-limited') && $this->isKnownBlockedHost($url);

            if ($suppressed) {
                $knownBlocked++;
            } elseif ($status !== 'ok') {
                $counts[$status]++;
            }

            if ($reportAll) {
                if ($status !== 'ok') {
                    $lines[$status][] = $this->formatLine($url, $result['reason'], $group);
                }

                continue;
            }

            // First run after install: record, do not alert.
            if ($previous === null) {
                continue;
            }

            $previousNotifiable = $this->isNotifiable($previous, $url);
            $currentNotifiable = $this->isNotifiable($status, $url);

            if (! $previousNotifiable && $currentNotifiable) {
                $lines[$status][] = $this->formatLine($url, $result['reason'], $group);
            } elseif ($previousNotifiable && ! $currentNotifiable && $status === 'ok') {
                $lines['recovered'][] = $this->formatLine($url, $previousReason, $group, 'önceki: ');
            } elseif ($previousNotifiable && $currentNotifiable && $previous !== $status) {
                $lines[$status][] = $this->formatLine($url, $result['reason'], $group);
            }
        }

        $attachments = [];

        foreach (array_keys($titles) as $status) {
            if ($lines[$status] === []) {
                continue;
            }

            $title = $titles[$status] . ' (' . count($lines[$status]) . ')';
            $attachments = array_merge($attachments, $this->chunkAttachments($title, $lines[$status]));
        }

        if (! $reportAll && $attachments !== []) {
            $summary = [];

            foreach (['dead' => 'ulaşılamıyor', 'blocked' => 'engelli', 'redirected' => 'yönleniyor', 'ssl' => 'sertifika sorunu', 'error' => 'kontrol edilemedi', 'rate-limited' => 'oran sınırlı'] as $status => $label) {
                if ($counts[$status] > 0) {
                    $summary[] = $counts[$status] . ' ' . $label;
                }
            }

            if ($knownBlocked > 0) {
                $summary[] = $knownBlocked . ' bilinen bot koruması (gizlendi)';
            }

            if ($summary !== []) {
                array_unshift($attachments, ['title' => 'Özet', 'text' => implode(' · ', $summary)]);
            }
        }

        return $attachments;
    }

    /**
     * @param Collection<int, Link> $group
     */
    private function formatLine(string $url, ?string $reason, Collection $group, string $reasonPrefix = ''): string
    {
        $reasonText = ($reason !== null && $reason !== '') ? ' (' . $reasonPrefix . $reason . ')' : '';
        $ruins = $group->map(fn (Link $link) => $link->ruin?->name)->filter()->unique()->implode(', ');
        $ruinsText = $ruins !== '' ? ' — ' . $ruins : '';

        return $url . $reasonText . $ruinsText;
    }

    /**
     * @param list<string> $lines
     * @return list<array{title: string, text: string}>
     */
    private function chunkAttachments(string $title, array $lines): array
    {
        $attachments = [];
        $chunk = [];
        $length = 0;

        foreach ($lines as $line) {
            $lineLength = mb_strlen($line) + 1;

            if ($chunk !== [] && $length + $lineLength > 2500) {
                $attachments[] = ['title' => $title, 'text' => implode("\n", $chunk)];
                $chunk = [];
                $length = 0;
            }

            $chunk[] = $line;
            $length += $lineLength;
        }

        if ($chunk !== []) {
            $attachments[] = ['title' => $title, 'text' => implode("\n", $chunk)];
        }

        return $attachments;
    }

    private function isNotifiable(string $status, string $url): bool
    {
        if (! in_array($status, self::NOTIFIABLE, true)) {
            return false;
        }

        if ($status === 'blocked' && $this->isKnownBlockedHost($url)) {
            return false;
        }

        return true;
    }

    private function isKnownBlockedHost(string $url): bool
    {
        $host = $this->hostOf($url);

        if ($host === null) {
            return false;
        }

        foreach ((array) config('link_checker.known_blocked_hosts', []) as $domain) {
            $domain = strtolower((string) $domain);

            if ($host === $domain || str_ends_with($host, '.' . $domain)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Keeps at least the configured delay between two requests to the
     * same host, so a run with dozens of links to one site does not
     * trip its rate limits.
     *
     * @param array<string, float> $lastRequestAt
     */
    private function waitForHost(string $url, array &$lastRequestAt): void
    {
        $host = $this->hostOf($url);

        if ($host === null) {
            return;
        }

        $delayMs = (int) config('link_checker.host_delay_ms', 2000);
        $last = $lastRequestAt[$host] ?? null;

        if ($delayMs > 0 && $last !== null) {
            $elapsedMs = (microtime(true) - $last) * 1000;
            $remainingMs = $delayMs + random_int(0, 200) - $elapsedMs;

            if ($remainingMs > 0) {
                usleep((int) ($remainingMs * 1000));
            }
        }

        $lastRequestAt[$host] = microtime(true);
    }

    private function hostOf(string $url): ?string
    {
        $host = parse_url($url, PHP_URL_HOST);

        return is_string($host) ? strtolower($host) : null;
    }

    private function sameSite(string $a, string $b): bool
    {
        $a = preg_replace('/^www\./', '', $a) ?? $a;
        $b = preg_replace('/^www\./', '', $b) ?? $b;

        return $a === $b || str_ends_with($a, '.' . $b) || str_ends_with($b, '.' . $a);
    }
}
