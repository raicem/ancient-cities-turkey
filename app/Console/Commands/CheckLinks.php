<?php

namespace App\Console\Commands;

use App\Link;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Console\Command;

class CheckLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'links:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks links in the system about their availability.';

    /**
     * Execute the console command.
     */
    public function handle(Client $client): void
    {
        $links = Link::all();

        $dead = [];
        $blocked = [];

        foreach ($links as $link) {
            $candidates = self::candidateUrls($link->url);

            foreach ($candidates as $url) {
                $this->info('Checking link: ' . $url);
                $outcome = $this->checkUrl($client, $url);

                if ($outcome === null) {
                    break;
                }

                // Only report after the last candidate failed; an https
                // failure for a scheme-less URL is retried as http.
                if ($url === end($candidates)) {
                    [$bucket, $reason] = $outcome;

                    if ($bucket === 'dead') {
                        $dead[] = "{$link->url} ({$reason})";
                    } else {
                        $blocked[] = "{$link->url} ({$reason})";
                    }
                }
            }
        }

        if ($dead === [] && $blocked === []) {
            return;
        }

        $attachments = [];

        if ($dead !== []) {
            $attachments[] = ['title' => 'Ulaşılamıyor', 'text' => implode(" \n ", $dead)];
        }

        if ($blocked !== []) {
            $attachments[] = ['title' => 'Engellendi / elle kontrol gerekli (bot koruması olabilir)', 'text' => implode(" \n ", $blocked)];
        }

        $message = [
            'text' => 'Bu linklere ulaşılamıyor',
            'attachments' => $attachments,
            'channel' => '#genel',
        ];

        $client->request('POST', config('services.slack.webhook'), [
            'json' => $message,
        ]);
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
     * @return null|array{string, string} Null when reachable, else [bucket, reason]
     *                                   where bucket is 'dead' or 'blocked'.
     */
    private function checkUrl(Client $client, string $url): ?array
    {
        try {
            $response = $client->request('GET', $url, [
                'timeout' => 20,
                'http_errors' => false,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml',
                    'Accept-Language' => 'en-US,en;q=0.9,tr;q=0.8',
                ],
            ]);

            return self::classifyStatus($response->getStatusCode());
        } catch (ConnectException $e) {
            return ['dead', 'connection failed'];
        } catch (TransferException $e) {
            if ($e instanceof RequestException) {
                $response = $e->getResponse();

                if ($response !== null) {
                    return self::classifyStatus($response->getStatusCode()) ?? ['blocked', 'request failed'];
                }
            }

            if (str_contains($e->getMessage(), 'SSL') || str_contains($e->getMessage(), 'certificate')) {
                return ['blocked', 'SSL error'];
            }

            return ['blocked', 'request failed'];
        } catch (\Throwable $e) {
            report($e);

            return ['blocked', 'check failed'];
        }
    }

    /**
     * @return null|array{string, string} Null when reachable, else [bucket, reason].
     */
    private static function classifyStatus(int $status): ?array
    {
        if ($status < 400) {
            return null;
        }

        if ($status === 404 || $status === 410 || $status >= 500) {
            return ['dead', "HTTP {$status}"];
        }

        return ['blocked', "HTTP {$status}"];
    }
}
