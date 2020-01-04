<?php

namespace App\Http\Controllers;

use App\Ruin;
use Illuminate\Support\Facades\App;

class RuinsController extends Controller
{
    public function show(string $locale, Ruin $ruin)
    {
        App::setLocale($locale);

        if ($locale === 'en') {
            $ruin = $ruin->asEnglish();
        } else {
            $ruin = $ruin->asTurkish();
        }

        return view('ruins.show', compact('ruin'));
    }
}
