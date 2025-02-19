<?php

namespace Movve\Crm\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCrmPermission
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->tokenCan('crm:access')) {
            abort(403, 'You do not have permission to access CRM functionality.');
        }

        // Check specific CRM permissions based on the route
        $routeName = $request->route()->getName();
        $permission = match ($routeName) {
            'crm.contacts.index' => 'crm:read',
            'crm.contacts.show' => 'crm:read',
            'crm.contacts.store' => 'crm:create',
            'crm.contacts.update' => 'crm:update',
            'crm.contacts.destroy' => 'crm:delete',
            'crm.contacts.restore' => 'crm:restore',
            default => null,
        };

        if ($permission && ! $request->user()->tokenCan($permission)) {
            abort(403, 'You do not have the required permission for this action.');
        }

        return $next($request);
    }
}
