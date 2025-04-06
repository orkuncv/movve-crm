<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Haal de locale uit de route parameter, session, of gebruik de standaard (Engels)
        $locale = $request->route('locale') ?? Session::get('locale') ?? config('app.fallback_locale', 'en');
        
        // Zorg ervoor dat de locale geldig is
        if (!array_key_exists($locale, config('app.available_locales', ['en' => 'English']))) {
            $locale = config('app.fallback_locale', 'en');
        }
        
        // Gebruik een directe URL in plaats van route helpers om problemen met dubbele API prefixes te voorkomen
        return '/' . $locale . '/login';
    }
}
