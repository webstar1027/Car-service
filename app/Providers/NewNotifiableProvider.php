<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use App\Services\NewNotifiable;
class NewNotifiableProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public $email;
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
        $this->app->singleton('App\Services\NewNotifiable', function($app){
            return new NewNotifiable($this->email);
        });
    }
}
