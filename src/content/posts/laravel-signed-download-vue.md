---
id: 115
title: "Download a file through a signed URL"
seoTitle: "Signed Laravel download"
excerpt: "temporarySignedRoute plus the signed middleware. An Inertia Link cannot download the file. Use an anchor."
description: "temporarySignedRoute plus the signed middleware. An Inertia Link cannot download the file. Use an anchor."
date: 2026-10-11T11:02:00Z
snippet: "URL::temporarySignedRoute('posts.download', now()->addMinutes(5), ...)"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---
People searching "Laravel signed download Vue" put the storage path in the Vue page. Generate a short-lived URL and check the policy anyway. A leaked link should expire, and it should still fail for the wrong user. The [upload guide](/laravel-vue-file-upload) is how the file got there.

```php
public function show(Request $request, Post $post): Response
{
    $this->authorize('view', $post);

    return Inertia::render('posts/Show', [
        'download' => URL::temporarySignedRoute(
            'posts.download',
            now()->addMinutes(5),
            ['post' => $post->id],
        ),
    ]);
}
```

```php
Route::get('/posts/{post}/download', function (Post $post) {
    abort_unless(auth()->user()?->can('view', $post), 403);

    return Storage::disk('local')->download($post->cover_path);
})->middleware(['auth', 'signed'])->name('posts.download');
```

```vue
<a :href="download">Download</a>
```

`<Link>` expects an Inertia response. A file is not one, so the browser should navigate with a normal anchor.

Do not put the signature on a public disk URL and skip `can('view')`. The signature proves the URL was not edited. It does not prove this user may have the file.
