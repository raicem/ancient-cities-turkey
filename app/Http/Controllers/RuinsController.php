<?php

namespace App\Http\Controllers;

use App\Ruin;
use Illuminate\Support\Facades\App;

class RuinsController extends Controller
{
    public function sitemap()
    {
        return view('index', [
            'ruins' => Ruin::all()
        ]);
    }

    public function index($locale)
    {
        App::setLocale($locale);

        return view('home');
    }
}
