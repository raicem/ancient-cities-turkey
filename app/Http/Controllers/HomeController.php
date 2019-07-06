<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    public function __invoke($locale = 'tr')
    {
        App::setLocale($locale);

        return view('ruins.index');
    }
}
