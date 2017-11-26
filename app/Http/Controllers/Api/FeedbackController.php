<?php

namespace App\Http\Controllers\Api;

use App\Feedback;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    public function store(\GuzzleHttp\Client $client)
    {
        $message = [
            'text' => 'Yeni geri bildirim!',
            'attachments' => [
                ['text' => "Lokasyon: " . request('ruin') . " \n " . "Mesaj: " . request('body')]
            ],
            'channel' => '#genel'
        ];

        $client->request('POST', config('services.slack.webhook'), [
            'json' => $message,
        ]);

        return Feedback::create([
            'ruin_id' => request('ruin_id'),
            'ruin'    => request('ruin'),
            'body'    => request('body')
        ]);
    }
}
