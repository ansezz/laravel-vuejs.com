<?php

namespace Core\Providers;


use Illuminate\Support\ServiceProvider;
use Themosis\Facades\Route;

class RouteApiServiceProvider extends ServiceProvider
{
    /**
     * Define theme routes namespace.
     *
     * @return void
     */
    public function register()
    {
        Route::group([
            'namespace' => 'Core\Controllers\Api',
            'prefix' => 'api'
        ], function () {
            require __DIR__ . '/../Controllers/Api/routes.php';
        });
    }
}