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

    public function test_unreachable_links_are_reported_to_slack()
    {
        $mock = new MockHandler([
            new Response(200),
            new ConnectException(
                'cURL error 52: Empty reply from server',
                new Request('GET', 'http://down.example.com')
            ),
            new Response(200),
        ]);

        $client = new Client(['handler' => HandlerStack::create($mock)]);

        $this->app->instance(Client::class, $client);

        $ruin = Ruin::factory()->create();

        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'https://healthy.example.com']);
        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'http://down.example.com']);

        $this->artisan('links:check')->assertExitCode(0);

        $slackRequest = $mock->getLastRequest();

        $attachment = json_decode((string) $slackRequest->getBody(), true)['attachments'][0]['text'];

        $this->assertStringContainsString('http://down.example.com', $attachment);
        $this->assertStringNotContainsString('https://healthy.example.com', $attachment);
    }

    public function test_nothing_is_sent_when_all_links_are_reachable()
    {
        $mock = new MockHandler([
            new Response(200),
        ]);

        $client = new Client(['handler' => HandlerStack::create($mock)]);

        $this->app->instance(Client::class, $client);

        $ruin = Ruin::factory()->create();

        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'https://healthy.example.com']);

        $this->artisan('links:check')->assertExitCode(0);

        $this->assertSame('GET', $mock->getLastRequest()->getMethod());
    }

    public function test_blocked_links_are_reported_separately_from_dead_links()
    {
        $mock = new MockHandler([
            new Response(404),
            new Response(403),
            new Response(429),
            new Response(500),
            new Response(200),
        ]);

        $client = new Client(['handler' => HandlerStack::create($mock)]);

        $this->app->instance(Client::class, $client);

        $ruin = Ruin::factory()->create();

        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'https://gone.example.com']);
        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'https://forbidden.example.com']);
        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'https://rate-limited.example.com']);
        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'https://broken.example.com']);

        $this->artisan('links:check')->assertExitCode(0);

        $body = json_decode((string) $mock->getLastRequest()->getBody(), true);

        $this->assertCount(2, $body['attachments']);

        $dead = $body['attachments'][0]['text'];
        $blocked = $body['attachments'][1]['text'];

        $this->assertStringContainsString('https://gone.example.com (HTTP 404)', $dead);
        $this->assertStringContainsString('https://broken.example.com (HTTP 500)', $dead);
        $this->assertStringNotContainsString('forbidden.example.com', $dead);
        $this->assertStringNotContainsString('rate-limited.example.com', $dead);

        $this->assertStringContainsString('https://forbidden.example.com (HTTP 403)', $blocked);
        $this->assertStringContainsString('https://rate-limited.example.com (HTTP 429)', $blocked);
        $this->assertStringNotContainsString('gone.example.com', $blocked);
        $this->assertStringNotContainsString('broken.example.com', $blocked);
    }

    public function test_ssl_errors_are_reported_as_blocked()
    {
        $mock = new MockHandler([
            new RequestException(
                'cURL error 60: SSL certificate problem: certificate has expired',
                new Request('GET', 'https://expired.example.com')
            ),
            new Response(200),
        ]);

        $client = new Client(['handler' => HandlerStack::create($mock)]);

        $this->app->instance(Client::class, $client);

        $ruin = Ruin::factory()->create();

        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'https://expired.example.com']);

        $this->artisan('links:check')->assertExitCode(0);

        $body = json_decode((string) $mock->getLastRequest()->getBody(), true);

        $this->assertCount(1, $body['attachments']);
        $this->assertStringContainsString('https://expired.example.com (SSL error)', $body['attachments'][0]['text']);
    }

    public function test_scheme_less_url_is_checked_as_https_first()
    {
        $mock = new MockHandler([
            new Response(200),
        ]);

        $container = [];
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($container));

        $client = new Client(['handler' => $stack]);

        $this->app->instance(Client::class, $client);

        $ruin = Ruin::factory()->create();

        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'www.example.com/page']);

        $this->artisan('links:check')->assertExitCode(0);

        $this->assertCount(1, $container);
        $this->assertSame('https', $container[0]['request']->getUri()->getScheme());
    }

    public function test_unexpected_errors_do_not_abort_the_run()
    {
        $mock = new MockHandler([
            new \RuntimeException('boom'),
            new Response(404),
            new Response(200),
        ]);

        $client = new Client(['handler' => HandlerStack::create($mock)]);

        $this->app->instance(Client::class, $client);

        $ruin = Ruin::factory()->create();

        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'https://weird.example.com']);
        Link::factory()->create(['ruin_id' => $ruin->id, 'url' => 'https://gone.example.com']);

        $this->artisan('links:check')->assertExitCode(0);

        $body = json_decode((string) $mock->getLastRequest()->getBody(), true);

        $this->assertCount(2, $body['attachments']);
        $this->assertStringContainsString('https://gone.example.com (HTTP 404)', $body['attachments'][0]['text']);
        $this->assertStringContainsString('https://weird.example.com (check failed)', $body['attachments'][1]['text']);
    }
}
