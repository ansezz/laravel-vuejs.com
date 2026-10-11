---
id: 121
title: "Chunk a large export in a job"
seoTitle: "Chunk a large export"
excerpt: "chunkById walks a table in a job. Do not chunk() an update, and do not do this work inside the HTTP request."
description: "chunkById walks a table in a job. Do not chunk() an update, and do not do this work inside the HTTP request."
date: 2026-10-11T11:08:00Z
snippet: "Post::query()->chunkById(200, function ($posts) { ... })"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---
People searching "Laravel chunk export" call `chunk()` inside a controller and the request times out. A download the user is waiting on should stream, which is the CSV page's job. A file you email later belongs in a queued job. The [queue guide](/laravel-vue-queued-job) is how that job gets on the page.

```php
Post::query()->orderBy('id')->chunkById(200, function ($posts) {
    foreach ($posts as $post) {
        // append a row to the export, or dispatch a smaller job
    }
});
```

`chunkById` remembers the last id. `chunk()` uses offset. If you delete or update rows inside `chunk()`, pages get skipped. That is the bug.

Do not `Post::all()` and then `collect()->chunk()` to feel safer. You already loaded the table. Do not start this from a Vue `setInterval`. The button dispatches one job.
