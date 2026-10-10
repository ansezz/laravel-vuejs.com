---
id: 26
title: "Nuxt 4 in front of a Laravel API"
excerpt: "Nuxt renders the public site. Laravel stays the API. The cookie rules stay in the Sanctum guide. This page is the Nuxt call."
description: "Put Nuxt 4 in front of a Laravel API with runtimeConfig and useFetch credentials, and keep Sanctum's cookie rules in one place."
seoTitle: "Nuxt 4 in front of Laravel"
date: 2026-10-10T06:30:00Z
snippet: "npm create nuxt@latest"
categories: [laravel, vuejs]
tags: [laravel, vuejs, nuxtjs, sanctum]
---

Use Nuxt when the public site is the product and Laravel is the API behind it. Nuxt 3 stopped receiving updates on 31 July 2026, so a new front end starts on Nuxt 4. Node is 22.12 or newer, or 24, the same floor as [the requirements](/requirements). Do not start here for an internal tool. The Vue starter kit already has login and routing. That choice is [Inertia, a SPA, or Nuxt](/laravel-vue-in-2026).

## The API URL

Keep the Laravel origin in runtime config. A hardcoded `localhost:8000` inside a component is the URL that ships to production.

```bash
npm create nuxt@latest
```

```ts
// nuxt.config.ts
export default defineNuxtConfig({
  runtimeConfig: {
    public: {
      apiUrl: "http://localhost:8000",
    },
  },
});
```

Set `NUXT_PUBLIC_API_URL` in the Nuxt environment when the host changes. Nuxt maps that name onto `runtimeConfig.public.apiUrl`.

## The request

`useFetch` with `credentials: 'include'` sends the session cookie. The cookie only exists after the Sanctum flow: stateful domains, `supports_credentials`, `GET /sanctum/csrf-cookie`, then `POST /login`. Those steps are [Sanctum for a Vue SPA](/laravel-sanctum-vue-spa). Nuxt's dev server is usually port 3000, so that origin is the one you add. CORS for that port is [the CORS guide](/laravel-vue-cors). This page does not copy either setup.

```vue
<script setup lang="ts">
const config = useRuntimeConfig();

const { data, error } = await useFetch(`${config.public.apiUrl}/api/posts`, {
  credentials: "include",
});
</script>

<template>
  <p v-if="error">Could not load posts.</p>
  <article v-for="post in data?.data" :key="post.id">
    <h2>{{ post.title }}</h2>
  </article>
</template>
```

`data.data` is there because a Laravel paginator or an API resource collection returns `{ data, links, meta }`. The resource class is [API resources](/laravel-api-resources-vue). If the controller returns a raw array, drop the extra `.data`. Guessing which shape you have is how the list renders blank.

## Auth from Nuxt

Call `/sanctum/csrf-cookie` and `/login` on the Laravel origin, with credentials, before this `useFetch` expects a user. A 401 means there is no session. A 419 means the CSRF cookie was missing. Both are diagnosed in the Sanctum guide. Nuxt middleware can redirect to your login page on 401. It cannot fix the cookie.

Do not put a Laravel token in `localStorage` for this first-party site. Sanctum's own docs tell a first-party SPA to use the session cookie.

## Where this stops

Admin screens that only staff use can stay on Inertia inside Laravel. You do not have to rebuild them in Nuxt. Deploy the two apps as two processes. The Laravel half still follows [deploy](/deploy-laravel-vue), including `public/hot` and `php artisan optimize`.
