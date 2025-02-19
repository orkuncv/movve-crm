<?php

namespace Movve\Crm\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class CrmPermissionsProvider extends ServiceProvider
{
    public function boot()
    {
        Jetstream::permissions([
            'crm:access',
            'crm:read',
            'crm:create',
            'crm:update',
            'crm:delete',
            'crm:restore',
        ]);
    }
}
