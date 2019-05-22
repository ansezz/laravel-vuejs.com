<?php

namespace LaravelVueJs\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\NovaTranslatable\Translatable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Translatable::defaultLocales(['en']);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
