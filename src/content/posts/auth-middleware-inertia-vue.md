---
id: 76
title: "Protect an Inertia page with auth middleware"
seoTitle: "Auth middleware and Inertia"
excerpt: "auth on the Laravel route is what sends a guest to login. A v-if on the Vue page does not."
description: "auth on the Laravel route is what sends a guest to login. A v-if on the Vue page does not."
date: 2026-10-11T10:23:00Z
snippet: "->middleware(['auth', 'verified'])"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---
People searching "Inertia auth middleware" hide the nav when `auth.user` is null and leave the route open. Anyone can still request it. Put the middleware on the route. The [setup guide](/application-setup) shares `auth.user` for the menu. The menu is not the lock.

```php
Route::get('/posts', [PostController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('posts.index');
```

A guest is redirected to login. Inertia follows that redirect, so the Vue page never mounts. You do not handle this in `router.on('error')`.

Use the prop only for presentation:

```vue
<p v-if="page.props.auth.user">{{ page.props.auth.user.name }}</p>
```

Do not fetch `/posts` with `fetch()` and expect the login redirect to become JSON. An Inertia visit understands the redirect. A hand-rolled request gets the login HTML. Do not add Vue Router guards as a second copy of this middleware. The [SPA guide](/vue-router-laravel-spa) is the only place a client guard belongs, and only on that separate app.
