<?php

namespace Tests\Feature;

use App\Ruin;
use App\Feedback;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserCanSendFeedbackTest extends TestCase
{
    use DatabaseMigrations;
    
    public function testUsersCanSendFeedbackAboutARuin()
    {
        $feedback = factory(Feedback::class)->make();
        $this->post('/api/feedback', $feedback->toArray())->assertStatus(200);
        $this->assertDatabaseHas('feedback', [
            'body' => $feedback->body
        ]);
    }
}