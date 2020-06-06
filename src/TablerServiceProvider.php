<?php

declare(strict_types=1);

namespace Rizkhal\Tabler;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Rizkhal\Tabler\Console\Commands\TablerAuthCommand;
use Rizkhal\Tabler\Console\Commands\TablerCrudCommand;

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
        $this->configure()
             ->registerHelper();
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
                TablerAuthCommand::class,
                TablerCrudCommand::class
            ]);
        }

        return $this;
    }

    /**
     * Register helper
     * 
     * @return void
     */
    protected function registerHelper(): void
    {
        if (file_exists(__DIR__."/helper.php")) {
            require __DIR__."/helper.php";
        }
    }
}
