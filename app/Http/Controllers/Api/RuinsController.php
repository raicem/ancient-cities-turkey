<?php

namespace App\Http\Controllers\Api;

use App\Ruin;
use App\Http\Controllers\Controller;

class RuinsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($locale)
    {
        $ruins = Ruin::select('name', 'name_tr', 'slug', 'latitude', 'longitude')->get();

        if ($locale === 'tr') {
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
    public function show($locale = 'en', Ruin $ruin)
    {
        $ruin = Ruin::with('turkishLinks', 'englishLinks')->find($ruin->id);

        if ($locale === 'tr') {
            return $ruin->asTurkish();
        }

        return $ruin->asEnglish();
    }
}
