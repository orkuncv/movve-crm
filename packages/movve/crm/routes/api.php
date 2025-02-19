<?php

use Illuminate\Support\Facades\Route;
use Movve\Crm\Http\Controllers\ContactController;

Route::prefix('api/crm')
    ->middleware(['auth:sanctum', 'crm.permission'])
    ->name('crm.')
    ->group(function () {
        Route::apiResource('contacts', ContactController::class);
        Route::post('contacts/{id}/restore', [ContactController::class, 'restore'])->name('contacts.restore');
    });
