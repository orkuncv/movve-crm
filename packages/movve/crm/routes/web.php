<?php

use Illuminate\Support\Facades\Route;
use Movve\Crm\Http\Controllers\ContactViewController;

Route::group([
    'prefix' => '{locale}/crm',
    'where' => ['locale' => '[a-zA-Z]{2}'],
    'middleware' => ['web', 'auth:sanctum', 'verified']
], function () {
    // Debug route
    Route::get('/debug', function() {
        return 'CRM routes loaded. Current locale: ' . request()->segment(1);
    });

    // Contact routes - let op de volgorde is belangrijk!
    Route::get('/contacts', [ContactViewController::class, 'index'])->name('crm.contacts.index');
    Route::get('/contacts/create', [ContactViewController::class, 'create'])->name('crm.contacts.create');
    Route::post('/contacts', [ContactViewController::class, 'store'])->name('crm.contacts.store');
    
    // Specifieke routes voor show, edit en update met id parameter
    Route::get('/contacts/{id}', [ContactViewController::class, 'show'])->name('crm.contacts.show')->where('id', '[0-9]+');
    Route::get('/contacts/{id}/edit', [ContactViewController::class, 'edit'])->name('crm.contacts.edit')->where('id', '[0-9]+');
    Route::put('/contacts/{id}', [ContactViewController::class, 'update'])->name('crm.contacts.update')->where('id', '[0-9]+');
});

// Fallback redirect voor niet-gelokaliseerde routes
Route::get('/crm/{any}', function () {
    return redirect('/' . app()->getLocale() . '/crm/' . request()->path());
})->where('any', '.*');
