<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RequireTeamMembership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Als de gebruiker niet is ingelogd, laat de request doorgaan naar de volgende middleware
        // (waar de authenticatie middleware de gebruiker naar de login pagina zal sturen)
        if (!$user) {
            return $next($request);
        }

        // Als de gebruiker is ingelogd maar geen teams heeft (geen eigen teams en geen teams waar ze lid van zijn)
        if ($user->allTeams()->count() === 0) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Gebruik de huidige locale voor de redirect
            $locale = app()->getLocale();
            return redirect('/' . $locale . '/login')->with('error', 'Je hebt geen toegang tot het systeem. Neem contact op met een beheerder voor een uitnodiging.');
        }

        return $next($request);
    }
}
