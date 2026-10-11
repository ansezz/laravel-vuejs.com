---
id: 123
title: "Show failed jobs to an admin"
seoTitle: "Failed jobs table"
excerpt: "queue:failed-table stores the failure. An admin page may show the name and the time. It does not show the payload."
description: "queue:failed-table stores the failure. An admin page may show the name and the time. It does not show the payload."
date: 2026-10-11T11:10:00Z
snippet: "php artisan queue:failed-table"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---
People searching "Laravel failed jobs Vue" render the `exception` column in the page. That text can include request data. Store the failures, and show an admin the safe columns. The [queue guide](/laravel-vue-queued-job) is the happy path.

```shell
php artisan queue:failed-table
php artisan migrate
```

`QUEUE_CONNECTION` has to be something that records failures. `sync` runs the job in the request and does not use this table.

An admin page can pass:

```php
'failed' => DB::table('failed_jobs')->orderByDesc('id')->limit(20)->get(['id', 'uuid', 'failed_at']),
```

Retry from a command you trust, not from a public button:

```shell
php artisan queue:retry all
```

Do not put `payload` or `exception` in an Inertia prop. Do not let every signed-in user open this list. A failed mail job is not their business unless they administer the app.
