<?php

namespace Netpok\NamespacedLaravelModels;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ModelMakeServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the config and the command.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__.'/../config/model-namespace.php';
        $this->mergeConfigFrom($configPath, 'model-namespace');

        if (! $this->app->environment('production')) {
            $this->app->singleton('command.model.make', function ($app) {
                return new ModelMakeCommand($app['files']);
            });
        }
    }

    /**
     * Bootstrap the application configuration.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__.'/../config/model-namespace.php';
        $this->publishes([$configPath => config_path('model-namespace.php')]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['command.model.make'];
    }
}
