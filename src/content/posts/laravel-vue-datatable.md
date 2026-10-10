---
id: 37
title: "A sortable Laravel and Vue table"
excerpt: "The sort column is an allow-list. The direction is asc or desc. The database orders the rows, and the existing paginator links keep the query string."
description: "Sort a Laravel and Vue table on the server with an allow-listed column and a direction that is only asc or desc."
seoTitle: "Sort a Laravel Vue table"
date: 2026-10-10T08:20:00Z
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---

A datatable plugin in the browser sorts the ten rows it was given. Page two is still in Laravel's default order, so the table lies. Sort in the query. Reuse the pagination you already have. This page does not install a jQuery grid.

The list, the search box, and `paginate(10)` are the [CRUD guide](/laravel-inertia-vue-crud). Previous and Next without a total are [pagination](/laravel-vue-pagination). The app is [Inertia, a SPA, or Nuxt](/laravel-vue-in-2026).

## The allow-list

`orderBy($request->input('sort'))` is a column injection. The visitor picks the column from a list you wrote down. The direction is `asc` or it is `desc`. Anything else becomes `desc`.

```php
public function index(Request $request): Response
{
    $sort = $request->string('sort')->toString();
    $column = in_array($sort, ['title', 'published_at'], true) ? $sort : 'published_at';
    $direction = $request->string('dir')->toString() === 'asc' ? 'asc' : 'desc';
    $search = $request->string('search')->trim()->toString();

    return Inertia::render('posts/Index', [
        'filters' => [
            'search' => $search,
            'sort' => $column,
            'dir' => $direction,
        ],
        'posts' => Post::query()
            ->when($search !== '', fn ($query) => $query->where('title', 'like', "%{$search}%"))
            ->orderBy($column, $direction)
            ->paginate(10)
            ->withQueryString(),
    ]);
}
```

`withQueryString()` keeps `sort`, `dir`, and `search` on the page links. Without it, Next returns to the default order and the header looks sorted while the rows are not.

`published_at` and `title` match the posts table from the setup guide. Add a column to the `in_array` list only after the migration exists. Do not pass `id` through just because the URL contains it, unless the table should sort by id.

## The header

The link toggles direction when it is already the active column. It sends the user back to page 1 by leaving `page` off the URL. A sort change that stays on page 5 shows an empty page often enough to look broken.

```vue
<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

const props = defineProps<{
  filters: { search: string; sort: string; dir: "asc" | "desc" };
}>();

function sortHref(column: string) {
  const dir =
    props.filters.sort === column && props.filters.dir === "asc"
      ? "desc"
      : "asc";
  const params = new URLSearchParams({
    sort: column,
    dir,
  });

  if (props.filters.search) {
    params.set("search", props.filters.search);
  }

  return `/posts?${params.toString()}`;
}
</script>

<template>
  <table>
    <thead>
      <tr>
        <th>
          <Link :href="sortHref('title')" preserve-scroll>Title</Link>
        </th>
        <th>
          <Link :href="sortHref('published_at')" preserve-scroll
            >Published</Link
          >
        </th>
      </tr>
    </thead>
  </table>
</template>
```

The body is still `v-for="post in posts.data"`. The header is the only new markup. Mark the active column with the `filters.sort` string if you want an arrow. The server state is the arrow. Do not keep a second sort ref in the component.

## A test

```php
it('ignores a sort column that is not allowed', function () {
    Post::factory()->create(['title' => 'A']);
    Post::factory()->create(['title' => 'B']);

    $this->get('/posts?sort=password&dir=asc')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('filters.sort', 'published_at')
            ->where('filters.dir', 'desc')
        );
});
```

`password` is not on the post, and it must not reach `orderBy`. The filter prop is the easy assertion. A query exception is the failure mode if the allow-list is missing and the column does not exist.

## Where this stops

Column show and hide, CSV export, and editing a cell in place are different features. They do not belong on this query. Live validation of an edit form is [Precognition](/laravel-precognition-vue). Who may open the row is a [policy](/laravel-vue-policies).
