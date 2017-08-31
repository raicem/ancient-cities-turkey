<?php

namespace App\Http\Controllers;

use App\Ruin;

class RuinsController extends Controller
{
    public function sitemap()
    {
        return view('index', [
            'ruins' => Ruin::all()
        ]);
    }

    public function index()
    {
        return view('home');
    }
}
