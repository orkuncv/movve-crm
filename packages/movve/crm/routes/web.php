<?php

use Illuminate\Support\Facades\Route;
use Movve\Crm\Http\Controllers\ContactViewController;
use App\Http\Middleware\LocaleMiddleware;

// Non-localized routes (for API or redirects)
Route::middleware(['web', 'auth:sanctum', 'verified'])
    ->prefix('crm')
    ->name('crm.')
    ->group(function () {
        // Redirect to localized version
        Route::get('/contacts', function () {
            return redirect(app()->getLocale() . '/crm/contacts');
        })->name('contacts.redirect');
    });

// Localized routes
Route::prefix('{locale}/crm')
    ->where(['locale' => '[a-zA-Z]{2}'])
    ->middleware(['web', 'auth:sanctum', 'verified', LocaleMiddleware::class])
    ->name('crm.')
    ->group(function () {
        Route::get('/contacts', [ContactViewController::class, 'index'])->name('contacts.index');
        Route::get('/contacts/create', [ContactViewController::class, 'create'])->name('contacts.create');
        Route::post('/contacts', [ContactViewController::class, 'store'])->name('contacts.store');
        Route::get('/contacts/{contact}/edit', [ContactViewController::class, 'edit'])->name('contacts.edit');
        Route::put('/contacts/{contact}', [ContactViewController::class, 'update'])->name('contacts.update');
        Route::get('/contacts/{contact}', [ContactViewController::class, 'show'])->name('contacts.show');
    });
