<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CommonFuncServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //To-Do List
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('commonfunc',function(){
            return new \App\Facades\CommonFunc();
        });
    }
}
