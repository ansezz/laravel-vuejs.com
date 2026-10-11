---
id: 109
title: "Cache a prop and forget it on write"
seoTitle: "Cache a prop, forget it on write"
excerpt: "Cache::remember stores a public count. Forget that key when a post is created. Do not cache one user's drafts under a global key."
description: "Cache::remember stores a public count. Forget that key when a post is created. Do not cache one user's drafts under a global key."
date: 2026-10-11T10:56:00Z
snippet: "Cache::remember('stats.posts', now()->addMinutes(5), ...)"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---
People searching "Laravel cache Vue page" remember the whole post list, including drafts, under one key. The next visitor sees the first visitor's rows. Cache a public number. The page that shows private rows stays on the [CRUD guide](/laravel-inertia-vue-crud) query.

```php
$stats = Cache::remember('stats.posts', now()->addMinutes(5), function () {
    return ['count' => Post::query()->count()];
});
```

Pass `$stats` as a prop. When a post is created or deleted, forget the key in that same request:

```php
Post::create([...]);
Cache::forget('stats.posts');
```

Five minutes is a choice for a homepage count, not for an editor.

Do not `Cache::remember` a paginator that called `where('user_id', auth()->id())` under a key with no user id in it. Do not cache the rendered Inertia page in a way that includes the CSRF token. That token belongs to one session.
