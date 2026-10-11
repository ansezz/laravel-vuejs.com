---
id: 119
title: "Show a private S3 file for a few minutes"
seoTitle: "S3 temporary URL in Vue"
excerpt: "temporaryUrl gives Vue a short link to a private object. Do not make the bucket public to fix an img tag."
description: "temporaryUrl gives Vue a short link to a private object. Do not make the bucket public to fix an img tag."
date: 2026-10-11T11:06:00Z
snippet: "Storage::disk('s3')->temporaryUrl($path, now()->addMinutes(5))"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---
People searching "Laravel S3 temporary URL Vue" set the object public because the img tag 403s. Keep the object private. Hand the page a URL that expires. The [upload guide](/laravel-vue-file-upload) is the public disk. This page is the private one.

```php
'cover' => Storage::disk('s3')->temporaryUrl(
    $post->cover_path,
    now()->addMinutes(5),
),
```

The Vue page uses it as `src`. Five minutes later the image request fails, which is the point. Generate the URL when you render, not when you upload, and do not store it in the database.

The disk needs the S3 key in `.env`, not in a `VITE_` variable. The browser never sees that key. It sees the signed URL.

Do not pass `cover_path` to Vue and build the S3 URL in the component. You would publish the bucket layout, and you still could not sign it without the secret. Do not cache the HTML of this page for an hour. The URL inside it dies first.
