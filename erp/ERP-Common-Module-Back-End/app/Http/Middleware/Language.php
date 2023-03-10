<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = ($request->hasHeader('X-localization')) ? $request->header('X-localization') : 'en';
        app()->setLocale($locale);
        return $next($request);
    }
}
