---
id: 69
title: "Fix a 419 after you deploy"
seoTitle: "419 after a Laravel deploy"
excerpt: "A 419 after deploy is a CSRF cookie that the browser did not send. The app key, the domain, and HTTPS are the usual causes."
description: "A 419 after deploy is a CSRF cookie that the browser did not send. The app key, the domain, and HTTPS are the usual causes."
date: 2026-10-11T10:16:00Z
snippet: "SESSION_SECURE_COOKIE=true"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---
People searching "Laravel 419 after deploy" can log in on their laptop and get a 419 on the first POST in production. Laravel answered. The session cookie was missing, so the CSRF token did not match. The [Sanctum guide](/laravel-sanctum-vue-spa) separates this from a 401. The [CORS guide](/laravel-vue-cors) separates it from a blocked preflight.

Check these three before you touch Vue:

```ini
APP_URL=https://example.com
SESSION_SECURE_COOKIE=true
SESSION_DOMAIN=
```

Leave `SESSION_DOMAIN` empty when the Vue page and Laravel are the same host. Set it to `.example.com` only when the browser is on a real subdomain. A new `APP_KEY` on the server logs everyone out. The next POST is a 419 until they load a fresh page and get a new token. Do not copy the laptop key into production to "keep the session". Generate one key per environment and leave it stable.

Same-origin Inertia does not need CORS. If you "fixed" a 419 by setting `allowed_origins` to `*`, put that back. A wildcard origin cannot be used with credentials.

Do not disable `VerifyCsrfToken` for the whole `web` group. The token is the check.
