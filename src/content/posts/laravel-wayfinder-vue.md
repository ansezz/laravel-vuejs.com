---
id: 30
title: "Typed Laravel routes in Vue with Wayfinder"
excerpt: "Wayfinder writes a TypeScript function per controller action. The Inertia form takes that function. You do not add a second router."
description: "Generate typed Laravel controller actions with Wayfinder and pass them to Inertia's Vue Form component."
seoTitle: "Typed routes with Wayfinder"
date: 2026-10-10T07:10:00Z
snippet: "php artisan wayfinder:generate"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia, typescript]
---

The Vue starter kit already ships Wayfinder. It reads the Laravel routes and writes TypeScript functions for the controller actions. A form then posts to `store()` instead of a string you can typo. This is not Vue Router. Inertia still navigates. Adding a client router beside it is the mistake [the stack guide](/laravel-vue-in-2026) warns about.

Typed props on the page are a separate job: [TypeScript props](/typescript-laravel-vue-pages).

## Generate

The Vite plugin in the kit regenerates the files while `npm run dev` is running. After you add a controller, run the command yourself if the import is missing.

```bash
php artisan wayfinder:generate
```

The files land in `resources/js/actions` and `resources/js/routes`. You can gitignore both. They are rebuilt. On deploy, generate against the routes you are shipping. A stale `route:cache` from the previous release makes Wayfinder skip new routes, and Vite then fails looking for a file that was never written. Clear that cache before generating. The rest of the build is the [deploy guide](/deploy-laravel-vue).

## The form

Import `store` from the file Wayfinder wrote for `PostController`. With the kit's `@` alias pointing at `resources/js`, that path is the one below. If your generate path differs, import the file that is actually on disk.

```vue
<script setup lang="ts">
import { Form } from "@inertiajs/vue3";
import { store } from "@/actions/App/Http/Controllers/PostController";
</script>

<template>
  <Form :action="store()">
    <input name="title" />
    <input name="excerpt" />
    <button type="submit">Save</button>
  </Form>
</template>
```

Inertia reads the URL and the HTTP method from the Wayfinder object. You do not also pass `method="post"` unless you are posting to a plain string, which is what the [CRUD guide](/laravel-inertia-vue-crud) does before this page. `store()` with no arguments matches `POST /posts`. An update action that needs the id is `update(post.id)` from the same generated module. Use the function the generator named after the controller method.

A `<Link>` uses the same object when you need an href: `:href="store.url()"`. Check the generated file for that helper before you invent `.url` on your own. The generator is the API. This page does not describe a second one.

## Where this stops

Wayfinder does not validate the body. The form request from [Precognition](/laravel-precognition-vue) still does. It does not know which user may call `update`. That is a [policy](/laravel-vue-policies). A tutorial that says `route()` and Ziggy is the [Ziggy map](/laravel-ziggy-vue). Do not install that package beside these generated functions.
