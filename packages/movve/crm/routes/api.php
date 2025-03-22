<?php

use Illuminate\Support\Facades\Route;

// Legacy API routes (behouden voor backward compatibility)
Route::prefix('crm')
    ->middleware(['auth:sanctum'])
    ->name('crm.api.')
    ->group(function () {
        // Hier kunnen API routes worden toegevoegd indien nodig
    });
