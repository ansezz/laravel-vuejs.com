---
id: 81
title: "Prefix a Laravel API with v1"
seoTitle: "Laravel API v1 prefix"
excerpt: "routes/api.php is already under /api. Add v1 inside the file and keep Inertia pages out of it."
description: "routes/api.php is already under /api. Add v1 inside the file and keep Inertia pages out of it."
date: 2026-10-11T10:28:00Z
snippet: "Route::prefix('v1')->middleware('auth:sanctum')"
categories: [laravel, vuejs]
tags: [laravel, vuejs, sanctum]
---

People searching "Laravel API versioning Vue" mount Inertia on `/api/v1` or prefix the file twice and call `/api/api/v1`. `bootstrap/app.php` already gives `routes/api.php` the `api` prefix and the `api` middleware group. Add only the version:

```php
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get('/posts', [Api\PostController::class, 'index']);
});
```

The URL is `/api/v1/posts`. It returns JSON. The Vue starter kit does not navigate there. A separate SPA, the one in the [SPA guide](/vue-router-laravel-spa), is the client that calls it. Cookie auth for that SPA is the [Sanctum guide](/laravel-sanctum-vue-spa). A token is a different client.

Do not point an Inertia Link at `/api/v1/posts` from a page. Link expects an Inertia response. A JSON body mounts as a broken visit. Do not duplicate the whole web CRUD under `v1` when Inertia already renders those pages.
