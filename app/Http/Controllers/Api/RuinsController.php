<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Ruin as RuinResource;
use App\Http\Resources\RuinCollection;
use App\Ruin;
use App\Http\Controllers\Controller;

class RuinsController extends Controller
{
    public function index()
    {
        return new RuinCollection(Ruin::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $locale, Ruin $ruin)
    {
        return new RuinResource($ruin);
    }
}
