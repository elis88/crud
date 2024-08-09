<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Tenant;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $prefix = $request->segment(2);



        $tenant = Tenant::where('prefix', $prefix)->first();


        if ($tenant) {

            $tenant->makeCurrent();

        } else {
            // Handle the case where the tenant is not found
            return response()->json(['error' => 'Tenant not found'], 404);
        }

        return $next($request);
    }
}
