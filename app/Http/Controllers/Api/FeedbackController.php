<?php

namespace App\Http\Controllers\Api;

use App\Feedback;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    public function store()
    {
        return Feedback::create([
            'ruin_id' => request('ruin_id'),
            'ruin'    => request('ruin'),
            'body'    => request('body')
        ]);
    }
}
