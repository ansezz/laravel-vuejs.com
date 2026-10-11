---
id: 33
title: "Laravel policies on a Vue page"
excerpt: "A policy decides whether this user can update this post. The Vue page receives that boolean. The controller still calls authorize."
description: "Authorize a single Laravel post with a policy, and pass the same boolean to the Vue edit link."
seoTitle: "Laravel policies on a Vue page"
date: 2026-10-10T07:40:00Z
snippet: "php artisan make:policy PostPolicy --model=Post"
categories: [laravel, vuejs]
tags: [laravel, vuejs, permissions]
---

The posts in the [setup guide](/application-setup) have no owner. A policy needs one. This page adds `user_id`, then allows update only for that user. A permission such as "editor" is a different question and stays in [permissions](/laravel-vue-permissions). The screen is still the [CRUD guide](/laravel-inertia-vue-crud). The app is [Inertia, a SPA, or Nuxt](/laravel-vue-in-2026).

## The column

```php
Schema::table('posts', function (Blueprint $table) {
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
});
```

```php
// app/Models/Post.php
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

Add `user_id` to `$fillable`, and set it in `store` from the logged-in user. Do not take `user_id` from the request body. The form would then let anyone assign the post to someone else.

```php
Post::create([
    ...$data,
    'user_id' => $request->user()->id,
    'slug' => str($data['title'])->slug(),
    'published_at' => now(),
]);
```

## The policy

Laravel discovers `PostPolicy` for `Post` when the names match. You do not register it by hand.

```bash
php artisan make:policy PostPolicy --model=Post
```

```php
// app/Policies/PostPolicy.php
public function update(User $user, Post $post): bool
{
    return $user->id === $post->user_id;
}
```

`update` and `destroy` can share that line. `viewAny` can return `true` while the index is still a list of every post. Write the method you mean. An empty policy method that falls through to `false` hides every button and then looks like a Vue bug.

Call it from the controller. `authorize` throws 403 before the update runs.

```php
public function update(Request $request, Post $post): RedirectResponse
{
    $this->authorize('update', $post);

    // validation from the CRUD guide
}
```

Pass the same answer to the page. The link and the endpoint then agree.

```php
return Inertia::render('posts/Form', [
    'post' => $post->only(['id', 'title', 'excerpt']),
    'canUpdate' => $request->user()?->can('update', $post) ?? false,
]);
```

```vue
<Link v-if="canUpdate" :href="`/posts/${post.id}/edit`">Edit</Link>
```

On the index, that boolean is per row. Compute it in the query's map or share a list of ids the user can edit. Do not ship every user's id to the browser and decide there.

## A test

```php
it('forbids a user who does not own the post', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $post = Post::factory()->for($owner)->create();

    $this->actingAs($other)
        ->put("/posts/{$post->id}", [
            'title' => 'Taken',
            'excerpt' => 'Not yours.',
        ])
        ->assertForbidden();
});
```

The factory needs `user_id` once the column exists. `assertForbidden` is the assertion that matters. A test that only checks the missing link does not close the endpoint.

## Where this stops

Spatie permissions and this policy can both exist. An editor permission can allow `update` even when the user is not the owner, inside the policy, with `$user->can('posts.update')`. Put that combination in the policy so there is still one method the controller calls. Do not check the role in the Vue page.
