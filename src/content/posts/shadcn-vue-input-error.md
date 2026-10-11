---
id: 67
title: "Show a field error with the kit input"
seoTitle: "Show a Vue input error"
excerpt: "The Vue starter kit already has InputError. Pass it the validation string. Do not install a second kit."
description: "The Vue starter kit already has InputError. Pass it the validation string. Do not install a second kit."
date: 2026-10-11T10:14:00Z
snippet: "<InputError :message=\"form.errors.email\" />"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---
People searching "shadcn vue input error" install shadcn-vue again on top of the Laravel Vue starter kit. The kit already includes it. The [setup guide](/application-setup) says so. The string you pass is the same `form.errors.email` the [CRUD guide](/laravel-inertia-vue-crud) prints in a paragraph.

The kit's component takes one message:

```vue
<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import InputError from "@/components/InputError.vue";

const form = useForm({ email: "" });
</script>

<template>
  <input v-model="form.email" name="email" type="email" />
  <InputError :message="form.errors.email" />
</template>
```

`form.errors.email` is a string. It is not an array. Inertia keeps the first message for the key. If your `InputError` expects `message`, pass that string. If the import path is missing, the component file is not there yet: use the paragraph from the CRUD guide instead of adding a library.

Do not run the shadcn CLI to "add the error component" inside this kit. You get a second copy of the primitives and two opinions about the field.
