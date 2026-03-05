<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSiteMaintenance
{
    public function handle(Request $request, Closure $next): Response
    {
        $settings = SiteSetting::getCached();

        if ($settings && (bool) $settings->is_maintenance) {
            abort(503);
        }

        return $next($request);
    }
}

