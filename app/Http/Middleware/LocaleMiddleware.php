<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from route parameter
        $locale = $request->route('locale');
        
        // If locale is not valid, redirect to default locale
        if (!$locale || !array_key_exists($locale, config('app.available_locales'))) {
            $segments = $request->segments();
            $segments[0] = config('app.fallback_locale', 'en');
            return redirect()->to(implode('/', $segments));
        }

        // Set the application locale
        App::setLocale($locale);
        
        // Store locale in session
        session()->put('locale', $locale);
        
        // Set URL defaults for route generation
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
