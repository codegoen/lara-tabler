<?php

declare(strict_types=1);

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
        $this->configure();
    }

    /**
     * Configure.
     *
     * @return void
     */
    protected function configure(): void
    {
        Blade::component('layouts.app', 'app-layout');
        Blade::component('layouts.auth', 'auth-layout');

        if ($this->app->runningInConsole()) {
            $this->commands([
                TablerAuthCommand::class,
            ]);
        }
    }
}
