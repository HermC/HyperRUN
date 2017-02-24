<?php
/**
 * Created by PhpStorm.
 * User: Hermit
 * Date: 2016/11/26
 * Time: 16:40
 */

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class BMIServiceProvider extends ServiceProvider
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
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('BMI', function () {
            return new \App\Services\BMIService();
        });
    }
}