<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from route parameter, session, or use default (English)
        $locale = $request->route('locale') ?? Session::get('locale') ?? config('app.fallback_locale', 'en');
        
        // If locale is not valid, use default locale (English)
        if (!array_key_exists($locale, config('app.available_locales'))) {
            $locale = config('app.fallback_locale', 'en');
        }
        
        // If locale is in route parameter but doesn't match session, update session
        if ($request->route('locale') && $request->route('locale') !== Session::get('locale')) {
            Session::put('locale', $locale);
        }

        // Set the application locale
        App::setLocale($locale);
        
        // Set URL defaults for route generation
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
