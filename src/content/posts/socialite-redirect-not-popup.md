---
id: 80
title: "Redirect to Socialite instead of a popup"
seoTitle: "Socialite redirect, not a popup"
excerpt: "Socialite starts with a top-level redirect. A Vue popup loses the session cookie on the way back."
description: "Socialite starts with a top-level redirect. A Vue popup loses the session cookie on the way back."
date: 2026-10-11T10:27:00Z
snippet: "return Socialite::driver('github')->redirect();"
categories: [laravel, vuejs]
tags: [laravel, vuejs, socialite]
---
People searching "Socialite Vue popup" open GitHub in `window.open` and then the callback has no session. The [Socialite guide](/laravel-socialite-vue) is the two routes. This page is the link.

```php
public function redirect(): RedirectResponse
{
    return Socialite::driver('github')->redirect();
}
```

The Vue page uses a normal anchor. Inertia's `<Link>` is fine when it is a GET to your own app. It is not fine as a popup.

```vue
<a href="/auth/github/redirect">Continue with GitHub</a>
```

The callback hits Laravel, not a Vue route. Laravel writes the user and redirects home. The popup approach fails because the opener and the popup do not share the session the way people expect, and because GitHub's page should replace the window.

Do not put the provider secret in a `VITE_` variable so the popup can "start OAuth itself". The secret stays in `.env`. Do not add Vue Router for `/auth/github/callback`.
