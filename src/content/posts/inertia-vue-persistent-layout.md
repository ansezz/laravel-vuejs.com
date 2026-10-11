---
id: 48
title: "Keep the Vue layout between Inertia visits"
excerpt: "The Vue starter kit already keeps one layout alive between pages. Wrapping each page in AppLayout builds a new shell every time."
description: "The Vue starter kit already keeps one layout between visits. Wrapping each page in AppLayout builds a new shell every time."
seoTitle: "Inertia persistent layouts"
date: 2026-10-10T09:40:00Z
snippet: "layout: AppLayout"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---

An older Vue tutorial wraps every page in `<AppLayout>` inside the template. Inertia destroys that component on the next visit and creates another one. The sidebar scroll jumps back to the top. The Vue starter kit does not wrap the page. It names the layout once, and Inertia keeps that instance.

Do not add a second `createInertiaApp`. Do not wrap the page as well. The inner shell would still remount. The title callback in that same call is the [document title guide](/inertia-vue-document-title). The stack is [Laravel and Vue in 2026](/laravel-vue-in-2026).

## What the kit already chooses

`resources/js/app.ts` already passes a `layout` function. Leave it.

```ts
layout: (name) => {
    switch (true) {
        case name === "Welcome":
            return null;
        case name.startsWith("auth/"):
            return AuthLayout;
        case name.startsWith("settings/"):
            return [AppLayout, SettingsLayout];
        default:
            return AppLayout;
    }
},
```

`Welcome` has no shell. Sign-in pages use `AuthLayout`. Settings pages nest `SettingsLayout` inside `AppLayout`. Every other page uses `AppLayout`. A component returned from the page replaces this function for that page only. The kit pages do not return one.

## Breadcrumbs are props

`AppLayout` already accepts `breadcrumbs`. A page can pass them and still use the function above:

```vue
defineOptions({ layout: { breadcrumbs: [{ title: "Posts", href: "/posts" }], },
});
```

That object is not a component. Inertia merges it onto the default layout. The dashboard page in the kit does the same thing with its own crumbs. Putting `AppLayout` in that option would replace the function in `app.ts`.

## When the template still wraps the page

Use this only on an app that does not already have the function above. Move the component out of the template.

```vue
<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";

defineOptions({ layout: AppLayout });
</script>

<template>
  <h1>Posts</h1>
</template>
```

Delete the `<AppLayout>` tags around the page. The template is only the slot. On the starter kit, skip this. The function in `app.ts` already selected the component.

## Where this stops

This page does not draw the sidebar, and it does not add a layout package. Settings already nest two layouts in the array above. The logged-in user inside that shell is the [setup guide](/application-setup).
