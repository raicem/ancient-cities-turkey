<?php

namespace App\Http\Controllers;

use App\Ruin;

class RuinsController extends Controller
{
    public function show(string $locale, Ruin $ruin)
    {
        if (app()->getLocale() === 'en') {
            $ruin = $ruin->asEnglish();
        } else {
            $ruin = $ruin->asTurkish();
        }

        return view('ruins.show', compact('ruin'));
    }
}
