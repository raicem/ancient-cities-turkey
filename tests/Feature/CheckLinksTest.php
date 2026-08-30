<?php

namespace Tests\Feature;

use App\Link;
use App\Ruin;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
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
            new \GuzzleHttp\Exception\ConnectException(
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
}
