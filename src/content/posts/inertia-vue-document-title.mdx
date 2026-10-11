---
id: 46
title: "Set the Inertia document title in Vue"
excerpt: "The starter kit already appends the app name. Set VITE_APP_NAME, then give each page a title and one meta description."
description: "Set an Inertia Vue page title and meta description. The starter kit already appends the app name from VITE_APP_NAME."
seoTitle: "Inertia titles and meta in Vue"
date: 2026-10-10T09:20:00Z
snippet: "VITE_APP_NAME"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---

A Vue page renders inside the document body. It cannot write the `<title>` by putting a tag in the template and hoping the browser promotes it. Inertia's `<Head>` does that write. The [setup guide](/application-setup) already uses `<Head title="Posts" />` on the first list. This page is the app name and the description that list still lacks.

The stack is [Laravel and Vue in 2026](/laravel-vue-in-2026). Server rendering of the same tags is [Inertia SSR](/inertia-ssr).

## The app name is already appended

The Vue starter kit sets the callback in `resources/js/app.ts`:

```ts
const appName = import.meta.env.VITE_APP_NAME || "Laravel";

title: (title) => (title ? `${title} - ${appName}` : appName),
```

`<Head title="Posts" />` becomes `Posts - My App` once `VITE_APP_NAME` is `My App`. Leave the callback. An app that does not have it yet should add that `title` function inside the existing `createInertiaApp` call, next to the [layout callback](/inertia-vue-persistent-layout) and `progress`. Do not start a second `createInertiaApp`.

`VITE_APP_NAME` belongs in `.env`. Vite only exposes names that start with `VITE_`, which the [Vite guide](/laravel-vite-vue) already covers. Restart `npm run dev` after you change it. A running dev server keeps the previous value.

When a page sets no title, the callback keeps the app name. It does not render a leading hyphen.

## One description

A layout can ship a default description. A page replaces it. Both tags need the same `head-key`, or the document keeps both and the first one is the one a crawler may read.

```vue
<Head title="Posts">
  <meta
    head-key="description"
    name="description"
    content="Posts you have published."
  />
</Head>
```

Inertia renders a single `<title>`. It stacks every other head tag unless `head-key` marks them as the same slot. Use `description` for that slot on the layout and on the page.

The first HTML response, before Vue runs, still comes from `resources/views/app.blade.php`. A title in that file is the fallback. `<Head>` replaces it on the visit. When SSR is off, the Blade component below is the fallback and is skipped once SSR is rendering the head itself:

```blade
<x-inertia::head>
  <title>{{ config('app.name') }}</title>
  <meta name="description" content="Posts you have published." />
</x-inertia::head>
```

`config('app.name')` and `VITE_APP_NAME` are two settings. Set both to the same words, or the first paint and the next click disagree.
