---
id: 131
title: "Trust proxies so HTTPS sticks"
seoTitle: "Trust proxies for HTTPS"
excerpt: "Behind one load balancer, trustProxies(at: '*') makes Laravel see HTTPS. Do not do that on a machine exposed directly."
description: "Behind one load balancer, trustProxies(at: '*') makes Laravel see HTTPS. Do not do that on a machine exposed directly."
date: 2026-10-11T11:18:00Z
snippet: "$middleware->trustProxies(at: '*')"
categories: [laravel, vuejs]
tags: [laravel, vuejs, setup]
---
People searching "Laravel trust proxies HTTPS" get an infinite redirect or a session cookie that will not stick. The app thinks the request is HTTP because the proxy terminated TLS. Generated URLs then use `http`, and `SESSION_SECURE_COOKIE` refuses to send the cookie. The [deploy guide](/deploy-laravel-vue) is the host. This page is the middleware.

On Laravel 11 and newer, in `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->trustProxies(at: '*');
})
```

`at: '*'` trusts every proxy. That is right when the app is only reachable through the load balancer. It is wrong when the process is on a public port, because a client can send `X-Forwarded-For` and `X-Forwarded-Proto` itself.

`APP_URL` should still be the `https` URL users type. Trusting proxies does not replace it.

Do not set `URL::forceScheme('https')` and also forget the proxy. You can end up with https URLs and a request object that still says the scheme is http. Fix the proxy headers first.
