<?php

namespace Movve\Crm;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Movve\Crm\Http\Livewire\ApiTokenManager;
use Movve\Crm\Http\Livewire\ContactActivityLog;
use Movve\Crm\Http\Livewire\ContactMetaCounter;
use Movve\Crm\Http\Livewire\ContactNotesEditor;
use Movve\Crm\Http\Livewire\Teams\ManageTeamMetaFields;
use Movve\Crm\Http\Middleware\CheckCrmPermission;
use Movve\Crm\Http\Middleware\RedirectIfNotAuthenticated;
use Movve\Crm\Models\Contact;
use Movve\Crm\Models\ContactMeta;
use Movve\Crm\Models\ContactNote;
use Movve\Crm\Observers\ContactMetaObserver;
use Movve\Crm\Observers\ContactNoteObserver;
use Movve\Crm\Observers\ContactObserver;
use Movve\Crm\Observers\TeamObserver;
use Movve\Crm\Providers\CrmPermissionsProvider;
use Movve\Crm\Services\ContactActivityLogger;
use App\Models\Team;

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
        $router->aliasMiddleware('crm.auth', RedirectIfNotAuthenticated::class);

        // Registreer de ContactActivityLogger service als singleton
        $this->app->singleton(ContactActivityLogger::class, function ($app) {
            return new ContactActivityLogger();
        });

        // Register observers
        Contact::observe(ContactObserver::class);
        ContactMeta::observe(ContactMetaObserver::class);
        ContactNote::observe(ContactNoteObserver::class);

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
            Livewire::component('movve.crm.contact-meta-counter', ContactMetaCounter::class);
            Livewire::component('movve.crm.contact-notes-editor', ContactNotesEditor::class);
            Livewire::component('movve.crm.contact-activity-log', ContactActivityLog::class);
            Livewire::component('movve.crm.teams.manage-team-meta-fields', ManageTeamMetaFields::class);
        }
    }
}
