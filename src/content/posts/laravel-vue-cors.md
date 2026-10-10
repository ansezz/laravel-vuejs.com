---
id: 19
title: "Laravel and Vue CORS errors"
excerpt: "A same-origin Inertia app does not need CORS. A separate SPA does, and a 419 is a different failure from a blocked response."
description: "Fix Laravel and Vue CORS for a separate SPA: credentials, an explicit origin, the login path, and why a 419 is not CORS."
seoTitle: "Laravel Vue CORS errors"
date: 2026-10-10T05:20:00Z
snippet: "php artisan config:publish cors"
categories: [laravel, vuejs]
tags: [laravel, vuejs, sanctum]
---

Most "Laravel Vue CORS" threads are two different bugs with the same console paragraph. One is a cross-origin SPA. The other is a CSRF failure that only looks like CORS because the browser hides the status. This page separates them.

The Inertia starter kit is same-origin. You open the Laravel URL, and `@vite` loads the dev assets. The browser never makes a cross-origin call, so `config/cors.php` is not the fix. If that app is what you are building, the cookie and login steps are in [Sanctum for a Vue SPA](/laravel-sanctum-vue-spa) only when the front end is a second origin. The architecture choice is [Inertia, a SPA, or Nuxt](/laravel-vue-in-2026).

## When the browser sends a preflight

A separate Vue app on `http://localhost:5173` calling `http://localhost:8000` is a different origin. The port counts. A POST with `Content-Type: application/json`, or with `X-XSRF-TOKEN`, triggers an OPTIONS preflight before the real request. If that OPTIONS response has no `Access-Control-Allow-Origin` for the Vue origin, the browser reports a CORS error and your Vue `catch` never sees the body.

Publish the config and turn credentials on. Sanctum's cookie flow needs credentials. A wildcard origin cannot be combined with credentials. The browser rejects `Access-Control-Allow-Origin: *` on a credentialed request.

```bash
php artisan config:publish cors
```

```php
// config/cors.php
'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout'],
'allowed_methods' => ['*'],
'allowed_origins' => ['http://localhost:5173'],
'allowed_headers' => ['*'],
'supports_credentials' => true,
```

The default path list covers `api/*` and `sanctum/csrf-cookie`. It does not cover `POST /login`. Login lives on the web middleware group, which is the point of the Sanctum guide. If the preflight for `/login` never matches a path, the login request fails before Laravel runs the controller. Add each web path the SPA actually calls. Do not copy this list and then invent extra routes.

`allowed_origins` is the Vue origin, including the scheme and the port. `http://localhost:5173` and `http://127.0.0.1:5173` are not the same origin. Use the one the browser shows.

## The cookie settings that sit next to CORS

CORS only allows the browser to read the response. The session cookie still has to be sent. `SANCTUM_STATEFUL_DOMAINS` needs the SPA host and port, such as `localhost:5173`, and the Laravel host you open. `supports_credentials` on the CORS config is what lets the browser store and send that cookie.

Leave `SESSION_DOMAIN` empty on localhost. Set it to `.example.com` only when the SPA and the API are real subdomains. A leading dot on `localhost` drops the cookie. Axios still needs `withCredentials` and `withXSRFToken`. Those lines are in the Sanctum guide. This page does not repeat the login form.

## 419 is not CORS

Open the failing request in the network panel.

If the status is `(failed)` or the console says the preflight was blocked, it is CORS. Check the origin, the path list, and `supports_credentials`.

If the status is **419**, Laravel answered. The CSRF cookie was missing or the session domain was wrong. Fix that in the Sanctum guide. Changing `allowed_origins` will not turn a 419 into a 204.

A **401** from `auth:sanctum` means the request arrived and there is no session. That is also not CORS. Send the user back through `GET /sanctum/csrf-cookie` and `POST /login`.

## Where this stops

Nuxt on port 3000 is the same rule with a different origin. The call itself is [Nuxt in front of the API](/nuxt-laravel-api). The JSON shape is [API resources](/laravel-api-resources-vue).
