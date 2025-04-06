<?php

namespace Movve\Crm\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Als de gebruiker niet is ingelogd, redirect naar de login pagina met de juiste locale
        if (!Auth::check()) {
            // Haal de locale uit de route parameter of gebruik de standaard (Engels)
            $locale = $request->route('locale') ?? app()->getLocale() ?? 'en';
            
            // Redirect naar de login pagina met de juiste locale
            return redirect('/' . $locale . '/login');
        }
        
        return $next($request);
    }
}
