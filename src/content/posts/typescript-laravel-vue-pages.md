---
id: 32
title: "TypeScript props on Laravel Vue pages"
excerpt: "defineProps on the Inertia page is the type of the controller payload. A missing key fails the check on your machine, before a blank v-for in the browser."
description: "Type an Inertia Vue page with defineProps, including the posts.data shape a Laravel paginator returns."
seoTitle: "TypeScript props on Inertia pages"
date: 2026-10-10T07:30:00Z
categories: [laravel, vuejs]
tags: [laravel, vuejs, typescript, inertia]
---

The Vue starter kit is already TypeScript. The page is untyped until you say what the controller sends. `defineProps` on that single file is enough. You do not need a shared types package, and you do not need Vue Router. Routing stays in Laravel, which is the setup in [Inertia, a SPA, or Nuxt](/laravel-vue-in-2026).

The list this types is the [CRUD guide](/laravel-inertia-vue-crud). The first setup page returned `posts` as an array. The CRUD page wraps that array in `data`. Type the shape you actually return.

## The page

```vue
<!-- resources/js/pages/posts/Index.vue -->
<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";

interface Post {
  id: number;
  title: string;
  excerpt: string;
  published_at: string | null;
}

interface Page {
  data: Post[];
  current_page: number;
  last_page: number;
  prev_page_url: string | null;
  next_page_url: string | null;
}

defineProps<{
  posts: Page;
  filters: { search: string };
}>();
</script>

<template>
  <Head title="Posts" />
  <article v-for="post in posts.data" :key="post.id">
    <h2>{{ post.title }}</h2>
    <Link :href="`/posts/${post.id}/edit`">Edit</Link>
  </article>
</template>
```

`published_at` is a string in the props because Inertia serializes dates to JSON. Typing it as `Date` will not make it a `Date`. Format it as a string, or parse it on purpose.

`posts.data` is the row list. `v-for="post in posts"` walks the paginator's values, the `data` array and then `current_page` and the rest, so `post.title` comes out blank. The key is the second alias, `(value, key)`. The type above makes that mistake a type error if you annotate the `v-for` source as `Post[]` and then pass `posts` instead of `posts.data`.

A simple paginator or a cursor paginator has no `last_page`. Drop that field from `Page` when the controller uses those methods. The differences are [pagination](/laravel-vue-pagination).

## What stays local

Keep this interface next to the page that receives it. A global `PageProps` augmentation is worth it later, when every page reads the same shared `auth` user. It is the wrong first step. One wrong global type then lies to every page.

Wayfinder types the URL you visit. It does not type these props. That generator is [Wayfinder](/laravel-wayfinder-vue).

Run the kit's TypeScript check. A fresh starter kit calls `vue-tsc`. The script name is whatever `package.json` already has. Do not add a second checker. A red `posts.data` means the controller and the page disagree. Fix the one that is wrong. Do not silence it with `as any`.

## Where this stops

Component tests for a presentational child are [tests](/test-laravel-vue). They mount the child with a `title` string. They do not replace `defineProps` on the Inertia page.
