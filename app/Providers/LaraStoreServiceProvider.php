<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LaraStoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        dd('larastore');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        dd('larastore-register');
    }
}
