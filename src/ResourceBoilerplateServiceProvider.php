<?php

namespace Akira\ResourceBoilerplate;

use Illuminate\Support\ServiceProvider;
use Akira\ResourceBoilerplate\Console\MakeDocs;
use Akira\ResourceBoilerplate\Console\MakeModel;
use Akira\ResourceBoilerplate\Console\MakeScafold;
use Akira\ResourceBoilerplate\ResourceBoilerplate;
use Akira\ResourceBoilerplate\Console\MakeController;
use Akira\ResourceBoilerplate\Console\MakeResponseDocumentation;

class ResourceBoilerplateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */


        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeScafold::class,
                MakeController::class,
                MakeModel::class,
                MakeDocs::class,
                MakeResponseDocumentation::class,
            ]);
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('resource-boilerplate.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'resource-boilerplate');

        // Register the main class to use with the facade
        $this->app->singleton('resource-boilerplate', function () {
            return new ResourceBoilerplate;
        });
    }
}
