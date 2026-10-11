---
id: 24
title: "Laravel permissions on a Vue page"
excerpt: "Spatie stores the permission. The controller still checks it. The Vue page only receives a boolean, so a hidden button is not the authorization."
description: "Share a Spatie permission as a boolean to a Vue page, and keep the real check on the Laravel controller."
seoTitle: "Laravel Vue permissions"
date: 2026-10-10T06:10:00Z
snippet: "composer require spatie/laravel-permission"
categories: [laravel, vuejs]
tags: [laravel, vuejs, permissions]
---

A permission answers "is this user an editor?". A policy answers "does this user own this post?". This page is the first one. The owner check is [policies](/laravel-vue-policies). Hiding an Edit link is not either check. The controller has to refuse the request.

The pages those links sit on are the [CRUD guide](/laravel-inertia-vue-crud). The app around them is [Inertia, a SPA, or Nuxt](/laravel-vue-in-2026).

## Install

```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

Add the trait to the user model. The starter kit's `User` already exists. Do not replace the class.

```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
}
```

`HasRoles` is the trait that provides `givePermissionTo`. `$user->can('posts.update')` is Laravel's own `can`, which passes for that permission once the package's gate hook is registered. Give the permission from a seeder or a one-off command, not from the Vue page.

```php
$user->givePermissionTo('posts.update');
```

## Share a boolean

Pass the result of `can()`, not the list of every permission name.

```php
return Inertia::render('posts/Index', [
    'can' => [
        'update' => $request->user()?->can('posts.update') ?? false,
    ],
    'posts' => Post::query()->latest('published_at')->paginate(10)->withQueryString(),
]);
```

```vue
<Link v-if="can.update" :href="`/posts/${post.id}/edit`">Edit</Link>
```

`v-if` removes the link for people who cannot edit. Anyone can still POST the URL. The `update` method has to check the same ability.

```php
public function update(Request $request, Post $post): RedirectResponse
{
    abort_unless($request->user()?->can('posts.update'), 403);

    // the validation from the CRUD guide stays here
}
```

A Pest test should log in a user without the permission and `assertForbidden()` on `PUT /posts/{id}`. A test that only checks the HTML for a missing link will pass while the endpoint stays open.

## Where this stops

`posts.update` is a global ability. It cannot express "only the author". When the rule uses the post, write a [policy](/laravel-vue-policies) and pass `$request->user()->can('update', $post)` instead. Do not encode that rule as another Spatie string.

Roles are the same package: `assignRole('editor')`, then `givePermissionTo` on the role. The Vue page still receives a boolean. It does not need the role name.
