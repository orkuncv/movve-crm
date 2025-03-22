<?php

use Illuminate\Support\Facades\Route;
use Movve\Crm\Http\Controllers\Api\ContactController;

// API routes voor CRM
Route::prefix('api')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::apiResource('contacts', ContactController::class);
    });

// Legacy API routes (behouden voor backward compatibility)
Route::prefix('api/crm')
    ->middleware(['auth:sanctum', 'crm.permission'])
    ->name('crm.')
    ->group(function () {
        Route::apiResource('contacts', '\\Movve\\Crm\\Http\\Controllers\\ContactController');
        Route::post('contacts/{id}/restore', ['\\Movve\\Crm\\Http\\Controllers\\ContactController', 'restore'])->name('contacts.restore');
    });
