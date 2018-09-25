<?php

/**
 * Define your routes and which views to display
 * depending of the query.
 *
 * Based on WordPress conditional tags from the WordPress Codex
 * http://codex.wordpress.org/Conditional_Tags
 *
 */

remove_action('template_redirect', 'redirect_canonical');

Route::get('/', 'ApiBaseController@status');
Route::get('status', 'ApiBaseController@status');

Route::group(['prefix' => '{locale}'], function () {
    Route::get('settings', 'SettingsController@index');

    Route::get('search', 'SearchController@index');

    Route::get('page', 'PageController@index');
    Route::get('page/{arg}', 'PageController@getPageByIdOrSlug');


    Route::get('categories', 'CategoryController@index');
    Route::get('tags', 'TagController@index');

    Route::group(['prefix' => '{type}'], function () {
        Route::get('/', 'PostController@index');

        Route::get('featured', 'PostController@featured');

        Route::get('category/{arg}', 'PostController@category');
        Route::get('tag/{arg}', 'PostController@tag');

        Route::get('{arg}', 'PostController@show');
    });

});
