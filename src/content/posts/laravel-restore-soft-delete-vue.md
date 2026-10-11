---
id: 104
title: "Restore a soft-deleted row from Vue"
seoTitle: "Restore a soft-deleted row"
excerpt: "The restore route uses withTrashed() or the binding 404s before your controller runs."
description: "The restore route uses withTrashed() or the binding 404s before your controller runs."
date: 2026-10-11T10:51:00Z
snippet: "$post->restore()"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---
People searching "Laravel restore soft delete" call `restore()` on a normal route and get a 404. The row is deleted, so binding cannot see it. Opt in on that route only.

```php
Route::post('/posts/{post}/restore', [PostController::class, 'restore'])
    ->withTrashed()
    ->middleware('auth')
    ->name('posts.restore');
```

```php
public function restore(Post $post): RedirectResponse
{
    $this->authorize('restore', $post);
    $post->restore();

    return back();
}
```

The Vue button posts to that URL. It sits on the trash list, which used `onlyTrashed()`. A normal edit form should not offer restore.

Do not turn `withTrashed()` on for the whole route group. Edit and update would start opening deleted posts. Do not restore in the browser by clearing `deleted_at` on the prop. The column is not yours to edit from the page.
