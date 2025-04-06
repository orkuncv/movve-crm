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
        // Add locale to all named routes except for specific ones
        Route::matched(function ($route) {
            if ($route->route && !in_array($route->route->getName(), [
                'language.switch',
                'current-team.update',
                'team-members.store',
                'team-members.update',
                'team-members.destroy',
                'teams.store',
                'teams.update',
                'teams.destroy',
                'teams.create',
                'teams.show',
                'teams.edit',
                // CRM routes
                'crm.contacts.index',
                'crm.contacts.create',
                'crm.contacts.store',
                'crm.contacts.show',
                'crm.contacts.edit',
                'crm.contacts.update',
            ])) {
                URL::defaults(['locale' => App::getLocale()]);
            }
        });
    }
}
