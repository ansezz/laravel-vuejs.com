---
id: 25
title: "Live validation with Laravel Precognition and Vue"
excerpt: "Inertia's Form component already validates one field as the user leaves it. A precognitive request runs the rules and does not run the controller."
description: "Add live validation to an Inertia Vue form with the built-in validate() slot, and skip the old Precognition npm package."
seoTitle: "Live validation with Precognition"
date: 2026-10-10T06:20:00Z
snippet: "php artisan make:request StorePostRequest"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---

The [CRUD form](/laravel-inertia-vue-crud) shows errors after submit. Precognition shows them when the field changes, using the same Laravel rules. Inertia 3's `<Form>` component already does this. Older tutorials install `laravel-precognition-vue-inertia` and call `useForm` from that package. You do not need that package on a current Inertia app. Remove it if a previous tutorial added it.

This page does not cover optimistic UI. The form still waits for the server. The stack choice is [Inertia, a SPA, or Nuxt](/laravel-vue-in-2026).

## The server still has to opt in

A precognitive request runs the route middleware and the validation. It does not run the controller method. Typing in the title field must not insert a post. Laravel only treats the request that way when `HandlePrecognitiveRequests` is on the route.

Put the rules in a form request so the precognitive call and the real submit share them.

```bash
php artisan make:request StorePostRequest
```

```php
// app/Http/Requests/StorePostRequest.php
public function rules(): array
{
    return [
        'title' => ['required', 'string', 'max:255'],
        'excerpt' => ['required', 'string'],
    ];
}
```

```php
use App\Http\Requests\StorePostRequest;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(HandlePrecognitiveRequests::class, only: ['store', 'update']),
        ];
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        Post::create([
            'title' => $request->string('title')->toString(),
            'excerpt' => $request->string('excerpt')->toString(),
            'slug' => str($request->string('title')->toString())->slug(),
            'published_at' => now(),
        ]);

        return to_route('posts.index');
    }
}
```

`store` only runs on the real submit. The live check stops at `StorePostRequest`.

## The Vue slot

`validate('title')` sends the precognitive request. `invalid('title')` is true only after a response says the field failed. `validating` is true while that request is in flight. A field that still has its initial value does not send a request.

```vue
<Form
  action="/posts"
  method="post"
  #default="{ errors, invalid, validate, validating }"
  class="space-y-4"
>
  <div>
    <label for="title">Title</label>
    <input id="title" name="title" @change="validate('title')" class="w-full border px-3 py-2" />
    <p v-if="invalid('title')">{{ errors.title }}</p>
  </div>

  <div>
    <label for="excerpt">Excerpt</label>
    <textarea id="excerpt" name="excerpt" @change="validate('excerpt')" class="w-full border px-3 py-2" />
    <p v-if="invalid('excerpt')">{{ errors.excerpt }}</p>
  </div>

  <p v-if="validating">Checking...</p>
  <button class="border px-4 py-2">Save</button>
</Form>
```

Import `Form` from `@inertiajs/vue3`, the same component the CRUD guide uses. Submit still posts the form. You do not add a second `@submit` handler.

## Files and expensive rules

Precognition leaves files out of the live request unless you set `validate-files` on `<Form>`, or call `validateFiles()` on `useForm`. With the default, a rule that says `cover` is required fails every live check, because the file is not in that request. Skip the required rule while the request is precognitive, and keep the image rules for the real submit. The field itself is the [upload guide](/laravel-vue-file-upload).

```php
'cover' => [
    ...$this->isPrecognitive() ? [] : ['required'],
    'image',
    'max:2048',
],
```

`max:2048` is kilobytes. The same split works for a password check you only want on submit, such as an uncompromised-password lookup. Read `$this->isPrecognitive()` inside the form request and choose the cheaper rule for the live call.

## Where this stops

The errors after a normal submit are still the CRUD form. Who is allowed to submit is a [permission](/laravel-vue-permissions) or a [policy](/laravel-vue-policies). Precognition does not replace either one.
