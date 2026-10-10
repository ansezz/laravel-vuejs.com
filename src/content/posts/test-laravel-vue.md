---
id: 22
title: "Test a Laravel and Vue app"
excerpt: "Pest hits the Laravel routes. Vitest and Vue Test Utils hit one component. The starter kit does not ship a Vitest script until you add one."
description: "Test Laravel and Vue with Pest on the HTTP routes and Vitest plus Vue Test Utils on a single component."
seoTitle: "Test Laravel and Vue"
date: 2026-10-10T05:50:00Z
snippet: "php artisan test --filter=PostsTest"
categories: [laravel, vuejs]
tags: [laravel, vuejs, testing]
---

A Laravel and Vue app has two test runs because the two sides fail differently. Pest can prove a POST creates a row and that Inertia received `posts.data`. It does not mount the Vue page. Vitest can prove a component renders a title from a prop. It does not hit SQLite. [The requirements](/requirements) name both Pest and Vitest. This page is how to add the Vue half without pretending the starter kit already has it.

The feature tests for create, an empty title, and search are already in the [CRUD guide](/laravel-inertia-vue-crud). Run those first.

```bash
php artisan test --filter=PostsTest
```

Feature tests use the session stack. They do not need a CSRF token. `assertInertia` reads the props the controller returned. If `posts.data` is missing, the controller is still returning a plain array, which is the bug the CRUD page calls out.

## A component test

Do not claim the kit's `package.json` already has Vitest. Add it.

```bash
npm install -D vitest @vue/test-utils jsdom
```

```ts
// vitest.config.ts
import { defineConfig } from "vitest/config";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
  plugins: [vue()],
  test: {
    environment: "jsdom",
  },
});
```

Keep this file next to the kit's `vite.config.ts`. A component test should not boot Inertia's router. Pass props and read the text.

```vue
<!-- resources/js/components/PostTitle.vue -->
<script setup lang="ts">
defineProps<{ title: string }>();
</script>

<template>
  <h2>{{ title }}</h2>
</template>
```

```ts
// resources/js/components/PostTitle.test.ts
import { mount } from "@vue/test-utils";
import { describe, expect, it } from "vitest";
import PostTitle from "./PostTitle.vue";

describe("PostTitle", () => {
  it("renders the title", () => {
    const wrapper = mount(PostTitle, {
      props: { title: "Hello Laravel 13" },
    });

    expect(wrapper.text()).toContain("Hello Laravel 13");
  });
});
```

```json
{
  "scripts": {
    "test:unit": "vitest run"
  }
}
```

```bash
npm run test:unit
```

`jsdom` is there so `mount` has a document. If the component reads `window` at import time, the test fails the same way [server rendering](/inertia-ssr) fails. Move that read into `onMounted`, or pass the value in as a prop.

## What not to mock

Do not mount `posts/Index.vue` and stub `router.get` just to see a heading. That test breaks every time Inertia's API moves, and it never notices a wrong SQL `when`. The Pest test owns the query. The Vitest test owns markup that has no server.

Typed props for the page itself are [TypeScript on Vue pages](/typescript-laravel-vue-pages). The stack you are testing is [Inertia, a SPA, or Nuxt](/laravel-vue-in-2026).
