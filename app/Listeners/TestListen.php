<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Administration\UserLoginActivityLog;

class TestListen
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event)
    {


        // Log::info('event', [session()->getId(), request()->route()->getName() === 'logout' ? 'logout' : 'login']);

        Log::info('test list');
    }
}
