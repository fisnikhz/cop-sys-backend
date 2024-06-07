<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OfficerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->user()->isOfficer()) {
            abort(403);
        }
        return $next($request);
    }
}
