---
id: 92
title: "Put a permission on the route"
seoTitle: "Permission middleware in Vue"
excerpt: "role and permission middleware refuse the request. The Vue page only receives a boolean it can show."
description: "role and permission middleware refuse the request. The Vue page only receives a boolean it can show."
date: 2026-10-11T10:39:00Z
snippet: "->middleware(['auth', 'permission:posts.update'])"
categories: [laravel, vuejs]
tags: [laravel, vuejs, permissions]
---
People searching "Spatie permission middleware Vue" check `v-if="can('posts.update')"` in the page and never register the middleware. The [permissions guide](/laravel-vue-permissions) installs the package and shares a boolean. This page is the route.

Publish and migrate are in that guide. The alias belongs in `bootstrap/app.php` if it is not registered yet:

```php
$middleware->alias([
    'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
    'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
]);
```

```php
Route::post('/posts', [PostController::class, 'store'])
    ->middleware(['auth', 'permission:posts.update']);
```

A user without `posts.update` gets a 403 before the controller. The Vue page can still hide the button from the boolean the permissions guide shares. Hiding is not this middleware.

Do not spell the permission differently in the seeder and the route. `posts.update` and `post.update` are two permissions. Do not grant it from the Vue page.
