<?php

namespace Netpok\NamespacedLaravelModels;

use Illuminate\Console\Command;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ModelMakeServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * The commands which have updatable model fields.
     *
     * @var array
     */
    protected $commands = [
        'command.model.make',
        'command.controller.make',
        'command.factory.make',
        'command.observer.make',
        'command.policy.make',
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->configPath(), 'model-namespace');

        $this->registerFixer();
        $this->registerHooks();
    }

    /**
     * Register the namespace fixer
     *
     * @return void
     */
    public function registerFixer(): void
    {
        $this->app->singleton(ModelNamespaceFixer::class, function ($app) {
            return new ModelNamespaceFixer(
                $app->getNamespace(),
                $app['config']->get('model-namespace.namespace')
            );
        });
    }

    /**
     * Register injection hooks.
     *
     * @return void
     */
    protected function registerHooks(): void
    {
        foreach ($this->commands as $command) {
            $this->app->afterResolving($command, function ($command) {
                $command->initializeModelNamespaceFixer();
            });
        }
    }

    /**
     * Bootstrap the application configuration and register the macro.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([$this->configPath() => config_path('model-namespace.php')]);

        Command::macro('initializeModelNamespaceFixer', function () {
            $this->setCode(function ($input, $output) {
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
        return array_merge([ModelNamespaceFixer::class], $this->commands);
    }

    /**
     * The path for the default config.
     *
     * @return string
     */
    protected function configPath(): string
    {
        return __DIR__.'/../config/model-namespace.php';
    }
}
