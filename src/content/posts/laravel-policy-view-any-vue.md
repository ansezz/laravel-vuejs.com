---
id: 93
title: "Gate a Vue index with viewAny"
seoTitle: "Policy viewAny for an index"
excerpt: "viewAny takes the model class, not a row. Call it on the index before you paginate."
description: "viewAny takes the model class, not a row. Call it on the index before you paginate."
date: 2026-10-11T10:40:00Z
snippet: "$this->authorize(\"viewAny\", Post::class)"
categories: [laravel, vuejs]
tags: [laravel, vuejs, permissions]
---
People searching "Laravel viewAny Vue" call `authorize('view', $post)` on the index and then the index has no post to pass. `viewAny` is the index check. `view` is one row. The [policy guide](/laravel-vue-policies) is the class. The [CRUD guide](/laravel-inertia-vue-crud) is the list.

```php
public function viewAny(User $user): bool
{
    return $user->can('posts.view');
}

public function index(Request $request): Response
{
    $this->authorize('viewAny', Post::class);

    return Inertia::render('posts/Index', [
        'posts' => Post::query()->latest('id')->paginate(12),
    ]);
}
```

The second argument is the class. An instance would call `view`, not `viewAny`.

Do not filter the rows in Vue after sending every post to the browser. If the user may only see their own, scope the query as well as the gate. The gate answers "may this person open the index?". The query answers "which rows?".
