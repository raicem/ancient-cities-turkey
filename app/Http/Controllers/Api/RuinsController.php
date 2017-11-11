<?php

namespace App\Http\Controllers\Api;

use App\Ruin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RuinsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($language)
    {
        $ruins = Ruin::select('name', 'name_tr', 'slug', 'latitude', 'longitude')->get();
        
        if ($language === 'tr') {
            $ruins->map(function ($item) {
                $item['name'] = $item['name_tr'];
            });
        }

        return $ruins;
    }

    /**
     * Display the specified resource.
     */
    public function show($language = 'en', Ruin $ruin)
    {
        $ruin = Ruin::with('turkishLinks', 'englishLinks')->find($ruin->id);
        
        if ($language === 'tr') {
            return $ruin->asTurkish();
        }

        return $ruin->asEnglish();
    }
}
