<?php

use App\Http\Controllers\LanguageController;
use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to localized home
Route::get('/', function () {
    return redirect(app()->getLocale());
});

Route::get('/{locale}/dashboard', function ($locale) {
    return redirect("/$locale/crm/dashboard");
})->name('dashboard');

// Language switcher
Route::get('language/{locale}', [LanguageController::class, 'switchLang'])
    ->name('language.switch')
    ->where('locale', '[a-zA-Z]{2}');

// Localized routes
Route::prefix('{locale}')
    ->where(['locale' => '[a-zA-Z]{2}'])
    ->middleware([LocaleMiddleware::class])
    ->group(function () {

        // Welcome/Home page
        Route::get('/', function () {
            return view('welcome');
        })->name('welcome');

        // Guest routes
        Route::middleware('guest')->group(function () {
            // Login
            Route::get('login', function () {
                return view('auth.login');
            })->name('login');

            Route::post('login', [AuthenticatedSessionController::class, 'store']);

            // Registration
            if (Features::enabled(Features::registration())) {
                Route::get('register', function () {
                    return view('auth.register');
                })->name('register');

                Route::post('register', [RegisteredUserController::class, 'store']);
            }
        });

        // Protected routes
        Route::middleware(['auth:sanctum', 'verified'])->group(function () {
            Route::get('dashboard', function () {
                return view('dashboard');
            })->name('dashboard');
        });
    });

// Deze route is verwijderd omdat deze conflicteert met de gelokaliseerde versie

// Overschrijf de Jetstream current-team route met onze aangepaste controller
Route::put('/current-team', [\App\Http\Controllers\CurrentTeamController::class, 'update'])
    ->middleware(['web', 'auth:sanctum', \Laravel\Jetstream\Http\Middleware\AuthenticateSession::class, 'verified'])
    ->name('current-team.update');
