<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $check_protocol = Config::get('app.url');
        if(explode(":", $check_protocol)[0] == "https"){
            \URL::forceScheme('https');
        }
    }
}
