---
id: 125
title: "Prune old rows on a schedule"
seoTitle: "Prune old rows"
excerpt: "MassPrunable deletes rows that match prunable(). Schedule model:prune. Do not point that scope at users."
description: "MassPrunable deletes rows that match prunable(). Schedule model:prune. Do not point that scope at users."
date: 2026-10-11T11:12:00Z
snippet: "php artisan model:prune"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---
People searching "Laravel prune models" copy a scope onto `User` and then the schedule deletes accounts. Prune a table you can afford to lose, such as old invitations or expired exports. Put the command in `routes/console.php`. Something on the server has to call `schedule:run` every minute. The [deploy guide](/deploy-laravel-vue) is the release around that cron, not a replacement for it.

```php
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;

class Invitation extends Model
{
    use MassPrunable;

    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->subDays(30));
    }
}
```

```php
Schedule::command('model:prune')->daily();
```

`MassPrunable` deletes in SQL and does not fire model events. Use `Prunable` when you need `deleting`. Run `php artisan model:prune --pretend` before you trust the scope.

Do not prune from a Vue button that calls this on `User`. Do not write `where('created_at', '>=', ...)` and think you kept the old rows. That keeps the new ones and deletes the rest. Read the comparison twice.
