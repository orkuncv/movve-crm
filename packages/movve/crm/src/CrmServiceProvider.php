<?php

namespace Movve\Crm;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Movve\Crm\Http\Livewire\ApiTokenManager;
use Movve\Crm\Http\Middleware\CheckCrmPermission;
use Movve\Crm\Providers\CrmPermissionsProvider;

class CrmServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(CrmPermissionsProvider::class);
    }

    public function boot()
    {
        // Register middleware
        $router = $this->app['router'];
        $router->aliasMiddleware('crm.permission', CheckCrmPermission::class);

        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Load and publish views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'crm');
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/crm'),
        ], 'crm-views');

        // Register Livewire components if needed
        if (class_exists(Livewire::class)) {
            Livewire::component('crm.api-token-manager', ApiTokenManager::class);
        }
    }
}
