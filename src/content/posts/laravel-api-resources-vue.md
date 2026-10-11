---
id: 28
title: "Laravel API resources for a Vue client"
excerpt: "A resource is the JSON shape a SPA or Nuxt reads. An Inertia page can keep passing the model. Axios sees the rows on response.data.data."
description: "Shape Laravel JSON for Vue with PostResource and a paginated collection, and read rows from response.data.data."
seoTitle: "Laravel API resources for Vue"
date: 2026-10-10T06:50:00Z
snippet: "php artisan make:resource PostResource"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---

An Inertia controller can return the `Post` model. The page receives props, not a JSON document you designed. A resource is for the other client: a Vue SPA or Nuxt that calls `/api/posts` and has to know the keys. That split is [Inertia, a SPA, or Nuxt](/laravel-vue-in-2026). The cookie on that request is [Sanctum](/laravel-sanctum-vue-spa). The Nuxt call is [Nuxt in front of the API](/nuxt-laravel-api).

## One post

```bash
php artisan make:resource PostResource
```

```php
// app/Http/Resources/PostResource.php
public function toArray(Request $request): array
{
    return [
        'id' => $this->id,
        'title' => $this->title,
        'excerpt' => $this->excerpt,
        'published_at' => $this->published_at,
    ];
}
```

Those four keys match the `Post` from the [setup guide](/application-setup). Add a key here when the client needs it. Do not return the whole model and hope Vue ignores `remember_token` style extras later. A resource is the allow-list.

## A page of posts

`PostResource::collection` on a paginator keeps Laravel's `links` and `meta` and wraps each row.

```php
// routes/api.php
Route::get('/posts', function () {
    $posts = Post::query()->latest('published_at')->paginate(10);

    return PostResource::collection($posts);
})->middleware('auth:sanctum');
```

The body is `{ data, links, meta }`. `data` is the ten posts. `links.next` and `meta.current_page` are the paginator. Vue code that treats the body as an array will render nothing.

```ts
const response = await axios.get("/api/posts");
const posts = response.data.data;
```

`response.data` is the HTTP body. `response.data.data` is the list. The double `data` is Laravel's resource envelope, then Axios's envelope. It is not a bug in either one.

`meta.last_page` is present because this example uses `paginate(10)`. [Pagination](/laravel-vue-pagination) is what changes if you switch to `simplePaginate` or `cursorPaginate`. The resource does not add a total those paginators refused to count.

## What not to put in the resource

Do not call `Storage::url` for a private file and hand the URL to any logged-in user. Public covers from the [upload guide](/laravel-vue-file-upload) can be a `/storage/...` path. Anything else stays behind a controller that checks the user.

Do not embed the entire author model. Pass `author: $this->user?->only(['id', 'name'])` when you add that relation. Until the post has a user, leave it out. The [policy guide](/laravel-vue-policies) is what adds `user_id`.

## Where this stops

Inertia pages should not fetch this endpoint to paint the list they already receive as props. Two sources for the same rows will drift. Use the resource when the client is actually an HTTP client.
