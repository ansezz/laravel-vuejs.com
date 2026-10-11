---
id: 87
title: "Read page props from a persistent layout"
seoTitle: "Props in a persistent layout"
excerpt: "A persistent layout does not receive the page props as its own props. usePage() does."
description: "A persistent layout does not receive the page props as its own props. usePage() does."
date: 2026-10-11T10:34:00Z
snippet: "usePage().props"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---
People searching "Inertia layout props Vue" pass the post into the layout component and then the title is empty. A persistent layout wraps the page. The page owns the props. The [layout guide](/inertia-vue-persistent-layout) is how the kit picks `AppLayout`. This page is how that layout reads a value.

```vue
<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";

const page = usePage();
</script>

<template>
  <header>{{ page.props.auth?.user?.name }}</header>
  <slot />
</template>
```

`auth` is shared in the [setup guide](/application-setup). A prop you returned from one controller, such as `post`, is on `page.props` only while that page is showing. Do not type the layout as if `post` is always there.

Do not wrap `<AppLayout>` inside the page template. The kit's `createInertiaApp` already chose the layout. A second wrap renders it twice. The layout guide says the same thing.
