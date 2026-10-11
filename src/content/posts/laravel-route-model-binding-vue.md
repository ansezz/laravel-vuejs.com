---
id: 101
title: "Bind a Vue page to a route model"
seoTitle: "Route model binding"
excerpt: "Type-hint Post $post and the URL {post} resolves the row. A missing row is a 404."
description: "Type-hint Post $post and the URL {post} resolves the row. A missing row is a 404."
date: 2026-10-11T10:48:00Z
snippet: "public function show(Post $post)"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---
People searching "Laravel route model binding Vue" still `Post::find($id)` and then forget the 404. Type-hint the model. The parameter name matches the route segment. The [CRUD guide](/laravel-inertia-vue-crud) uses this on edit and update.

```php
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
```

```php
public function show(Post $post): Response
{
    return Inertia::render('posts/Show', [
        'post' => $post->only(['id', 'title']),
    ]);
}
```

`/posts/15` loads post 15. `/posts/99999` is a 404 before the method runs. The Vue page always receives a post.

A nested route such as `/posts/{post}/comments/{comment}` should scope the comment to the post. `scopeBindings()` on the route group does that. Without it, a comment id from another post still resolves.

Do not take the id from the query string when it is already in the path. Do not pass the whole model if the page needs two columns. `only()` keeps the payload small.
