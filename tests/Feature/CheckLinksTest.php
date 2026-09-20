<?php

namespace Tests\Feature;

use App\Link;
use App\Ruin;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckLinksTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'link_checker.host_delay_ms' => 0,
            'link_checker.retry_delay_seconds' => 0,
            'services.slack.webhook' => 'https://hooks.slack.test/services/test',
        ]);
    }

    /**
     * @param list<mixed> $responses
     * @param array<string, bool> $options
     */
    private function runCheck(array $responses, array $options = []): MockHandler
    {
        $mock = new MockHandler($responses);
        $this->app->instance(Client::class, new Client(['handler' => HandlerStack::create($mock)]));

        $this->artisan('links:check', $options)->assertExitCode(0);

        return $mock;
    }

    /**
     * @return list<array{title: string, text: string}>
     */
    private function slackAttachments(MockHandler $mock): array
    {
        $request = $mock->getLastRequest();

        $this->assertNotNull($request);
        $this->assertSame('POST', $request->getMethod());

        return json_decode((string) $request->getBody(), true)['attachments'];
    }

    /**
     * @param list<array{title: string, text: string}> $attachments
     */
    private function attachmentText(array $attachments): string
    {
        return implode("\n", array_map(
            fn (array $attachment) => $attachment['title'] . "\n" . $attachment['text'],
            $attachments
        ));
    }

    public function test_unreachable_links_are_reported_to_slack()
    {
        $ruin = Ruin::factory()->create();

        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'https://healthy.example.com', 'last_status' => 'ok']);
        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'http://down.example.com', 'last_status' => 'ok']);

        $mock = $this->runCheck([
            new Response(200),
            new ConnectException('cURL error 52: Empty reply from server', new Request('GET', 'http://down.example.com')),
            new ConnectException('cURL error 52: Empty reply from server', new Request('GET', 'http://down.example.com')),
            new Response(200),
        ]);

        $attachments = $this->slackAttachments($mock);
        $text = $this->attachmentText($attachments);

        $this->assertStringContainsString('http://down.example.com (connection failed)', $text);
        $this->assertStringNotContainsString('https://healthy.example.com', $text);
        $this->assertStringContainsString('Ulaşılamayan linkler', $text);
    }

    public function test_nothing_is_sent_when_all_links_are_reachable()
    {
        $ruin = Ruin::factory()->create();

        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'https://healthy.example.com', 'last_status' => 'ok']);

        $mock = $this->runCheck([new Response(200)]);

        $this->assertSame('GET', $mock->getLastRequest()->getMethod());
    }

    public function test_blocked_links_are_reported_separately_from_dead_links()
    {
        $ruin = Ruin::factory()->create();

        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'https://gone.example.com', 'last_status' => 'ok']);
        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'https://forbidden.example.com', 'last_status' => 'ok']);
        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'https://rate-limited.example.com', 'last_status' => 'ok']);
        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'https://broken.example.com', 'last_status' => 'ok']);

        $mock = $this->runCheck([
            new Response(404),
            new Response(403),
            new Response(429),
            new Response(429),
            new Response(500),
            new Response(500),
            new Response(200),
        ]);

        $text = $this->attachmentText($this->slackAttachments($mock));

        $this->assertStringContainsString('https://gone.example.com (HTTP 404)', $text);
        $this->assertStringContainsString('https://broken.example.com (HTTP 500)', $text);
        $this->assertStringContainsString('https://forbidden.example.com (HTTP 403)', $text);
        $this->assertStringContainsString('Ulaşılamayan linkler', $text);
        $this->assertStringContainsString('Engellenen linkler', $text);

        // Rate limits are the checker's own footprint, not news.
        $this->assertStringNotContainsString('https://rate-limited.example.com', $text);
        $this->assertStringContainsString('1 oran sınırlı', $text);
    }

    public function test_ssl_errors_are_reported_as_ssl_problem()
    {
        $ruin = Ruin::factory()->create();

        Link::factory()->create([
            'ruin_id' => $ruin->id,
            'url' => 'https://expired.example.com',
            'last_status' => 'ok',
        ]);

        $mock = $this->runCheck([
            new RequestException(
                'cURL error 60: SSL certificate problem: certificate has expired',
                new Request('GET', 'https://expired.example.com')
            ),
            new Response(200),
        ]);

        $text = $this->attachmentText($this->slackAttachments($mock));

        $this->assertStringContainsString('https://expired.example.com (SSL error)', $text);
        $this->assertStringContainsString('Sertifika sorunu olan linkler', $text);
    }

    public function test_scheme_less_url_is_checked_as_https_first()
    {
        $mock = new MockHandler([new Response(200)]);
        $container = [];
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($container));

        $this->app->instance(Client::class, new Client(['handler' => $stack]));

        $ruin = Ruin::factory()->create();

        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'www.example.com/page']);

        $this->artisan('links:check')->assertExitCode(0);

        $this->assertCount(1, $container);
        $this->assertSame('https', $container[0]['request']->getUri()->getScheme());
    }

    public function test_unexpected_errors_do_not_abort_the_run()
    {
        $ruin = Ruin::factory()->create();

        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'https://weird.example.com', 'last_status' => 'ok']);
        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'https://gone.example.com', 'last_status' => 'ok']);

        $mock = $this->runCheck([
            new \RuntimeException('boom'),
            new Response(404),
            new Response(200),
        ]);

        $text = $this->attachmentText($this->slackAttachments($mock));

        $this->assertStringContainsString('https://weird.example.com (check failed)', $text);
        $this->assertStringContainsString('https://gone.example.com (HTTP 404)', $text);
        $this->assertStringContainsString('Kontrol edilemeyen linkler', $text);
    }

    public function test_first_run_establishes_a_silent_baseline()
    {
        $ruin = Ruin::factory()->create();

        $link = Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'https://gone.example.com']);

        $mock = $this->runCheck([new Response(404), new Response(200)]);

        $this->assertSame('GET', $mock->getLastRequest()->getMethod());
        $this->assertSame('dead', $link->fresh()->last_status);
        $this->assertSame('HTTP 404', $link->fresh()->last_reason);
        $this->assertNotNull($link->fresh()->last_checked_at);
    }

    public function test_repeated_failures_do_not_notify()
    {
        $ruin = Ruin::factory()->create();

        $link = Link::factory()->create([
            'ruin_id' => $ruin->id,
            'url' => 'https://gone.example.com',
            'last_status' => 'dead',
            'last_reason' => 'HTTP 404',
        ]);

        $mock = $this->runCheck([new Response(404), new Response(200)]);

        $this->assertSame('GET', $mock->getLastRequest()->getMethod());
        $this->assertSame('dead', $link->fresh()->last_status);
    }

    public function test_recovery_is_reported()
    {
        $ruin = Ruin::factory()->create();

        $link = Link::factory()->create([
            'ruin_id' => $ruin->id,
            'url' => 'https://gone.example.com',
            'last_status' => 'dead',
            'last_reason' => 'HTTP 404',
        ]);

        $mock = $this->runCheck([new Response(200), new Response(200)]);

        $text = $this->attachmentText($this->slackAttachments($mock));

        $this->assertStringContainsString('Düzelen linkler', $text);
        $this->assertStringContainsString('https://gone.example.com (önceki: HTTP 404)', $text);
        $this->assertSame('ok', $link->fresh()->last_status);
    }

    public function test_rate_limited_links_are_not_reported()
    {
        $ruin = Ruin::factory()->create();

        $link = Link::factory()->create([
            'ruin_id' => $ruin->id,
            'url' => 'https://rate-limited.example.com',
            'last_status' => 'ok',
        ]);

        $mock = $this->runCheck([new Response(429), new Response(429), new Response(200)]);

        $this->assertSame('GET', $mock->getLastRequest()->getMethod());
        $this->assertSame('rate-limited', $link->fresh()->last_status);
    }

    public function test_known_blocked_hosts_are_not_reported()
    {
        $ruin = Ruin::factory()->create();

        $link = Link::factory()->create([
            'ruin_id' => $ruin->id,
            'url' => 'https://www.britannica.com/place/Assus',
            'last_status' => 'ok',
        ]);

        $mock = $this->runCheck([new Response(403), new Response(200)]);

        $this->assertSame('GET', $mock->getLastRequest()->getMethod());
        $this->assertSame('blocked', $link->fresh()->last_status);
    }

    public function test_known_blocked_host_still_reports_dead_links()
    {
        $ruin = Ruin::factory()->create();

        Link::factory()->create([
            'ruin_id' => $ruin->id,
            'url' => 'https://www.britannica.com/place/Assus',
            'last_status' => 'blocked',
            'last_reason' => 'HTTP 403',
        ]);

        $mock = $this->runCheck([new Response(404), new Response(200)]);

        $text = $this->attachmentText($this->slackAttachments($mock));

        $this->assertStringContainsString('https://www.britannica.com/place/Assus (HTTP 404)', $text);
        $this->assertStringContainsString('Ulaşılamayan linkler', $text);
    }

    public function test_known_blocked_hosts_are_counted_separately_in_summary()
    {
        $ruin = Ruin::factory()->create();

        Link::factory()->create([
            'ruin_id' => $ruin->id,
            'url' => 'https://www.britannica.com/place/Assus',
            'last_status' => 'ok',
        ]);
        Link::factory()->create([
            'ruin_id' => $ruin->id,
            'url' => 'https://gone.example.com',
            'last_status' => 'ok',
        ]);

        $mock = $this->runCheck([new Response(403), new Response(404), new Response(200)]);

        $text = $this->attachmentText($this->slackAttachments($mock));

        $this->assertStringContainsString('1 ulaşılamıyor', $text);
        $this->assertStringContainsString('1 bilinen bot koruması (gizlendi)', $text);
        $this->assertStringNotContainsString('1 engelli', $text);
    }

    public function test_archive_org_404_is_not_reported_as_dead()
    {
        $ruin = Ruin::factory()->create();

        $link = Link::factory()->create([
            'ruin_id' => $ruin->id,
            'url' => 'https://web.archive.org/web/20150505175447/http://arkeolojihaber.net/tag/neandria-antik-kenti/',
            'last_status' => 'ok',
        ]);

        $mock = $this->runCheck([new Response(404), new Response(200)]);

        $this->assertSame('GET', $mock->getLastRequest()->getMethod());
        $this->assertSame('blocked', $link->fresh()->last_status);
        $this->assertSame('HTTP 404 (archive.org)', $link->fresh()->last_reason);
    }

    public function test_duplicate_urls_are_checked_once_and_reported_with_ruin_context()
    {
        $first = Ruin::factory()->create();
        $second = Ruin::factory()->create();

        Link::factory()->create(['ruin_id' => $first->id, 'url' => 'https://gone.example.com', 'last_status' => 'ok']);
        Link::factory()->create(['ruin_id' => $second->id, 'url' => 'https://gone.example.com', 'last_status' => 'ok']);

        $mock = new MockHandler([new Response(404), new Response(200)]);
        $container = [];
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($container));

        $this->app->instance(Client::class, new Client(['handler' => $stack]));

        $this->artisan('links:check')->assertExitCode(0);

        $gets = array_filter($container, fn (array $transaction) => $transaction['request']->getMethod() === 'GET');
        $this->assertCount(1, $gets);

        $text = $this->attachmentText($this->slackAttachments($mock));

        $this->assertStringContainsString($first->name, $text);
        $this->assertStringContainsString($second->name, $text);
        $this->assertSame(1, substr_count($text, 'https://gone.example.com'));
    }

    public function test_transient_server_error_is_retried_and_not_reported()
    {
        $ruin = Ruin::factory()->create();

        $link = Link::factory()->create([
            'ruin_id' => $ruin->id,
            'url' => 'https://flaky.example.com',
            'last_status' => 'ok',
        ]);

        $mock = $this->runCheck([new Response(503), new Response(200)]);

        $this->assertSame('GET', $mock->getLastRequest()->getMethod());
        $this->assertSame('ok', $link->fresh()->last_status);
    }

    public function test_report_all_lists_every_failing_link()
    {
        $ruin = Ruin::factory()->create();

        Link::factory()->create([
            'ruin_id' => $ruin->id,
            'url' => 'https://gone.example.com',
            'last_status' => 'dead',
            'last_reason' => 'HTTP 404',
        ]);

        $mock = $this->runCheck([new Response(404), new Response(200)], ['--report-all' => true]);

        $text = $this->attachmentText($this->slackAttachments($mock));

        $this->assertStringContainsString('https://gone.example.com (HTTP 404)', $text);
        $this->assertStringContainsString('Ulaşılamayan linkler', $text);
    }

    public function test_redirect_to_another_site_is_reported()
    {
        $ruin = Ruin::factory()->create();

        $link = Link::factory()->create([
            'ruin_id' => $ruin->id,
            'url' => 'https://old.example.com/page',
            'last_status' => 'ok',
        ]);

        $mock = $this->runCheck([
            new Response(301, ['Location' => 'https://squatter.example.net/']),
            new Response(200),
            new Response(200),
        ]);

        $text = $this->attachmentText($this->slackAttachments($mock));

        $this->assertStringContainsString('Farklı siteye yönlenen linkler', $text);
        $this->assertStringContainsString('https://old.example.com/page (→ squatter.example.net)', $text);
        $this->assertSame('redirected', $link->fresh()->last_status);
    }

    public function test_dry_run_does_not_notify_or_store()
    {
        $ruin = Ruin::factory()->create();

        $link = Link::factory()->create([
            'ruin_id' => $ruin->id,
            'url' => 'https://gone.example.com',
            'last_status' => 'ok',
        ]);

        $mock = $this->runCheck([new Response(404)], ['--dry-run' => true]);

        $this->assertSame('GET', $mock->getLastRequest()->getMethod());
        $this->assertSame('ok', $link->fresh()->last_status);
    }

    public function test_only_option_limits_checks_to_matching_urls()
    {
        $ruin = Ruin::factory()->create();

        $checked = Link::factory()->create([
            'ruin_id' => $ruin->id,
            'url' => 'https://only.example.com/page',
            'last_status' => 'ok',
        ]);
        $untouched = Link::factory()->create([
            'ruin_id' => $ruin->id,
            'url' => 'https://other.example.com/page',
            'last_status' => 'dead',
            'last_reason' => 'HTTP 404',
        ]);

        $this->runCheck([new Response(404), new Response(200)], ['--only' => 'only.example.com']);

        $this->assertSame('dead', $checked->fresh()->last_status);
        $this->assertSame('dead', $untouched->fresh()->last_status);
        $this->assertSame('HTTP 404', $untouched->fresh()->last_reason);
    }

    public function test_missing_webhook_prints_the_report_instead()
    {
        config(['services.slack.webhook' => '']);

        $ruin = Ruin::factory()->create();

        Link::factory()->create([
            'ruin_id' => $ruin->id,
            'url' => 'https://gone.example.com',
            'last_status' => 'ok',
        ]);

        $mock = new MockHandler([new Response(404)]);
        $this->app->instance(Client::class, new Client(['handler' => HandlerStack::create($mock)]));

        $this->artisan('links:check')
            ->expectsOutputToContain('SLACK_WEBHOOK')
            ->assertExitCode(0);

        $this->assertSame('GET', $mock->getLastRequest()->getMethod());
    }
}
