---
id: 106
title: "Render simplePaginate without a last page"
seoTitle: "simplePaginate has no last page"
excerpt: "simplePaginate omits the total and last_page. The Vue footer uses previous and next only."
description: "simplePaginate omits the total and last_page. The Vue footer uses previous and next only."
date: 2026-10-11T10:53:00Z
snippet: "->simplePaginate(12)"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---
People searching "Laravel simplePaginate Vue" copy a footer that prints `last_page` and then the control is blank. `simplePaginate` does not count the table. The [pagination guide](/laravel-vue-pagination) compares the three objects. This page is the footer that matches this one.

```php
$posts = Post::query()->orderBy('id')->simplePaginate(12)->withQueryString();
```

You get `data`, `current_page`, `prev_page_url`, and `next_page_url`. You do not get `total` or `last_page`.

```vue
<Link v-if="posts.prev_page_url" :href="posts.prev_page_url">Previous</Link>
<Link v-if="posts.next_page_url" :href="posts.next_page_url">Next</Link>
```

Do not compute "page 2 of undefined" in the template. If the product needs the count, use `paginate` and pay for the count. Do not run a second `count()` query in the controller "just for the label" and think you kept simple pagination.
