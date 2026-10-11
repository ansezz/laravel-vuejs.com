---
id: 108
title: "Wrap a Vue save in a transaction"
seoTitle: "Database transaction around a save"
excerpt: "DB::transaction commits the post and its relations together. Redirect after the closure returns."
description: "DB::transaction commits the post and its relations together. Redirect after the closure returns."
date: 2026-10-11T10:55:00Z
snippet: "DB::transaction(function () { ... })"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---
People searching "Laravel transaction Vue" open a transaction and redirect inside it. The redirect throws, and the commit depends on how the exception is handled. Do the writes in the closure. Redirect after it returns. The [CRUD guide](/laravel-inertia-vue-crud) is the single-table version of this save.

```php
$post = DB::transaction(function () use ($request, $validated) {
    $post = Post::create([
        'title' => $validated['title'],
        'user_id' => $request->user()->id,
    ]);

    $post->tags()->sync($validated['tag_ids'] ?? []);

    return $post;
});

return to_route('posts.show', $post);
```

If `sync` throws, the post is not left behind. Validation stays outside the transaction. You do not hold a lock while you debate the request.

Do not catch `\Throwable` inside the closure and return a Vue error string. Let it roll back. Send a field error only when you know the failure is the user's input. Do not start a transaction in the Vue page.
