---
id: 55
title: "Validate an Inertia form with a form request"
seoTitle: "Laravel form request and Inertia"
excerpt: "Move Inertia form rules into a form request and pass validated() to the model. authorize() still runs."
description: "Move Inertia form rules into a form request and pass validated() to the model. authorize() still runs."
date: 2026-10-11T10:02:00Z
snippet: "php artisan make:request StorePostRequest"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---
People searching "Laravel form request Inertia" want the rules off the controller. The Vue page does not change. It still posts `title` and reads `form.errors.title`, as in the [CRUD guide](/laravel-inertia-vue-crud).

```shell
php artisan make:request StorePostRequest
```

```php
public function authorize(): bool
{
    return $this->user() !== null;
}

public function rules(): array
{
    return [
        'title' => ['required', 'string', 'max:120'],
    ];
}
```

```php
public function store(StorePostRequest $request): RedirectResponse
{
    Post::create([
        'title' => $request->validated('title'),
        'user_id' => $request->user()->id,
    ]);

    return to_route('posts.index');
}
```

`$request->validated()` is the only array you should persist. A key that is not in `rules()` is dropped, which is the point.

Do not `return true` from `authorize()` on a request that updates someone else's post. That method is a gate. The owner check belongs in a [policy](/laravel-vue-policies), and `authorize()` can call it.
