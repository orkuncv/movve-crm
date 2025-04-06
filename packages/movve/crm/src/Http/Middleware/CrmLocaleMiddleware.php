<?php

namespace Movve\Crm\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class CrmLocaleMiddleware
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
        // Haal de locale uit de route parameter
        $locale = $request->route('locale');
        
        // Controleer of de locale geldig is (bijvoorbeeld: en, nl, tr, ru, etc.)
        if ($locale && array_key_exists($locale, config('app.available_locales', ['en' => 'English']))) {
            // Stel de applicatie locale in
            App::setLocale($locale);
            
            // Sla de locale op in de sessie voor toekomstige requests
            Session::put('locale', $locale);
        } else {
            // Gebruik de locale uit de sessie als fallback
            $sessionLocale = Session::get('locale');
            if ($sessionLocale && array_key_exists($sessionLocale, config('app.available_locales', ['en' => 'English']))) {
                App::setLocale($sessionLocale);
            } else {
                // Gebruik de standaard locale als er geen geldige locale is gevonden
                App::setLocale(config('app.fallback_locale', 'en'));
            }
        }
        
        return $next($request);
    }
}
