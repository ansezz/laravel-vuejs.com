---
id: 35
title: "Laravel Vite and Vue"
excerpt: "The starter kit already runs Vite. The pieces people break are the @ alias, a secret in a VITE_ variable, and a public/hot file left on the server."
description: "Configure Laravel Vite for Vue: the @ alias, which env vars reach the browser, and why public/hot breaks production."
seoTitle: "Laravel Vite and Vue"
date: 2026-10-10T08:00:00Z
snippet: "npm run dev"
categories: [laravel, vuejs]
tags: [laravel, vuejs, tooling]
---

`laravel new` with the Vue starter kit already wires Vite, the Vue plugin, and the Laravel plugin. You do not replace `vite.config.ts` to "add Vue". This page is the three edits that go wrong after that: imports, environment variables, and the dev server file. Production builds are the [deploy guide](/deploy-laravel-vue). Sail's HMR host is [Sail](/laravel-sail-vue). The app those assets belong to is [Inertia, a SPA, or Nuxt](/laravel-vue-in-2026).

## Dev and build

`npm run dev` writes `public/hot` and serves assets from the Vite process. Laravel reads that file and points the browser at the dev server. That is what you want on your machine.

`npm run build` writes `public/build` and removes the need for `public/hot`. If `public/hot` is on the server, every page loads JavaScript from the URL in that file, which is your laptop. Delete it. Do not commit it. The deploy guide is the checklist around that file.

Restart `npm run dev` after `.env` changes. Vite reads `VITE_*` at startup and inlines them at build time. A key you add later is not in the bundle until you build again.

## The @ alias

The kit aliases `@` to `resources/js`. If a fresh config lost it, put it back beside the plugins. Do not remove `laravel()`, Vue, Tailwind, or Wayfinder while you add the alias.

```ts
import { fileURLToPath, URL } from "node:url";
import { defineConfig } from "vite";

export default defineConfig({
  // plugins: keep the kit's laravel(), vue(), tailwindcss(), and wayfinder()
  resolve: {
    alias: {
      "@": fileURLToPath(new URL("./resources/js", import.meta.url)),
    },
  },
});
```

```vue
import PostForm from "@/pages/posts/Form.vue";
```

A relative `../../pages/posts/Form.vue` works until a file moves. The alias is the path the rest of the kit already uses, including [Wayfinder](/laravel-wayfinder-vue) imports under `@/actions`.

## What VITE_ exposes

Only variables whose names start with `VITE_` are available as `import.meta.env.VITE_...`. That is a browser bundle. Anyone who can load the JavaScript can read them.

```ts
const key = import.meta.env.VITE_REVERB_APP_KEY;
```

A Reverb app key is public by design. A database password, a GitHub client secret, or a mail password is not. Those stay in Laravel's `.env` and are read with `env()` or `config()` on the server. Prefixing a secret with `VITE_` so a Vue page can "just use it" publishes the secret.

The Laravel origin, the Reverb host, and the Reverb port are the usual public values. Set them before `npm run build`. The [Reverb guide](/laravel-reverb-vue) is why the key has to be in the bundle at all.

## Where this stops

Vite does not authenticate the API. Cookie setup for a separate dev server on port 5173 is [CORS](/laravel-vue-cors) and [Sanctum](/laravel-sanctum-vue-spa). Same-origin Inertia, opened through the Laravel URL, does not need that CORS file.
