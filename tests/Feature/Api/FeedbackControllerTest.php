<?php

namespace Tests\Feature\Api;

use App\Feedback;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedbackControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_send_feedback_about_a_ruin()
    {
        $mock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], 'Hello, World'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $this->app->instance(Client::class, $client);

        $feedback = factory(Feedback::class)->make();

        $this->post('/api/feedback', $feedback->toArray())->assertStatus(201);

        $this->assertDatabaseHas('feedback', [
            'body' => $feedback->body
        ]);
    }
}
