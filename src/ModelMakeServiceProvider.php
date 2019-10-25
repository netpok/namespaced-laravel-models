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
        $this->mergeConfigFrom($this->configPath(), 'model-namespace');

        $this->app->singleton(ModelNamespaceFixer::class, function($app){
            return new ModelNamespaceFixer(
                $app->getNamespace(),
                $app['config']->get('model-namespace.namespace')
            );
        });

        $this->app->singleton('command.model.make', function ($app) {
            return new ModelMakeCommand($app['files']);
        });
    }

    /**
     * Bootstrap the application configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([$this->configPath() => config_path('model-namespace.php')]);

        Command::macro('initializeModelNamespaceFixer', function() {
            $this->setCode(function($input, $output){
                app(ModelNamespaceFixer::class)->fixInput($this->getName(), $input);

                return $this->execute($input, $output);
            });
        });
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

    protected function configPath(): string
    {
        return __DIR__.'/../config/model-namespace.php';
    }
}
