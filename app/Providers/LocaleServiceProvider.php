<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

class LocaleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Add locale to all named routes
        Route::matched(function ($route) {
            if ($route->route && $route->route->getName() !== 'language.switch') {
                URL::defaults(['locale' => App::getLocale()]);
            }
        });
    }
}
