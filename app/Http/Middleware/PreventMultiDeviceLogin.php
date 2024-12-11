<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PreventMultiDeviceLogin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (($user && $user->session_id && $user->session_id !== session()->getId() || $user->session_id == null)) {
            Auth::logout();
            return redirect('/login')->withErrors([
                'username' => 'You have been logged out because your account was accessed from another device.',
            ]);
        }

        return $next($request);
    }
}
