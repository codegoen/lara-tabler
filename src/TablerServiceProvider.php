<?php

declare(strict_types=1);

namespace Rizkhal\Tabler;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laravel\Ui\UiCommand;
use Rizkhal\Tabler\Console\Commands\CommandTablerAuth;

class TablerServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->uiCommand();
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

        // if ($this->app->runningInConsole()) {
        //     $this->commands([
        //         //
        //     ]);
        // }

        return $this;
    }

    /**
     * UI Command using laravel/ui
     * 
     * @return void
     */
    protected function uiCommand(): void
    {
        UiCommand::macro('tabler', function ($command) {
            
            CommandTablerAuth::install();

            $command->info('Auth scaffolding installed successfully.');
            $command->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });
    }
}
