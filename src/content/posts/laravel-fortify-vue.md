---
id: 20
title: "Laravel Fortify with Vue"
excerpt: "The Vue starter kit already ships Fortify screens. Install Fortify when the front end is a separate SPA, or when those actions need a new field."
description: "Use Laravel Fortify with Vue: the starter kit already has the screens, and a separate SPA posts to Fortify after the Sanctum cookie."
seoTitle: "Laravel Fortify with Vue"
date: 2026-10-10T05:30:00Z
snippet: "php artisan fortify:install"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---

Search results for "Laravel Fortify Vue" still start with `composer require laravel/fortify` on top of Breeze. The current Vue starter kit already did that work. Login, registration, password reset, and email verification are Vue pages, and the actions that write the user live in `app/Actions/Fortify`. Installing Fortify a second time does not give you a better login form.

Use this page in two cases. You are changing those actions. Or the browser is a separate SPA and Fortify should expose the auth endpoints without rendering views. The cookie, the CSRF call, and CORS are [Sanctum for a Vue SPA](/laravel-sanctum-vue-spa). Which front end you are building is [Inertia, a SPA, or Nuxt](/laravel-vue-in-2026). GitHub as the only login is [Socialite](/laravel-socialite-vue).

## The starter kit

Open `app/Actions/Fortify/CreateNewUser.php` when registration needs another column. The `create` method already validates name, email, and password. Add the column to that array and to the `User::create` call. Do the same kind of edit in `ResetUserPassword` when the reset rules change.

The Vue pages are under `resources/js/pages/auth`. They post to Fortify. You do not register a second `POST /login`.

The full route list, including two-factor routes this page does not copy, is in the [Fortify docs for Laravel 13](https://laravel.com/docs/13.x/fortify).

## A separate SPA

Fortify is the right install when Laravel is the API and Vue is another origin. The views stay off. The SPA renders the forms and posts to Fortify.

```bash
composer require laravel/fortify
php artisan fortify:install
php artisan migrate
```

```php
// config/fortify.php
'views' => false,
```

With views off, Fortify does not try to return a Blade login page. These are the POST endpoints a first SPA usually needs:

- `/login`
- `/register`
- `/forgot-password`
- `/reset-password`
- `/email/verification-notification`

Send them after `GET /sanctum/csrf-cookie`, with credentials, the same way the Sanctum guide posts `/login`. A 419 is still CSRF. A 422 is validation. Fortify's register endpoint returns validation errors for a duplicate email. Show `errors.email` from that JSON. Do not store a bearer token from these responses. Fortify's SPA story is the session cookie.

`POST /logout` is also Fortify's. Call it when the user signs out, then send them to the SPA's login route.

## What you customize

Features are flags in `config/fortify.php`, not extra packages. Registration, password reset, and email verification are already named there. Turn a feature off in that file rather than deleting a route by hand.

Keep password rules in `CreateNewUser` and `ResetUserPassword`. A Vue page that reimplements the same rules will drift. The server is the check that runs.

## Where this stops

Fortify does not authorize "may this user edit this post". That is a [policy](/laravel-vue-policies) or a [permission](/laravel-vue-permissions). It also does not build the CRUD behind the login. That stays the [CRUD guide](/laravel-inertia-vue-crud).
