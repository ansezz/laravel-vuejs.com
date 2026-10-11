---
id: 59
title: "Write a custom Laravel validation rule"
seoTitle: "Custom Laravel validation rule"
excerpt: "A custom rule is a class with validate(). The Vue page still prints form.errors for that field."
description: "A custom rule is a class with validate(). The Vue page still prints form.errors for that field."
date: 2026-10-11T10:06:00Z
snippet: "php artisan make:rule SlugRule"
categories: [laravel, vuejs]
tags: [laravel, vuejs, php]
---
People searching "Laravel custom validation rule" want one check that `required` and `max` cannot express. The Vue page does not learn a new error shape. It still reads `form.errors.slug` from the [CRUD guide](/laravel-inertia-vue-crud).

```shell
php artisan make:rule SlugRule
```

```php
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SlugRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $value) !== 1) {
            $fail('The slug may contain lowercase letters, numbers, and hyphens.');
        }
    }
}
```

```php
$validated = $request->validate([
    'slug' => ['required', 'string', 'max:80', new SlugRule],
]);
```

Call `$fail()` with a sentence. Do not throw. Throwing skips the error bag and the Vue page gets a 500 instead of `form.errors.slug`.

Do not reach into the database from this class for a unique check. `Rule::unique()` already does that, and a query inside `validate()` is easy to forget when the field is optional.
