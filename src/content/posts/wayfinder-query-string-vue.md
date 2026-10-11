---
id: 68
title: "Add a query string to a Wayfinder URL"
seoTitle: "Wayfinder query string"
excerpt: "Pass query on the generated Wayfinder function. Do not glue a question mark onto the URL by hand."
description: "Pass query on the generated Wayfinder function. Do not glue a question mark onto the URL by hand."
date: 2026-10-11T10:15:00Z
snippet: "index({ query: { search } })"
categories: [laravel, vuejs]
tags: [laravel, vuejs, typescript]
---
People searching "Wayfinder query string" concatenate `?search=` onto a generated URL and then lose the types. The [Wayfinder guide](/laravel-wayfinder-vue) shows `store()` for a form. A list link is the same generated function, plus the query object the file already accepts.

Open `resources/js/actions/.../PostController.ts` after `php artisan wayfinder:generate`. The `index` function takes an options argument. This is the shape current Wayfinder generates for a route with no parameters:

```vue
<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { index } from "@/actions/App/Http/Controllers/PostController";

defineProps<{ search: string }>();
</script>

<template>
  <Link :href="index({ query: { search } })">Search</Link>
</template>
```

If the generated type names the argument differently, follow the file. The generator is the API. An action that already has a route parameter takes that parameter first and the options second, the same way the [Wayfinder guide](/laravel-wayfinder-vue) uses `update(post.id)`.

Do not install Ziggy because a query string felt easier with `route()`. The [Ziggy page](/laravel-ziggy-vue) is why that package stays out of this kit.
