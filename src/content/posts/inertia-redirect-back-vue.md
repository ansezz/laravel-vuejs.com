---
id: 86
title: "Redirect back after an Inertia form"
seoTitle: "Inertia redirect back"
excerpt: "back() returns to the page that posted. to_route() is the right call when the next page is a specific list."
description: "back() returns to the page that posted. to_route() is the right call when the next page is a specific list."
date: 2026-10-11T10:33:00Z
snippet: "return back();"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---
People searching "Inertia redirect back" return `back()` from a create form and land on the create form again. That is what `back()` means. The [CRUD guide](/laravel-inertia-vue-crud) uses `to_route('posts.index')` after a save so the next page is the list.

Use `back()` when the user should stay where they were. A row button on the list is the usual case:

```php
public function publish(Request $request, Post $post): RedirectResponse
{
    $this->authorize('update', $post);
    $post->update(['published_at' => now()]);

    return back();
}
```

Inertia follows the redirect. The Vue page does not call `router.visit` after `form.post` unless you are doing something the redirect cannot express.

Use `to_route()` when the destination is fixed. Use `redirect()->route('posts.edit', $post)` after create when the next step is the editor.

Do not `return response()->json(['ok' => true])` from an Inertia action and then navigate in `onSuccess`. You dropped the redirect Inertia is built around. Do not `return back()` from a test and assert a JSON body.
