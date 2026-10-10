---
id: 27
title: "Inertia partial reloads in Vue"
excerpt: "router.reload can ask Laravel for one prop. Deferred props wait until after the first paint. Merge appends on those partial visits only."
description: "Reload one Inertia prop from Vue, defer the slow ones, and append paginated rows with Inertia::merge()."
seoTitle: "Inertia partial reloads"
date: 2026-10-10T06:40:00Z
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---

A normal Inertia visit runs every prop on the page. Partial reloads exist so a filter, a poll, or a "load more" button does not redo the expensive ones. The visit has to target the page you are already on. A link to a different component always loads the full page.

The list those props come from is the [CRUD guide](/laravel-inertia-vue-crud). Counted pages versus cursors are [pagination](/laravel-vue-pagination). The app is [Inertia, a SPA, or Nuxt](/laravel-vue-in-2026).

## only and except

Wrap props you can skip in a closure. Inertia evaluates the closure when that key is needed. A value computed before `Inertia::render` runs on every visit, including a partial one.

```php
return Inertia::render('posts/Index', [
    'posts' => fn () => Post::query()->latest('id')->paginate(10)->withQueryString(),
    'categories' => fn () => Category::query()->orderBy('name')->get(['id', 'name']),
]);
```

```vue
<script setup lang="ts">
import { router } from "@inertiajs/vue3";

function refreshPosts() {
  router.reload({ only: ["posts"] });
}
</script>
```

`only: ['posts']` tells Laravel to skip `categories`. `except: ['categories']` is the same idea written the other way. A `<Link>` can do it without a function. `:only` is a partial reload, not a partial form post.

```vue
<Link href="/posts?published=1" :only="['posts']">Published</Link>
```

Dot keys work for nested props. `only: ['auth.notifications']` reloads that nested value and leaves the rest of `auth` alone.

## Deferred props

`Inertia::defer` leaves the prop out of the first response and fetches it immediately after the first paint. The Vue `<Deferred>` component renders the fallback until the key arrives. `#default="{ reloading }"` is how you dim the list during a later reload. `#rescue` renders when you passed `rescue: true` and the callback threw.

```php
'permissions' => Inertia::defer(fn () => Permission::query()->orderBy('name')->get(), rescue: true),
```

```vue
<script setup lang="ts">
import { Deferred, router } from "@inertiajs/vue3";

defineProps<{
  permissions?: { id: number; name: string }[];
}>();
</script>

<template>
  <Deferred data="permissions" #default="{ reloading }">
    <template #fallback>
      <p>Loading permissions...</p>
    </template>

    <template #rescue="{ reloading }">
      <button
        type="button"
        :disabled="reloading"
        @click="router.reload({ only: ['permissions'] })"
      >
        Retry
      </button>
    </template>

    <ul :class="{ 'opacity-50': reloading }">
      <li v-for="permission in permissions" :key="permission.id">
        {{ permission.name }}
      </li>
    </ul>
  </Deferred>
</template>
```

`permissions` on that page is still a prop. `<Deferred>` does not fetch a URL you invent. It waits for the prop named in `data`.

`->once()` on a deferred prop keeps the value across later visits until you explicitly reload it. Inertia also ships `WhenVisible` for a deferred prop that should wait until the block scrolls into view. The prop name is the same contract. Use it for a block below the fold, not for the main list.

## Load more

`Inertia::merge()` appends on a partial reload. A full visit replaces the prop even if you marked it for merging. The documented way to append a paginator's rows is `append('data')`. Reset the prop when the search changes, or page two of a new query sticks to the end of the old rows.

```php
'posts' => Inertia::merge(
    fn () => Post::query()->latest('id')->paginate(10)
)->append('data'),
```

```vue
function more() { router.reload({ only: ["posts"], data: { page:
props.posts.current_page + 1 }, }); } function search(value: string) {
router.reload({ only: ["posts"], data: { search: value, page: 1 }, reset:
["posts"], }); }
```

Previous and Next links that replace the list, instead of appending, stay on the pagination page. `simplePaginate` is the right object when you do not want a total. Merge is the wrong tool for that footer.

## Where this stops

Live updates from the server are [Reverb](/laravel-reverb-vue), not a timer that calls `router.reload`. A reload still asks Laravel. A broadcast pushes.
