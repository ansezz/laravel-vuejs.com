---
id: 117
title: "Download a CSV from a Vue button"
seoTitle: "Download a CSV from Laravel"
excerpt: "streamDownload writes the CSV. The button is an anchor, not an Inertia Link. cursor() keeps the memory flat."
description: "streamDownload writes the CSV. The button is an anchor, not an Inertia Link. cursor() keeps the memory flat."
date: 2026-10-11T11:04:00Z
snippet: "return response()->streamDownload(...);"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---
People searching "Laravel CSV export Vue" load `Post::all()` and return a string. Stream it. The [pagination guide](/laravel-vue-pagination) is why a list page does not load every row. An export should not either.

```php
public function export(): StreamedResponse
{
    $this->authorize('viewAny', Post::class);

    return response()->streamDownload(function () {
        $out = fopen('php://output', 'w');
        fputcsv($out, ['id', 'title']);

        foreach (Post::query()->orderBy('id')->cursor() as $post) {
            fputcsv($out, [$post->id, $post->title]);
        }

        fclose($out);
    }, 'posts.csv');
}
```

```vue
<a href="/posts/export">Download CSV</a>
```

A `<Link>` would try to mount the file as a page. A normal anchor lets the browser download it.

Do not build the CSV in a computed property from the current page of results. That exports twelve rows and calls it the database. Do not skip `authorize`. An export is the whole table.
