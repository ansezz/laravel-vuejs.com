---
id: 98
title: "Search one column from a Vue field"
seoTitle: "Search a column from Vue"
excerpt: "when() adds a like query only when the search box is not empty. Bind the word. Do not paste it into SQL."
description: "when() adds a like query only when the search box is not empty. Bind the word. Do not paste it into SQL."
date: 2026-10-11T10:45:00Z
snippet: "->when($search !== '', fn ($q) => $q->where('title', 'like', '%'.$search.'%'))"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---
People searching "Laravel Vue search" interpolate the query string into SQL. The [CRUD guide](/laravel-inertia-vue-crud) already has the filter form. This page is the query.

```php
$search = $request->string('search')->trim()->toString();

$posts = Post::query()
    ->when($search !== '', function ($query) use ($search) {
        $query->where('title', 'like', '%'.$search.'%');
    })
    ->orderBy('id')
    ->paginate(12)
    ->withQueryString();
```

`where()` binds the value. The percent signs are wildcards around a bound string, not a second query language. `withQueryString()` keeps `?search=` on the [pagination](/laravel-vue-pagination) links.

The Vue field is named `search`. Empty string skips the clause, so the first visit is the full list.

Do not use `whereRaw` with the request pasted in. Do not `LIKE` against every column "to be helpful" unless you indexed that search on purpose. A leading wildcard does not use a normal index. That is acceptable on a small table and a problem on a large one.
