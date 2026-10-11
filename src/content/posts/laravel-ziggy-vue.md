---
id: 47
title: "Ziggy or Wayfinder for Laravel routes in Vue"
excerpt: "Old tutorials install Ziggy and call route(). The Vue starter kit generates Wayfinder functions. Do not install both."
description: "Old Vue tutorials install Ziggy and call route(). The starter kit uses Wayfinder. Do not install both."
seoTitle: "Ziggy or Wayfinder"
date: 2026-10-10T09:30:00Z
snippet: "composer require tightenco/ziggy"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---

A Vue tutorial from a few years ago tells you to install Ziggy, drop `@routes` in the root Blade file, and call `route('posts.store')` from the page. That was how a Blade-less page learned Laravel's named routes. The Vue starter kit does not do it that way. It generates a TypeScript function per controller action with Wayfinder, and the form calls that function.

Do not install Ziggy on that kit. You would have two ways to build the same URL, and only one of them is checked when the route changes. Wayfinder itself is [typed routes in Vue](/laravel-wayfinder-vue). This page is only the choice. The stack is [Laravel and Vue in 2026](/laravel-vue-in-2026).

An app that already runs Ziggy, including an old Breeze app, can keep it. This page does not migrate that app. The [Breeze and Jetstream map](/laravel-breeze-jetstream-vue) is the same kind of decision for auth.

## What the old tutorial installs

```bash
composer require tightenco/ziggy
```

The Blade root then prints every named route into the page with `@routes`. Vue calls `route('posts.store')` and gets a string. A form that posts to a string still needs the method:

```vue
<Form :action="route('posts.store')" method="post">
```

`@routes` sends the named route list to the browser. Anything you named is in that payload, including routes the current page never calls.

## What the kit already generates

```bash
php artisan wayfinder:generate
```

Import the action the generator wrote and pass the function. Inertia reads the URL and the method from it, so you do not also set `method`.

```vue
<script setup lang="ts">
import { store } from "@/actions/App/Http/Controllers/PostController";
</script>

<template>
  <Form :action="store()">
</template>
```

The generator's files and the `update(post.id)` case stay in the Wayfinder guide. Check the generated file before you invent a helper it did not write.

## Do not keep both

On the Vue starter kit, skip `composer require tightenco/ziggy`, skip `@routes`, and skip a Ziggy plugin in `resources/js/app.ts`. The kit's `app.ts` does not register one. Adding it does not make `store()` start working.

`route('posts.store')` is a string. `store()` is the Wayfinder action. Pick the one the app already has. A separate Vue SPA that is not Inertia does not use either of these for its own URLs. That router is [Vue Router](/vue-router-laravel-spa).
