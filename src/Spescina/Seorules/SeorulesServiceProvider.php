<?php

namespace Spescina\Seorules;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SeorulesServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {

        $this->publishes([
            __DIR__.'/../../config/seorules.php' => config_path('seorules.php')
        ], 'config');

        $this->publishes([
            __DIR__.'/../../migrations/' => database_path('migrations')
        ], 'migrations');

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app['seo'] = $this->app->share(function($app) {
            return Seo::getInstance();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return ['seo'];
    }

}