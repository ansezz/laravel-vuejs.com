---
id: 136
title: "Run migrations in the release, not in a request"
seoTitle: "Migrate on deploy"
excerpt: "php artisan migrate --force belongs in the release step. A Vue button must not be the thing that migrates production."
description: "php artisan migrate --force belongs in the release step. A Vue button must not be the thing that migrates production."
date: 2026-10-11T11:23:00Z
snippet: "php artisan migrate --force"
categories: [laravel, vuejs]
tags: [laravel, vuejs, setup]
---
People searching "Laravel migrate on deploy" hit the site once so `AppServiceProvider` can run migrations. Run them in the release, before the new code serves traffic. The [deploy guide](/deploy-laravel-vue) lists this command.

```shell
php artisan migrate --force
```

`--force` is required when `APP_ENV` is production. It answers yes. Read the migration before you ship it. A `down()` that drops a column is not a small mistake.

Do not call `Artisan::call('migrate')` from a controller the Vue page can hit. Two deploys, or two curious browsers, should not race that. Do not migrate from a queued job "so the request stays fast". The new code and the old schema would be live together until the job runs.
