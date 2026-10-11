---
id: 89
title: "Move a Vue 2 component to script setup"
seoTitle: "Vue 2 options to script setup"
excerpt: "data() becomes ref. Methods become functions. An Inertia page still receives props. It does not gain Vue Router."
description: "data() becomes ref. Methods become functions. An Inertia page still receives props. It does not gain Vue Router."
date: 2026-10-11T10:36:00Z
snippet: "<script setup lang=\"ts\">"
categories: [laravel, vuejs]
tags: [laravel, vuejs, typescript]
---
People searching "Vue 2 options API to script setup" paste a Vue 2 component into an Inertia page and keep `export default`. The Vue starter kit pages are `<script setup lang="ts">`. The [TypeScript guide](/typescript-laravel-vue-pages) is the prop type. This page is the move.

```vue
<script setup lang="ts">
import { ref } from "vue";

defineProps<{ title: string }>();

const open = ref(false);

function toggle() {
  open.value = !open.value;
}
</script>

<template>
  <button type="button" @click="toggle">{{ title }}</button>
</template>
```

`data()` becomes `ref`. You need `.value` in the script and you do not need it in the template. `props` from the controller replace `this.$page` reads you used to do in `created()`. Use `usePage()` when you need a shared prop.

Do not install Vue Router while you convert a component. Inertia still navigates. The [stack guide](/laravel-vue-in-2026) is why a second router stays off this kit. Do not keep `new Vue()` in `app.ts`. The kit already calls `createInertiaApp`.
