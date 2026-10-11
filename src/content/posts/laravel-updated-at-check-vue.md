---
id: 96
title: "Reject a Vue form that edited a stale row"
seoTitle: "Reject a stale Vue form"
excerpt: "Send updated_at with the form and compare it before you write. Do not use HTTP 409 for that."
description: "Send updated_at with the form and compare it before you write. Do not use HTTP 409 for that."
date: 2026-10-11T10:43:00Z
snippet: "$post->updated_at->equalTo(...)"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---
People searching "Laravel optimistic lock Vue" want two editors to stop overwriting each other. Send the `updated_at` you rendered, and refuse the write when it no longer matches. This is not an Inertia visit feature. It is a check in the controller. The [CRUD guide](/laravel-inertia-vue-crud) is the form.

```php
$validated = $request->validate([
    'title' => ['required', 'string', 'max:120'],
    'updated_at' => ['required', 'date'],
]);

if (! $post->updated_at->equalTo($request->date('updated_at'))) {
    return back()->withErrors([
        'title' => 'This post changed. Reload and try again.',
    ]);
}

$post->update(['title' => $validated['title']]);
```

The Vue form sends the prop, not the clock on the laptop:

```vue
<input type="hidden" name="updated_at" :value="post.updated_at" />
```

Do not `abort(409)` here. Inertia uses 409 when the asset version changed after a [deploy](/deploy-laravel-vue), and the client reloads instead of showing the error bag. Do not compare a date string you formatted for humans. Compare the timestamp the model cast.
