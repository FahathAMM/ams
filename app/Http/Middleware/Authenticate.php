<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        //     $user = Auth::user();
        //     Log::info(['from' => 'from Authenticate', 'user' => $user]);
        //     Log::info('from Authenticate');
        //     Log::info('session()->getId()', [session()->getId()]);


        // $user = User::find(Auth::user()->id);


        return $request->expectsJson() ? null : route('login');
    }
}
