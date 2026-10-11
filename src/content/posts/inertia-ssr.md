---
id: 34
title: "Server-render a Laravel and Vue Inertia app"
excerpt: "Public pages that need HTML on the first response use the SSR bundle and a process that stays up. An app that is entirely behind login can skip it."
description: "Server-render Inertia with npm run build:ssr, inertia:start-ssr, and a Vue page that does not read window during setup."
seoTitle: "Inertia server rendering"
date: 2026-10-10T07:50:00Z
snippet: "npm run build:ssr"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---

Inertia SSR runs your Vue page in Node and sends HTML as the first response. Use it when a public page has to be readable without waiting for JavaScript. A tool that is entirely behind login does not need that HTML. The browser loads the client bundle after the redirect to login either way.

The host process that keeps SSR running is the [deploy guide](/deploy-laravel-vue). This page is the build and the Vue code that crashes it. The choice of Inertia versus Nuxt for a public site is [the stack guide](/laravel-vue-in-2026). Nuxt is the other way to get HTML. You do not run both for the same pages.

## The commands

Production SSR is a second bundle. `npm run build` writes only the browser files in `public/build`. It does not refresh `bootstrap/ssr`. Ship this instead:

```bash
npm run build:ssr
```

Locally, `npm run dev` and `composer run dev` already server-render through the Inertia Vite plugin. The current Vue starter kit has no `dev:ssr` script, and you do not run `inertia:start-ssr` during development.

In production the process has to stay up:

```bash
php artisan inertia:start-ssr
php artisan inertia:check-ssr
php artisan inertia:stop-ssr
```

`inertia:check-ssr` is how you confirm the process answered before you blame the page. `inertia:start-ssr` accepts `--runtime=bun` when you are actually running Bun. Do not add the flag on a Node host.

`public/hot` still must not be on the server. SSR does not make a dev server safe to deploy.

## window is not there

The first render has no `document` and no `window`. A line in `<script setup>` that reads `window.innerWidth` throws during that render. Inertia then falls back to the client-only page. Read the browser inside `onMounted`, or guard it.

```ts
import { onMounted, ref } from "vue";

const width = ref(0);

onMounted(() => {
  width.value = window.innerWidth;
});
```

Pinia has the same constraint. Create the store inside the existing `withApp` callback, not at module scope, so two SSR requests do not share one store. That callback is the [Pinia guide](/pinia-laravel-inertia). A manual `setup` callback turns off the Vite plugin's SSR wiring.

## What to render

SSR the public post list if search engines or link previews need the titles in the HTML. Leave the settings screen as a normal Inertia visit. You do not have to server-render every component because one marketing page needed it. The SSR server renders the first visit of each page you built the bundle for. It is a process you operate, next to the queue worker.

Deferred props still arrive after the HTML. They are not in the first document. [Partial reloads](/inertia-partial-reloads) explain that request. Do not defer the title you wanted Google to see.

## Where this stops

The supervise step on a VPS, `php artisan optimize`, and the queue are the deploy guide. This page does not pick a host.
