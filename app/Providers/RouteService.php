<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteService extends ServiceProvider {
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot() {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map() {
        $this->mapOfficeApiRoutes();

        $this->mapUserApiRoutes();

        $this->mapSoundblockApiRoutes();

        $this->mapMerchApiRoutes();

        $this->mapWebRoutes();

        $this->mapStatusRoutes();

        $this->mapAccountApiRoutes();

        $this->mapCoreApiRoutes();
    }

    protected function mapOfficeApiRoutes() {
        Route::group([
            "middleware" => "api",
            "namespace"  => $this->namespace,
            "prefix"     => "",
        ], function ($router) {
            require base_path("routes/api/office.php");
        });
    }

    protected function mapUserApiRoutes() {
        Route::group([
            "middleware" => "api",
            "namespace"  => $this->namespace,
            "prefix"     => "",
        ], function ($router) {
            require base_path("routes/api/user.php");
        });
    }

    protected function mapSoundblockApiRoutes() {
        Route::group([
            "middleware" => "api",
            "namespace"  => $this->namespace,
            "prefix"     => "",
        ], function ($router) {
            require base_path("routes/api/soundblock.php");
        });
    }

    protected function mapMerchApiRoutes() {
        Route::group([
            "middleware" => "api",
            "namespace"  => $this->namespace,
            "prefix"     => "",
        ], function () {
            require base_path("routes/api/merch.php");
        });
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes() {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    protected function mapStatusRoutes() {
        Route::group([
            "middleware" => "api",
            "namespace"  => $this->namespace,
            "prefix"     => "",
        ], function () {
            require base_path("routes/api/status.php");
        });
    }

    protected function mapAccountApiRoutes() {
        Route::group([
            "middleware" => "api",
            "namespace"  => $this->namespace,
            "prefix"     => "",
        ], function ($router) {
            require base_path("routes/api/account.php");
        });
    }

    protected function mapCoreApiRoutes() {
        Route::group([
            "middleware" => "api",
            "namespace"  => $this->namespace,
            "prefix"     => "",
        ], function ($router) {
            require base_path("routes/api/core.php");
        });
    }
}
