---
id: 45
title: "Show a saved message in Vue"
excerpt: "Inertia 3 can flash a toast for one visit. The Vue starter kit already displays it. A Laravel with() call does not reach that toast."
description: "Flash a one-time saved message with Inertia 3. The Vue starter kit already shows the toast. A Laravel with() call does not."
seoTitle: "Flash a saved message in Vue"
date: 2026-10-10T09:10:00Z
snippet: "Inertia::flash('toast', ...)"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---

The [CRUD guide](/laravel-inertia-vue-crud) saves a post and redirects to the list. The list looks the same as it did before the save. The reader has no signal that the write worked.

Inertia 3 has a flash for that. It lives for the next response, then it is gone. The back button does not bring it back, because it is not stored in the history entry. A row in the `notifications` table is a different feature, the [database bell](/laravel-vue-notifications). The stack is [Laravel and Vue in 2026](/laravel-vue-in-2026).

## On the Vue starter kit

The kit already listens. `resources/js/app.ts` calls `initializeFlashToast()`, and that function reads `flash.toast` and hands it to the toast that ships with the kit. Do not install another toast package. Do not register a second `router.on('flash')`.

Flash this shape before the redirect the CRUD `store` method already returns:

```php
use Inertia\Inertia;

Inertia::flash('toast', [
    'type' => 'success',
    'message' => 'Saved.',
]);

return to_route('posts.index');
```

`type` is `success`, `info`, `warning`, or `error`. The kit's profile controller uses the same array when it updates the account. Match it. A plain string under another key will not reach that listener.

A `with()` call on that redirect writes Laravel's session. The kit is not reading that key. The toast stays quiet.

```php
return to_route('posts.index')->with('success', 'Saved.');
```

## A line in the layout

Use this when the app does not call `initializeFlashToast()`. Flash a string and print it once. On the starter kit, prefer the `toast` array above so you do not show the same sentence twice.

```php
Inertia::flash('success', 'Saved.');

return to_route('posts.index');
```

```vue
<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";

const page = usePage();
</script>

<template>
  <p v-if="page.flash.success">{{ page.flash.success }}</p>
  <slot />
</template>
```

Put that `p` in the layout that wraps the pages, not in one form. The next visit clears it. You do not delete it yourself.

## A test

`assertInertiaFlash` reads the flash on the redirect. It does not need the Vue page to render.

```php
$this->post('/posts', [
    'title' => 'Hello Laravel 13',
    'excerpt' => 'A short excerpt.',
])->assertRedirect('/posts')
    ->assertInertiaFlash('toast.message', 'Saved.');
```

A banner that flashes `success` asserts that key with the same method. The rest of the create test stays in the CRUD guide.
