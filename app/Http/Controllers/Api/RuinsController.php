<?php

namespace App\Http\Controllers\Api;

use App\Ruin;
use App\Http\Controllers\Controller;

class RuinsController extends Controller
{
    public function index()
    {
        $ruins = Ruin::select('name', 'name_tr', 'slug', 'latitude', 'longitude')->get();

        if (app()->getLocale() === 'tr') {
            $ruins->map(function ($item) {
                $item['name'] = $item['name_tr'];
                unset($item['name_tr']);
            });
        }

        return $ruins;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $locale, Ruin $ruin)
    {
        $ruin = Ruin::with('turkishLinks', 'englishLinks')->find($ruin->id);

        if (app()->getLocale() === 'tr') {
            return $ruin->asTurkish();
        }

        return $ruin->asEnglish();
    }
}
