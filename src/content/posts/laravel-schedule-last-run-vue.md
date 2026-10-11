---
id: 124
title: "Record when a schedule last ran"
seoTitle: "When a schedule last ran"
excerpt: "schedule:list shows the next time. It does not store a last run. Write a timestamp from the command if the Vue page needs one."
description: "schedule:list shows the next time. It does not store a last run. Write a timestamp from the command if the Vue page needs one."
date: 2026-10-11T11:11:00Z
snippet: "php artisan schedule:list"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---
People searching "Laravel schedule last run" look for a column that does not exist. `routes/console.php` defines the schedule. `php artisan schedule:list` prints the next due time. The Vue page needs a row you write yourself if it must show "last ran".

```php
use Illuminate\Support\Facades\Schedule;

Schedule::command('reports:daily')->daily()->withoutOverlapping();
```

`withoutOverlapping()` uses the cache so a slow run is not started twice. It is not a history table.

Inside the command, after the work:

```php
Cache::forever('reports.daily.last_run', now()->toIso8601String());
```

Share that string with an admin page. `forever` here means "until the next success overwrites it", not "keep a history".

Do not scrape the scheduler's mutex and show it as the last success. The mutex means "it is running or it crashed while holding the lock". Do not run `schedule:work` from the Vue page. The system cron runs `schedule:run` every minute, or the platform does.
