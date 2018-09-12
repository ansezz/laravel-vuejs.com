<?php

namespace Core\API\Providers;

use Themosis\Facades\Route;
use Themosis\Foundation\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define theme routes namespace.
     *
     * @return void
     */
    public function register()
    {
        Route::group([
            'namespace' => 'Core\API\Controllers',
            'prefix' => 'api'
        ], function () {
            require themosis_path('theme.resources') . 'core/Api/routes.php';
        });
    }
}
