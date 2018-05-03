<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use App\Services\GoogleService;
class GoogleProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('App\Services\GoogleService', function($app){
            return new GoogleService();
        });
    }
}
