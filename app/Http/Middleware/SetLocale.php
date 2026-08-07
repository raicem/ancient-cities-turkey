<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->route() && $request->route()->hasParameter('locale')) {
            App::setLocale($request->route()->parameter('locale'));
        }

        return $next($request);
    }
}
