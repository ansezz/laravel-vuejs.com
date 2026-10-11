---
id: 11
title: "When to use Pinia with Laravel and Inertia"
excerpt: "Page props already hold the posts. Pinia is for client state that should survive the next visit, such as a draft."
description: "Pinia with Laravel and Inertia: install it on the Vue starter kit, and keep server state in props instead of a store."
seoTitle: "Pinia with Laravel and Inertia"
date: 2026-10-10T04:00:00Z
snippet: "npm install pinia"
categories: [vuejs, laravel]
tags: [vuejs, inertia, pinia]
---

Pinia shows up on most Vue job posts, so people add it to a new Laravel app on day one. An Inertia page already receives its data as props. Copying the post list into a store gives you two sources of truth and a stale screen.

Use Pinia for state the server does not own.

## What stays in props

The [CRUD guide](/laravel-inertia-vue-crud) loads posts in the controller and types them with `defineProps`. Search lives in the query string. After a save, the redirect renders the index again and the list is fresh.

That is the server state. Do not `router.reload` into a Pinia store "so every component can read it." Pass the prop, or read a shared prop Inertia already keeps. A store that mirrors Eloquent will be wrong the moment someone else creates a row, unless you also build the [Reverb](/laravel-reverb-vue) path to patch it.

## What belongs in a store

A draft title the author typed on `/posts/create`, then lost by opening the list, is client state. So is a command palette that is open, or a multi-step wizard you have not turned into URLs yet. If a refresh should forget it, it can live in Pinia. If a refresh should remember it, put it in the URL or in the database.

## Install it on the starter kit

```bash
npm install pinia
```

The Vue starter kit mounts Inertia in `resources/js/app.ts` with `withApp`. Add Pinia inside that callback, and create the instance there, so a server render does not reuse another request's state. Keep the `title`, `layout`, `progress`, and focus directive the file already has. A manual `setup` callback turns off the Vite plugin's SSR wiring.

```ts
import { createPinia } from "pinia";

// inside the withApp callback resources/js/app.ts already has
withApp(app) {
  app.use(createPinia());
},
```

```ts
// resources/js/stores/draft.ts
import { defineStore } from "pinia";
import { ref } from "vue";

export const useDraftStore = defineStore("draft", () => {
  const title = ref("");
  const excerpt = ref("");

  function clear() {
    title.value = "";
    excerpt.value = "";
  }

  return { title, excerpt, clear };
});
```

```vue
<script setup lang="ts">
import { useDraftStore } from "@/stores/draft";

const draft = useDraftStore();
</script>

<template>
  <input v-model="draft.title" name="title" />
  <textarea v-model="draft.excerpt" name="excerpt" />
</template>
```

`v-model` is justified here because the store is the source. The `<Form>` component in the CRUD guide does not need it: the browser owns the inputs until submit. Use the store when leaving the page should keep the text. Call `draft.clear()` after a successful create, or the next new post opens with the old sentence.

## Vue Router apps

A separate SPA from the [Sanctum guide](/laravel-sanctum-vue-spa) has no Inertia props. Pinia is a normal place for the current user after `GET /api/user`, and for data you do not want to refetch on every route. Still treat the API as the source. Write the response into the store. Do not let the store be the only copy of a record you have not saved.

Vuex is the old answer. New Vue 3 code uses Pinia. The starter kit does not install either until you do.
