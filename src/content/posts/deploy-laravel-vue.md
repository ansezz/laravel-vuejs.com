---
id: 14
title: "Deploy a Laravel and Vue app"
excerpt: "The production build Laravel Cloud documents, the Inertia SSR bundle, the queue, and the public/hot file that breaks a live site."
description: "Deploy Laravel and Vue: npm run build or build:ssr, php artisan optimize, a queue worker, and how to keep Vite off the dev server."
seoTitle: "Deploy a Laravel and Vue app"
date: 2026-10-10T04:30:00Z
snippet: "npm run build"
categories: [laravel, vuejs]
tags: [laravel, vuejs, tooling]
---

A Laravel and Vue app is one PHP app plus a Vite build. The mistake that takes sites down is shipping `public/hot`, which tells Laravel to load assets from the dev server. The rest is a short list.

This assumes the [Vue starter kit](/application-setup). A separate SPA from the [Sanctum guide](/laravel-sanctum-vue-spa) is two deploys: this one for the API, and the SPA host for the static files.

## The build

[Laravel Cloud's deploy guide](https://laravel.com/cloud/docs/deploy-guides/laravel) uses this on every release:

```bash
composer install --no-dev
npm ci --audit false
npm run build
php artisan optimize
```

`npm run build` writes `public/build` and a manifest. Blade's `@vite` reads that manifest. `php artisan optimize` caches config, routes, and views into the release. Run it during the build, not after the release is already taking traffic.

`APP_ENV` must be `production` and `APP_DEBUG` must be `false` before `optimize`. A cached config file keeps whatever was in the environment at that moment. Change a key later and you need another `php artisan optimize`, or `php artisan optimize:clear` if you are debugging.

Then:

```bash
php artisan migrate --force
```

`--force` is required when `APP_ENV` is production. Do not add `storage:link` to a Cloud deploy. Cloud's disk resets on every deploy, so the symlink does not survive, and Cloud's own guide says to skip that command. User uploads on Cloud belong in the object storage bucket Cloud attaches. On a VPS, `storage:link` is once per machine when that machine serves the `public` disk from the [file upload guide](/laravel-vue-file-upload).

## Do not deploy the dev server

Vite writes `public/hot` while `npm run dev` is running. If that file is on the server, every page tries to load JavaScript from your laptop's URL. Delete it. Do not commit it. The same goes for `node_modules`: install them in the build, then you only need the compiled files at runtime.

Set every `VITE_*` variable before `npm run build`. Vite inlines them. A Reverb key added after the build does not show up until you build again. See the [Reverb guide](/laravel-reverb-vue).

## Server-side rendering

The Vue starter kit can render the first HTML on the server. Laravel Cloud says to swap the asset command when you want that:

```bash
npm run build:ssr
```

Use it instead of `npm run build` when those pages need server HTML. `npm run build` writes only the browser bundle and leaves `bootstrap/ssr` stale. Locally, `composer run dev` already server-renders. The current starter kit has no `dev:ssr` script. In production the SSR process has to stay up, the same way a queue worker stays up. Laravel Cloud and Forge both know how to keep that process running. On a VPS you supervise `php artisan inertia:start-ssr` yourself.

SSR is how a public Inertia page has HTML for a crawler before Vue boots. A logged-in app can ship the client bundle only. Pick that in [the stack guide](/laravel-vue-in-2026), not at the end of a deploy.

## The queue

Mail, broadcasts, and any `ShouldQueue` listener do nothing without a worker:

```bash
php artisan queue:work
```

`composer run dev` started one on your machine. Production does not. On a VPS, supervise `php artisan queue:work` and signal it with `queue:restart` after each deploy so it loads the new code. Cloud restarts its workers itself, so `queue:restart` is not a Cloud deploy command.

If you broadcast with Reverb, that is a second long-running process. The asset build does not include it.

## A VPS in one paragraph

Point the web server at the `public` directory. The front controller is `public/index.php`. PHP 8.3 or newer, the extensions in [the requirements](/requirements), and a database. Put `public/build` on disk, keep `public/hot` off disk, run migrations, and supervise the queue. That is the same app Cloud builds. The host is the part you are now operating yourself.
