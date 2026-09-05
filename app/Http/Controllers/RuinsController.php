<?php

namespace App\Http\Controllers;

use App\Http\Resources\RuinCollection;
use App\Ruin;
use Illuminate\Http\Request;

class RuinsController extends Controller
{
    public function show(Request $request, string $locale, Ruin $ruin)
    {
        $ruins = (new RuinCollection(Ruin::with('city')->get()))->toArray($request);

        // Fully URL-determined and cookie-free: safe for the edge to cache
        // per URL (locale and slug are part of the path).
        $response = response()->view('ruins.show', ['ruin' => $ruin, 'initialRuins' => $ruins]);
        $response->setPublic();
        $response->setMaxAge(600);
        $response->setSharedMaxAge(3600);
        $response->headers->addCacheControlDirective('stale-while-revalidate', '86400');

        return $response;
    }
}
