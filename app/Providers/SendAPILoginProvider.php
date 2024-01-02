<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SendAPILoginProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path() . '/Helper/SendAPILogin.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
