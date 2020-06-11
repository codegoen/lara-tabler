<?php

declare(strict_types=1);

namespace Rizkhal\Tabler;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Rizkhal\Tabler\Console\Commands\TablerAuthCommand;
use Rizkhal\Tabler\Console\Commands\TablerComponentCommand;
use Rizkhal\Tabler\Console\Commands\TablerControllerCommand;
use Rizkhal\Tabler\Console\Commands\TablerModelCommand;
use Rizkhal\Tabler\Console\Commands\TablerRequestCommand;

class TablerServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/tabler.php', 'tabler');

        $this->app->bind("command.tabler:auth", TablerAuthCommand::class);
        $this->app->bind("command.tabler:model", TablerModelCommand::class);
        $this->app->bind("command.tabler:request", TablerRequestCommand::class);
        $this->app->bind("command.tabler:components", TablerComponentCommand::class);
        $this->app->bind("command.tabler:controller", TablerControllerCommand::class);

        $this->commands([
            'command.tabler:auth',
            'command.tabler:model',
            'command.tabler:request',
            'command.tabler:controller',
            'command.tabler:components',
        ]);
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->register(TablerRouteServiceProvider::class);
        $this->configure()->loadResources();
    }

    /**
     * Configure.
     *
     * @return self
     */
    protected function configure(): self
    {
        Blade::component('layouts.app', 'app-layout');
        Blade::component('layouts.auth', 'auth-layout');

        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../config/tabler.php' => config_path('tabler.php'),
            ], 'tabler-config');
        }

        return $this;
    }

    /**
     * Load resources lang and views
     * 
     * @return self
     */
    protected function loadResources(): self
    {
        $this->loadTranslationsFrom(
            __DIR__.'/../resources/lang', 'tabler'
        );

        $this->loadViewsFrom(
            __DIR__.'/../resources/views', 'tabler'
        );

        return $this;
    }

    protected function registerPublishing(): self
    {
        $this->publishes([
                __DIR__.'/../public' => public_path('vendor/tabler'),
            ], 'tabler-assets');
    }
}
