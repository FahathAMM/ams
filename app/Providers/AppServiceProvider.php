<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot(): void
    {
        Blade::if('canOrRole', function ($per, $action) {
            return can($per, $action);
        });
    }

    // public function boot(): void
    // {
    //     Blade::if('canOrRole', function ($per, $action) {
    //         return can($per, $action);
    //     });
    // }
}
