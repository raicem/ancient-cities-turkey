<?php

namespace Tests\Feature;

use App\Ruin;
use App\Feedback;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserCanSendFeedbackTest extends TestCase
{
    use RefreshDatabase;

    public function testUsersCanSendFeedbackAboutARuin()
    {
        $feedback = factory(Feedback::class)->make();
        $this->post('/api/feedback', $feedback->toArray())->assertStatus(200);
        $this->assertDatabaseHas('feedback', [
            'body' => $feedback->body
        ]);
    }
}
