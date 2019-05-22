<?php


use Illuminate\Support\Facades\Route;

Route::get('/', \Ansezz\CategoriesField\Http\Controllers\CategoriesFieldController::class.'@index');
