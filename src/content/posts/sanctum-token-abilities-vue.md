---
id: 78
title: "Limit a Sanctum token with abilities"
seoTitle: "Sanctum token abilities"
excerpt: "createToken can take an ability list. The ability middleware belongs on the API route, not on an Inertia page."
description: "createToken can take an ability list. The ability middleware belongs on the API route, not on an Inertia page."
date: 2026-10-11T10:25:00Z
snippet: "createToken('phone', ['posts:read'])"
categories: [laravel, vuejs]
tags: [laravel, vuejs, sanctum]
---
People searching "Sanctum token abilities" put `abilities:posts:read` on a browser route and then every Inertia page returns 403. Abilities exist on a token. A session does not have them. The [Sanctum guide](/laravel-sanctum-vue-spa) is the cookie. This page is the token.

```php
$plain = $request->user()->createToken('phone', ['posts:read'])->plainTextToken;
```

```php
Route::get('/posts', [Api\PostController::class, 'index'])
    ->middleware(['auth:sanctum', 'abilities:posts:read']);
```

That route lives in `routes/api.php`. The Vue starter kit's pages stay on `routes/web.php` with `auth`.

In a controller that must be picky inside an action, `$request->user()->tokenCan('posts:read')` checks the current token. It is false for a session guard. Do not call it from an Inertia controller and hide the button based on it.

Do not treat abilities as a substitute for a [policy](/laravel-vue-policies). An ability is what that token may do. A policy is what that user may do to a row.
