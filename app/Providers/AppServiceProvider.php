<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

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
        Carbon::setLocale(env('APP_LOCALE', 'id')); // Optional: Set locale for Carbon
        date_default_timezone_set(env('APP_TIMEZONE', 'UTC')); // Set default timezone
    }
}
