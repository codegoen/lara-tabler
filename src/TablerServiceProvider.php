<?php

declare(strict_types=1);

namespace Rizkhal\Tabler;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Rizkhal\Tabler\Console\Commands\TablerAuthCommand;
use Rizkhal\Tabler\Console\Commands\TablerComponentCommand;
use Rizkhal\Tabler\Console\Commands\TablerCrudCommand;
use Rizkhal\Tabler\Http\Controllers\CrudGeneratorController;

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
        $this->configure()->loadResources()->registerRoutes();
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
                TablerComponentCommand::class,
            ]);
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

    protected function registerRoutes(): self
    {
        $group = [
            "namespace" => "Rizkhal\Tabler\Http\Controllers",
            "prefix" => "tabler",
            "middleware" => ["web", "auth"]
        ];

        Route::group($group, function() {
            Route::get("/", [CrudGeneratorController::class, "index"])->name("tabler.index");
            Route::post("store", [CrudGeneratorController::class, "store"])->name("tabler.store");
        });

        return $this;
    }

    protected function registerPublishing(): self
    {
        $this->publishes([
                __DIR__.'/../public' => public_path('vendor/tabler'),
            ], 'tabler-assets');
    }
}
