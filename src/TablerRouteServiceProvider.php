<?php

declare(strict_types=1);

namespace Rizkhal\Tabler;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Rizkhal\Tabler\Http\Controllers\CrudGeneratorController;
use Rizkhal\Tabler\Http\Controllers\ModelController;

class TablerRouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->routeModel()->routeView()->routeController();
    }

    /**
     * Grouping route
     * 
     * @param  string $as
     * @return array
     */
    protected function routeGroup(string $as): array
    {
        $group = [
            "namespace" => "Rizkhal\Tabler\Http\Controllers",
            "prefix" => "rizkhal",
            "middleware" => ["web", "auth"]
        ];

        return array_merge($group, ["as" => "rizkhal.{$as}"]);
    }

    /**
     * Route for model
     * 
     * @return self
     */
    protected function routeModel(): self
    {
        Route::group($this->routeGroup("model."), function() {
            Route::get("/", [ModelController::class, "index"])->name("index");
            Route::get("model", [ModelController::class, "index"])->name("index");
            Route::post("model/create", [ModelController::class, "create"])->name("create");
        });

        return $this;
    }

    /**
     * Route for view
     * 
     * @return self
     */
    protected function routeView(): self
    {
        Route::group($this->routeGroup("view."), function() {
            Route::get("view", [CrudGeneratorController::class, "index"])->name("index");
            Route::post("view/create", [CrudGeneratorController::class, "create"])->name("create");
        });

        return $this;
    }

    /**
     * Route for controller
     * 
     * @return self
     */
    protected function routeController(): self
    {
        Route::group($this->routeGroup("controller."), function() {
            Route::get("controller", [CrudGeneratorController::class, "index"])->name("index");
            Route::get("controller/create", [CrudGeneratorController::class, "create"])->name("index");
            });

        return $this;
    }
}
