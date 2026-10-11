---
id: 73
title: "Confirm a password before a sensitive Vue action"
seoTitle: "Fortify confirm password"
excerpt: "password.confirm sends the user to Fortify's confirm screen. The Vue form posts the current password once."
description: "password.confirm sends the user to Fortify's confirm screen. The Vue form posts the current password once."
date: 2026-10-11T10:20:00Z
snippet: "->middleware([\"auth\", \"password.confirm\"])"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---
People searching "Fortify confirm password Vue" ask for the password on every request from the Vue page. Laravel already has a timeout for this. Put `password.confirm` on the route that changes the email or deletes the account. The [Fortify guide](/laravel-fortify-vue) covers the login POST these screens sit behind.

```php
Route::delete('/account', [AccountController::class, 'destroy'])
    ->middleware(['auth', 'password.confirm']);
```

When the confirmation has expired, Laravel redirects to the confirm screen. The kit page is `resources/js/pages/auth/ConfirmPassword.vue`. It posts the current password:

```ts
form.post("/user/confirm-password");
```

One field, named `password`. This is the current password, not a new one, and it does not use `password_confirmation`.

Do not store "the user confirmed" in `localStorage`. The timeout lives in the session. A stolen page script should not be able to refresh it. Do not skip the middleware because the Vue button already asked. The button is not the check.
