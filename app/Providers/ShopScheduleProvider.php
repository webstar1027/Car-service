<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ShopSchedule;
class ShopScheduleProvider extends ServiceProvider
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
         $this->app->singleton('App\Services\ShopSchedule', function($app){
            return new ShopSchedule($app);
        });
    }
}
