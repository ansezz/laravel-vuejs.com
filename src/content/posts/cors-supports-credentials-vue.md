---
id: 79
title: "Turn on CORS credentials for a separate Vue app"
seoTitle: "CORS supports_credentials"
excerpt: "A separate Vue origin needs supports_credentials and an explicit origin. A same-origin Inertia app needs neither."
description: "A separate Vue origin needs supports_credentials and an explicit origin. A same-origin Inertia app needs neither."
date: 2026-10-11T10:26:00Z
snippet: "'supports_credentials' => true"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---
People searching "Laravel CORS supports_credentials" flip the flag, leave the origin as `*`, and the browser still drops the cookie. Credentials and a wildcard origin are not allowed together. The [CORS guide](/laravel-vue-cors) is the full config. This page is that one pair of keys.

Same-origin Inertia does not use this file. If the Vue pages are served by Laravel, stop here.

For a SPA on another origin:

```php
'allowed_origins' => ['http://localhost:5173'],
'supports_credentials' => true,
```

The origin includes the scheme and the port. `http://localhost:5173` and `http://127.0.0.1:5173` do not match. The Vue client also has to send credentials. The Sanctum guide shows `withCredentials` and `withXSRFToken`.

Do not set `allowed_origins` to `['*']` in the same file as `supports_credentials => true`. Do not "fix" a 419 by editing this file. A 419 means Laravel answered and the CSRF cookie was missing. That diagnosis is in the [CORS guide](/laravel-vue-cors).
