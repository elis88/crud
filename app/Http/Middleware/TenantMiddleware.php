<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Multitenancy\Models\Tenant;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next)
    {
//        $host = $request->getHost();
//        $tenant = Tenant::where('domain', $host)->first();
//
//        if ($tenant) {
//            $tenant->makeCurrent();
//        } else {
//            abort(404, 'Tenant not found');
//        }

        return $next($request);
    }
}
