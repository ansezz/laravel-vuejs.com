---
id: 21
title: "Laravel Sail with Vue and Vite"
excerpt: "Sail runs PHP, the database, and npm in Docker. The Vue dev server is a Sail command, and HMR fails when the browser cannot see that container."
description: "Run a Laravel and Vue app with Sail: sail:install, sail up, migrations, npm run dev, and the documented HMR host."
seoTitle: "Laravel Sail and Vue"
date: 2026-10-10T05:40:00Z
snippet: "php artisan sail:install"
categories: [laravel, vuejs]
tags: [laravel, vuejs, setup, tooling]
---

Sail is Docker for the Laravel app, the database, and the Node process that Vite uses. It is not a second way to structure Vue. You still pick Inertia, a SPA, or Nuxt in [the stack guide](/laravel-vue-in-2026), and you still follow [what you need](/requirements) for PHP 8.3 and Node. Sail only changes where those binaries run.

Install Sail from the host, then stop using the host's `php` and `npm` for this app.

```bash
php artisan sail:install
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

`sail:install` writes `compose.yaml` and updates `.env`. It does not write a Dockerfile. `sail artisan sail:publish` copies the Dockerfiles into `docker/` when you need to edit them. `up -d` starts the containers in the background. `artisan` and `npm` inside `./vendor/bin/sail` run in the `laravel.test` container, so the PHP version on your laptop is not the PHP version of the app.

The site is `http://localhost` unless you changed `APP_PORT`. That is port 80 in the compose file, not the `localhost:8000` you get from `php artisan serve` on the host.

## The first Vue page

The [setup guide](/application-setup) still applies: a `Post` model, a factory, an Inertia page. Prefix Artisan with Sail.

```bash
./vendor/bin/sail artisan make:model Post -mf
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan test
```

`npm run dev` has to stay running for hot reload. Start it with Sail so the Vite process is on the Docker network the compose file publishes. A host `npm run dev` next to a Sail PHP container is how the page loads HTML from Docker and JavaScript from a server the browser cannot reach.

Stop the stack with `./vendor/bin/sail stop`. `./vendor/bin/sail down` removes the containers and keeps the database volume. `down -v` deletes that volume.

## When the page loads and edits do not

Laravel's Vite docs add this for Sail on WSL2, when the browser on the host cannot talk to the dev server inside the container. Put it on the existing `defineConfig` call. Do not delete the `laravel`, Vue, or Tailwind plugins the starter kit already has.

```js
// vite.config.js
export default defineConfig({
  // plugins stay as the kit generated them
  server: {
    hmr: {
      host: "localhost",
    },
  },
});
```

Restart `./vendor/bin/sail npm run dev` after the change. If the browser still requests a host that only exists inside Docker, the HMR host is the line that is wrong. The Laravel docs are the place that lists that setting. This page does not add other server flags.

`public/hot` appears while that dev server is running. It must not be deployed. The [deploy guide](/deploy-laravel-vue) covers that file.

## Where this stops

Sail does not choose your auth or your router. Cookie auth for a second origin is [Sanctum](/laravel-sanctum-vue-spa). Asset URLs, the `@` alias, and `VITE_` variables are [Vite](/laravel-vite-vue).
