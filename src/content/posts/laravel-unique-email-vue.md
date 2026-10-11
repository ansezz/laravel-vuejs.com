---
id: 56
title: "Ignore the current user on a unique email"
seoTitle: "Unique email on a Vue profile"
excerpt: "Rule::unique()->ignore() lets the signed-in user keep their email. A plain unique rule fails on save."
description: "Rule::unique()->ignore() lets the signed-in user keep their email. A plain unique rule fails on save."
date: 2026-10-11T10:03:00Z
snippet: "Rule::unique('users', 'email')->ignore($id)"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---
People searching "Laravel unique email Vue" hit this on the profile form. The user saves without changing the email, and Laravel says the email is taken. It is taken by the same row.

The [Fortify guide](/laravel-fortify-vue) owns login. This page is the update rule.

```php
use Illuminate\Validation\Rule;

$validated = $request->validate([
    'email' => [
        'required',
        'email',
        'max:255',
        Rule::unique('users', 'email')->ignore($request->user()->id),
    ],
]);

$request->user()->update(['email' => $validated['email']]);
```

`ignore()` drops the current id from the uniqueness query. Pass the id, not the whole request.

On the Vue page, print `form.errors.email` under the email input. The message is the normal unique sentence. You do not need a second error format.

Do not ignore `$request->input('id')` from the form. A visitor can change that hidden field and skip the unique check against someone else.
