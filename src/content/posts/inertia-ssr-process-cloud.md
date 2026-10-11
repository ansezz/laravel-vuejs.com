---
id: 132
title: "Keep the Inertia SSR process running"
seoTitle: "Keep the Inertia SSR process up"
excerpt: "npm run build does not refresh the SSR bundle. Production needs build:ssr and a process that stays up."
description: "npm run build does not refresh the SSR bundle. Production needs build:ssr and a process that stays up."
date: 2026-10-11T11:19:00Z
snippet: "php artisan inertia:start-ssr"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---
People searching "Inertia SSR not updating" deploy `npm run build` and the HTML stays old. That command writes `public/build`. It does not refresh `bootstrap/ssr`. The [SSR guide](/inertia-ssr) is the build. The [deploy guide](/deploy-laravel-vue) is the process that has to stay up. This page is the pair.

```shell
npm run build:ssr
php artisan inertia:start-ssr
```

Locally, `composer run dev` already server-renders. The current Vue starter kit has no `dev:ssr` script. You do not run `inertia:start-ssr` during development.

In production the Node process has to be supervised. If it dies, Inertia falls back to the client shell and the first response is empty of your page HTML. A public page that needed the HTML is the page that suffers. An app that is entirely behind login can skip SSR, which the SSR guide also says.

Do not start a second SSR process on a different port and leave `config/inertia.php` pointing at the old one. Do not read `window` in setup. The SSR guide explains that crash.
