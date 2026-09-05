<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Ruin as RuinResource;
use App\Http\Resources\RuinCollection;
use App\Ruin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RuinsController extends Controller
{
    public function index(Request $request)
    {
        // Ruin coordinates change rarely: allow the edge to serve this for
        // an hour and revalidate in the background for up to a day.
        $response = (new RuinCollection(Ruin::with('city')->get()))->response($request);
        $response->setPublic();
        $response->setMaxAge(600);
        $response->setSharedMaxAge(3600);
        $response->headers->addCacheControlDirective('stale-while-revalidate', '86400');

        return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $locale, Ruin $ruin)
    {
        return new RuinResource($ruin);
    }
}
