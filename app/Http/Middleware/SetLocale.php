<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function handle($request, Closure $next)
    {
        if ($request->route()->hasParameter('locale')) {
            \App::setLocale($request->route()->parameter('locale'));
        }

        return $next($request);
    }
}
