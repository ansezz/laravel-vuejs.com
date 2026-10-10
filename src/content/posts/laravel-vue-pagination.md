---
id: 18
title: "Laravel and Vue pagination"
excerpt: "paginate, simplePaginate, and cursorPaginate return different JSON. The Vue page can only render the links that object actually has."
description: "Choose paginate, simplePaginate, or cursorPaginate for a Laravel and Vue list, and render only the links that object includes."
seoTitle: "Laravel Vue pagination"
date: 2026-10-10T05:10:00Z
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---

The [CRUD guide](/laravel-inertia-vue-crud) loads posts with `paginate(10)`. That is the right call when the list is small enough to count. This page is the other two paginators, and the Vue markup that breaks when you swap them without reading the payload.

If you are still choosing Inertia, a separate SPA, or Nuxt, start with [the stack guide](/laravel-vue-in-2026). Sorting the same list is the [table guide](/laravel-vue-datatable). Do not call `Post::all()` and paginate in the browser.

## What each method returns

`paginate(10)` runs a count query. The JSON includes `total`, `last_page`, `current_page`, `prev_page_url`, and `next_page_url`. The CRUD page can say "Page 2 of 6" because those keys exist.

`simplePaginate(10)` skips the count. You get `current_page` and the previous and next URLs. There is no `total` and no `last_page`. Use it when the table is large and the footer only needs Previous and Next.

`cursorPaginate(10)` also skips the count. Instead of `?page=2` it uses a `cursor` string and returns `next_page_url` and `prev_page_url`. There is no `last_page`. Use it when you order by a unique column, usually `id`, and people mostly move forward. Two rows with the same `published_at` can make an offset cursor skip or repeat a row. Order by `id` unless you have a reason not to.

```php
// app/Http/Controllers/PostController.php
$posts = Post::query()
    ->latest('id')
    ->cursorPaginate(10);
```

Swap `cursorPaginate` for `simplePaginate` when you want page numbers without a total. Keep `paginate` from the CRUD guide when the count is cheap and the UI shows it.

## The Vue footer

Read `posts.data` for the rows, the same as the CRUD page. Stop reading `last_page` unless you called `paginate()`.

```vue
<!-- resources/js/pages/posts/Index.vue -->
<nav class="flex gap-4">
  <Link v-if="posts.prev_page_url" :href="posts.prev_page_url">Previous</Link>
  <Link v-if="posts.next_page_url" :href="posts.next_page_url">Next</Link>
</nav>
```

`prev_page_url` and `next_page_url` are `null` on the ends. The `v-if` is the whole empty state. A cursor page and a simple page can share this footer. A counted page can add `Page {{ posts.current_page }} of {{ posts.last_page }}` beside it.

`withQueryString()` still matters once the list has a search box. Without it, Next drops `?search=` and the second page is the unfiltered table.

```php
Post::query()
    ->when($search !== '', fn ($query) => $query->where('title', 'like', "%{$search}%"))
    ->latest('id')
    ->simplePaginate(10)
    ->withQueryString();
```

## A test that locks the shape

```php
it('does not claim a last page it did not count', function () {
    Post::factory()->count(3)->create();

    $this->get('/posts')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('posts.data', 3)
            ->missing('posts.last_page')
            ->missing('posts.total')
        );
});
```

Point that test at whichever method you chose. `missing('posts.total')` fails if someone "helpfully" switches the controller back to `paginate()` while the Vue page was written for a simple paginator.

## Where this stops

Loading the next page by appending rows, instead of replacing them, is a partial reload. That is [partial reloads](/inertia-partial-reloads). The form, the search box, and `paginate(10)` stay in the [CRUD guide](/laravel-inertia-vue-crud).
