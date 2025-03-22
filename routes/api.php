<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Gebruiker informatie route
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Laad de CRM API routes
require __DIR__ . '/../packages/movve/crm/routes/api.php';
