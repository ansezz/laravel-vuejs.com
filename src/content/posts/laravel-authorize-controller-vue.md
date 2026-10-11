---
id: 90
title: "Authorize a controller action before the Vue page"
seoTitle: "Authorize in the controller"
excerpt: "authorize() in the controller is the check. The Vue button can hide itself later."
description: "authorize() in the controller is the check. The Vue button can hide itself later."
date: 2026-10-11T10:37:00Z
snippet: "$this->authorize(\"update\", $post)"
categories: [laravel, vuejs]
tags: [laravel, vuejs, permissions]
---
People searching "Laravel authorize Vue" check the user in the component and leave the controller open. Call `authorize` before the write and before you render an editor. The [policy guide](/laravel-vue-policies) is the policy class. This page is the call.

```php
public function edit(Post $post): Response
{
    $this->authorize('update', $post);

    return Inertia::render('posts/Edit', [
        'post' => $post->only(['id', 'title']),
    ]);
}
```

A guest or the wrong user gets a 403. Inertia shows its error page. The Edit vue file does not mount, so it does not need a branch for "not allowed" in order to be safe.

The matching policy method is `update(User $user, Post $post): bool`. Return false, do not abort inside the policy.

Do not pass `$request->user()->is_admin` from Vue as a field named `authorized`. The controller would be trusting the browser. Do not skip `authorize` on `update` because `edit` already checked. They are different requests.
