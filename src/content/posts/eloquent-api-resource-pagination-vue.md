---
id: 105
title: "Paginate an API resource for Vue"
seoTitle: "API resource pagination"
excerpt: "A resource collection of a paginator already includes links and meta. Do not paginate those rows again in Vue."
description: "A resource collection of a paginator already includes links and meta. Do not paginate those rows again in Vue."
date: 2026-10-11T10:52:00Z
snippet: "PostResource::collection($posts)"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---
People searching "Laravel API resource pagination Vue" wrap a paginator and then read `data.data` or rebuild the links. When the collection is a paginator, Laravel keeps `data`, `links`, and `meta`. The [API resource guide](/laravel-api-resources-vue) shows the shape. The [pagination guide](/laravel-vue-pagination) is what changes if you switch paginator.

```php
$posts = Post::query()->orderBy('id')->paginate(12);

return PostResource::collection($posts);
```

`meta.last_page` is present because this is `paginate`. A Vue page that only needs next and previous should not assume `last_page` after you switch to `simplePaginate`.

Do not `PostResource::collection($posts->items())`. You dropped the links. Do not paginate in Vue with the full collection loaded above the resource. The page query is the paginator.
