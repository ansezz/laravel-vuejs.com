---
id: 138
title: "Commit .env.example, not .env"
seoTitle: "Commit .env.example only"
excerpt: ".env.example lists the keys with empty secrets. .env stays off the git remote. Vite only sees VITE_ keys."
description: ".env.example lists the keys with empty secrets. .env stays off the git remote. Vite only sees VITE_ keys."
date: 2026-10-11T11:25:00Z
snippet: "APP_KEY="
categories: [laravel, vuejs]
tags: [laravel, vuejs, setup]
---
People searching "Laravel .env.example Vue" commit `.env` so the next laptop works. That file has the app key and the database password. Commit the example. The [Vite guide](/laravel-vite-vue) is which of those values the browser is allowed to see.

`.env.example` looks like this:

```ini
APP_NAME=Laravel
APP_KEY=
APP_URL=http://localhost

VITE_APP_NAME="${APP_NAME}"
```

Empty secret, real key name. A teammate copies it to `.env` and fills it in. `APP_KEY` is generated with `php artisan key:generate`. You do not invent one and you do not reuse production's.

Do not prefix a secret with `VITE_` so the example "also works in Vue". That ships the secret. Do not add `.env` to the repo and gitignore it later. It is already in history. Rotate the key that leaked.
