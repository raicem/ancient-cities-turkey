<?php

namespace App\Http\Controllers;

use App\Http\Resources\RuinCollection;
use App\Ruin;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        // Inline the ruins list so the SPA can render markers without a
        // blocking API round-trip. Serialized after SetLocale, so names are
        // in the request locale.
        $ruins = (new RuinCollection(Ruin::with('city')->get()))->toArray($request);

        // Fully URL-determined and cookie-free: safe for the edge to cache
        // per URL (locale is part of the path).
        $response = response()->view('ruins.index', ['initialRuins' => $ruins]);
        $response->setPublic();
        $response->setMaxAge(600);
        $response->setSharedMaxAge(3600);
        $response->headers->addCacheControlDirective('stale-while-revalidate', '86400');

        return $response;
    }
}
