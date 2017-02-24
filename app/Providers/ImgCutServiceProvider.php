<?php
/**
 * Created by PhpStorm.
 * User: Hermit
 * Date: 2016/11/4
 * Time: 16:13
 */

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class ImgCutServiceProvider extends ServiceProvider
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
        $this->app->singleton('ImgCutService', function () {
            return new \App\Services\ImgCut();
        });
    }
}