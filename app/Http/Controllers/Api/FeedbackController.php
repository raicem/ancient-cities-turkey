<?php

namespace App\Http\Controllers\Api;

use App\Feedback;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    public function store(\GuzzleHttp\Client $client)
    {
        $validated = request()->validate([
            'ruin_id' => ['required', 'integer', 'exists:ruins,id'],
            'ruin' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $message = [
            'text' => 'Yeni geri bildirim!',
            'attachments' => [
                ['text' => "Lokasyon: " . $validated['ruin'] . " \n " . "Mesaj: " . $validated['body']]
            ],
            'channel' => '#ancientcitiesturkey'
        ];

        $client->request('POST', config('services.slack.webhook'), [
            'json' => $message,
        ]);

        return Feedback::create($validated);
    }
}
