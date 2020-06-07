<?php

declare(strict_types=1);

namespace Rizkhal\Tabler;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laravel\Ui\UiCommand;
use Rizkhal\Tabler\Console\Commands\CommandTablerAuth;
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
     * @return self
     */
    protected function configure(): self
    {
        Blade::component('layouts.app', 'app-layout');
        Blade::component('layouts.auth', 'auth-layout');

        if ($this->app->runningInConsole()) {
            $this->commands([
                TablerAuthCommand::class
            ]);
        }

        return $this;
    }
}
