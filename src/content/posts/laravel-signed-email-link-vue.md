---
id: 116
title: "Put a signed URL in an email"
seoTitle: "Signed link in an email"
excerpt: "temporarySignedRoute belongs in the mail. The Vue page opens after the signed middleware passes."
description: "temporarySignedRoute belongs in the mail. The Vue page opens after the signed middleware passes."
date: 2026-10-11T11:03:00Z
snippet: "->middleware('signed')"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---
People searching "Laravel signed URL email" build the link in Vue and hope the email client keeps it. Build it in PHP. The [Fortify guide](/laravel-fortify-vue) already does this for password reset. A custom mail uses the same middleware.

```php
$url = URL::temporarySignedRoute(
    'posts.review',
    now()->addDays(3),
    ['post' => $post->id],
);
```

Mail that string. The route is:

```php
Route::get('/posts/{post}/review', [PostController::class, 'review'])
    ->middleware('signed')
    ->name('posts.review');
```

An edited query string fails the signature and Laravel returns 403. The controller can render an Inertia page after that. The link in the email is a normal `<a href>`. It is not an Inertia `<Link>`, because a mail client is not your app.

Do not sign the URL for a year. Three days is a decision you can defend. Do not log the full URL. It is the credential.
