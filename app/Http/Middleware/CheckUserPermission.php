<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserPermission
{
    public function handle(Request $request, Closure $next, $permission): Response
    {
        abort_if(!can($permission), 401);
        return $next($request);
    }
}
