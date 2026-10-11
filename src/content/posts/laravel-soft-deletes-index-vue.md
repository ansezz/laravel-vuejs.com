---
id: 103
title: "Keep soft-deleted rows off a Vue index"
seoTitle: "Soft deletes on an index"
excerpt: "SoftDeletes hides deleted rows from a normal query. Do not filter them again in Vue."
description: "SoftDeletes hides deleted rows from a normal query. Do not filter them again in Vue."
date: 2026-10-11T10:50:00Z
snippet: "use SoftDeletes;"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---
People searching "Laravel soft deletes Vue" delete a row, see it disappear, and then also filter `deleted_at` in the component. The trait already did the filter. The [CRUD guide](/laravel-inertia-vue-crud) is the destroy action.

```php
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
}
```

The migration needs a nullable `deleted_at` timestamp. `$post->delete()` sets it. `Post::query()->paginate(12)` does not return that row. The Vue list renders `posts.data` and does not know about the column.

A trash screen is the exception. `Post::onlyTrashed()->paginate(12)` is an admin page with its own [policy](/laravel-vue-policies). Do not pass trashed rows to the public index and hide them with `v-if`.

Do not call `forceDelete()` from the button you labeled Delete. That removes the row. Soft delete is the one you can restore.
