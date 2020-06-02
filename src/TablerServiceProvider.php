<?php

namespace Rizkhal\Tabler;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Rizkhal\Tabler\Console\Commands\TablerAuthCommand;

class TablerServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->bladex()
             ->configure();
    }

    /**
     * Bladex custom
     * @return self
     */
    protected function bladex()
    {
        Blade::component('layouts.app', 'app-layout');
        Blade::component('layouts.auth', 'auth-layout');

        return $this;
    }

    /**
     * Configure
     * @return self
     */
    protected function configure()
    {
        $this->publishes([
            __DIR__.'/../../config/tabler.php' => config_path('tabler.php'),
        ], 'config');

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'tabler');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/tabler')
        ], 'views');

        if ($this->app->runningInConsole()) {
            $this->commands([
                TablerAuthCommand::class
            ]);
        }

        return $this;
    }
}
