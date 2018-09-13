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

Route::group(['prefix' => '{locale}'], function () {
    Route::get('settings', 'SettingsController@index');
    Route::get('settings/breaking-news', 'SettingsController@breakingNews');
    Route::get('search', 'SearchController@index');

    Route::get('post/{arg}', 'PostController@show');

    Route::get('posts', 'PostController@index');

    Route::get('posts/category/{arg}', 'PostController@category');
    Route::get('posts/tag/{arg}', 'PostController@tag');


    Route::get('posts/featured', 'PostController@featured');

    Route::get('posts/categories', 'CategoryController@index');

    Route::get('pages', 'PageController@index');
    Route::get('page/{arg}', 'PageController@getPageByIdOrSlug');

});
