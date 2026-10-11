---
id: 107
title: "Upsert rows without a per-row form"
seoTitle: "Upsert instead of a loop"
excerpt: "upsert writes a batch by a unique key. It skips model events, so a normal Vue form should still use create or update."
description: "upsert writes a batch by a unique key. It skips model events, so a normal Vue form should still use create or update."
date: 2026-10-11T10:54:00Z
snippet: "Post::upsert($rows, uniqueBy: ['slug'], update: ['title'])"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---
People searching "Laravel upsert" use it for the post form so they can skip the id. A form that creates or edits one post should use `create` or `update` from the [CRUD guide](/laravel-inertia-vue-crud). `upsert` is a batch import.

```php
Post::upsert([
    ['slug' => 'hello', 'title' => 'Hello', 'user_id' => $request->user()->id],
], uniqueBy: ['slug'], update: ['title']);
```

`uniqueBy` is the unique index. `update` is the column list that changes when the slug already exists. Timestamps are not filled unless you pass them in the row. Observers and model events do not run.

Validate each row before this call. `upsert` is not a validator.

Do not point an Inertia form at upsert for one title. You lose the policy events and the id comes back differently. Do not upsert from Vue by posting the whole table on every keystroke.
