<?php

declare(strict_types=1);

namespace Rizkhal\Tabler;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Rizkhal\Tabler\Http\Controllers\ControllerController;
use Rizkhal\Tabler\Http\Controllers\CrudController;
use Rizkhal\Tabler\Http\Controllers\ModelController;

class TablerRouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->routeCrud()->routeModel()->routeController();
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
     * Route for crud
     * 
     * @return self
     */
    protected function routeCrud(): self
    {
        Route::group($this->routeGroup("crud."), function() {
            Route::get("/", [CrudController::class, "index"])->name("index");
            Route::get("crud", [CrudController::class, "index"])->name("index");
            Route::post("crud/create", [CrudController::class, "create"])->name("create");
        });

        return $this;
    }
    /**
        /**
     * Route for model
     * 
     * @return self
     */
    protected function routeModel(): self
    {
        Route::group($this->routeGroup("model."), function() {
            Route::get("model", [ModelController::class, "index"])->name("index");
            Route::post("model/create", [ModelController::class, "create"])->name("create");
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
            Route::get("controller", [ControllerController::class, "index"])->name("index");
            Route::post("controller/create", [ControllerController::class, "create"])->name("create");
            });

        return $this;
    }
}
