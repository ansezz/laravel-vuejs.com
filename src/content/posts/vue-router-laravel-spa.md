---
id: 43
title: "Vue Router on a Laravel API"
excerpt: "Routes, a login redirect, and a guest guard for a Vue app that is not Inertia. Load the user before the router runs."
description: "Add Vue Router to a separate Laravel SPA: login, a guest guard, and a load of the user before the first navigation."
seoTitle: "Vue Router with a Laravel API"
date: 2026-10-10T08:50:00Z
snippet: "npm install vue-router"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---

This router belongs in a Vue app that talks to Laravel over HTTP. It does not belong in the Vue starter kit. Inertia already changes the page. A second router fights that navigation, and the kit's URLs stay in `routes/web.php`. If you are on the kit, stop here and use [Laravel and Vue in 2026](/laravel-vue-in-2026).

The separate app is the case Sanctum's cookie flow is for. Axios, the CSRF cookie, and `withCredentials` stay in [Authenticate a Vue SPA with Laravel Sanctum](/laravel-sanctum-vue-spa). This page only adds the URLs. Client-only state inside an Inertia app is [Pinia](/pinia-laravel-inertia), which is a different file than the store below.

## The routes

```bash
npm install vue-router
```

Vue Router 4 is `createRouter` and `createWebHistory`. Two routes are enough to see the guard: `/login` is for guests, and `/` requires a user.

```ts
import { createRouter, createWebHistory } from "vue-router";
import Login from "./pages/Login.vue";
import Posts from "./pages/Posts.vue";

export const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/login",
      name: "login",
      component: Login,
      meta: { guest: true },
    },
    {
      path: "/",
      name: "posts",
      component: Posts,
      meta: { auth: true },
    },
  ],
});
```

The host that serves this SPA has to answer unknown paths with `index.html`. Otherwise a refresh on `/login` is a 404. The [deploy guide](/deploy-laravel-vue) is the second host for that SPA. It does not set this fallback.

## Load the user first

`router.beforeEach` that runs before you know who is logged in sends a valid session to `/login` on the first paint. Call `GET /api/user` and wait. A 401 means there is no session, so the store user stays null. Any other error is a failed API, not a logged-out user.

```ts
import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";

export const useAuth = defineStore("auth", () => {
  const user = ref(null);

  async function load() {
    try {
      user.value = (await axios.get("/api/user")).data;
    } catch (error) {
      if (axios.isAxiosError(error) && error.response?.status === 401) {
        user.value = null;
        return;
      }

      throw error;
    }
  }

  return { user, load };
});
```

Mount only after that call. The guard is registered before `mount`, so the first navigation already knows the answer.

```ts
import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import { router } from "./router";
import { useAuth } from "./stores/auth";

async function boot() {
  const app = createApp(App);
  const pinia = createPinia();
  app.use(pinia);

  const auth = useAuth();
  await auth.load();

  router.beforeEach((to) => {
    if (to.meta.auth && !auth.user) {
      return { name: "login" };
    }

    if (to.meta.guest && auth.user) {
      return { name: "posts" };
    }
  });

  app.use(router);
  app.mount("#app");
}

boot();
```

## After login

The login POST itself is the Sanctum article: CSRF cookie, then credentials, with credentials included. When that POST returns the user, write it into the store and move. Do not `window.location` assign. The router is the reason this page exists.

```ts
import { useRouter } from "vue-router";
import { useAuth } from "../stores/auth";

const router = useRouter();
const auth = useAuth();

auth.user = response.data;
await router.push({ name: "posts" });
```

`response` is the Axios response from that login POST. Logging out clears `auth.user` and pushes `{ name: "login" }` after Laravel's logout endpoint returns.

A third party with its own client id is not this router. That decision is [Sanctum or Passport](/laravel-sanctum-vs-passport). OAuth's redirect lives on the other product's server. Your first-party SPA keeps the cookie and these two routes.
