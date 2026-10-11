---
id: 100
title: "Eager load a relation for a Vue list"
seoTitle: "Eager load for a Vue list"
excerpt: "with('author') loads the relation once. Reading it inside a loop is one query per row."
description: "with('author') loads the relation once. Reading it inside a loop is one query per row."
date: 2026-10-11T10:47:00Z
snippet: "Post::query()->with('author')->paginate(12)"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---
People searching "Laravel N+1 Vue" open a list of posts and the debug bar shows one query per author. Send the relation with the page. The [API resource guide](/laravel-api-resources-vue) is the JSON shape. An Inertia list can pass the columns directly.

```php
$posts = Post::query()
    ->with('author:id,name')
    ->orderBy('id')
    ->paginate(12);
```

`author:id,name` limits the columns. The foreign key has to be in the select or the relation cannot match, so leave `id` on the user.

```vue
<li v-for="post in posts.data" :key="post.id">
  {{ post.title }} <span v-if="post.author">{{ post.author.name }}</span>
</li>
```

Do not call `$post->author` inside a `map()` that builds the prop after you forgot `with()`. That is the N+1. Do not eager load every relation on the model "so the page has it". The HTML includes what you load.
