---
id: 65
title: "Remember a Vue filter with useRemember"
seoTitle: "Inertia useRemember"
excerpt: "useRemember keeps a filter in the history entry. It is the wrong place for a password or a draft you must not lose."
description: "useRemember keeps a filter in the history entry. It is the wrong place for a password or a draft you must not lose."
date: 2026-10-11T10:12:00Z
snippet: "const filters = useRemember({ search: \"\" })"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---
People searching "Inertia useRemember" want a search box to keep its text when they open a post and press Back. The list itself should still come from Laravel. The [pagination guide](/laravel-vue-pagination) owns the links. This page is the local text.

```vue
<script setup lang="ts">
import { useRemember } from "@inertiajs/vue3";

const filters = useRemember({ search: "" });
</script>

<template>
  <input v-model="filters.search" name="search" />
</template>
```

`useRemember` writes the object into the history state for this visit. Back restores it. A full reload does not. If the search must survive a reload, put `search` in the query string and read it from a prop.

Do not remember a password, a token, or a card number. History state is not a vault, and the back button shows it again. A draft that must survive leaving the page belongs in [Pinia](/pinia-laravel-inertia) only if you accept that a reload still clears it. The server is the place for a draft you cannot lose.
