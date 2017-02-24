<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AjaxResponseServiceProvider extends ServiceProvider
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
        $this->app->singleton('AjaxResponseService', function () {
            return new \App\Services\AjaxResponse();
        });
    }
}
