<?php

namespace App\Http\Controllers;

use App\Ruin;

class RuinsController extends Controller
{
    public function show(string $locale, Ruin $ruin)
    {
        return view('ruins.show', ['ruin' => $ruin]);
    }
}
