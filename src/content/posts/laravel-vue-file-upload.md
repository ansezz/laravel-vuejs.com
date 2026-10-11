---
id: 12
title: "Upload files from Vue to Laravel with Inertia"
excerpt: "Send an image with the Inertia Form component, validate it, store it on the public disk, and show upload progress."
description: "Laravel and Vue file uploads with Inertia 3: a file input, image rules, the public disk, and progress while the request runs."
seoTitle: "Laravel Vue file upload"
date: 2026-10-10T04:10:00Z
snippet: "php artisan storage:link"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---

A file input in an Inertia form is still a normal multipart request. Laravel validates it, stores it, and redirects back. You do not need a second upload library for a cover image on the [post form](/laravel-inertia-vue-crud).

## The column and the link

```bash
php artisan make:migration add_cover_path_to_posts_table --table=posts
php artisan storage:link
```

```php
public function up(): void
{
    Schema::table('posts', function (Blueprint $table) {
        $table->string('cover_path')->nullable();
    });
}
```

Add `cover_path` to the model's `$fillable` array. `storage:link` points `public/storage` at `storage/app/public`, which is where the `public` disk writes. Without the link, the file saves and the `<img>` 404s.

## Validate and store

```php
public function update(Request $request, Post $post): RedirectResponse
{
    $data = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'excerpt' => ['required', 'string'],
        'cover' => ['nullable', 'image', 'max:2048'],
    ]);

    if ($request->hasFile('cover')) {
        $data['cover_path'] = $request->file('cover')->store('covers', 'public');
        unset($data['cover']);
    }

    $post->update($data);

    return to_route('posts.edit', $post);
}
```

`max:2048` is kilobytes, about 2 MB. `image` checks the content, not only the extension. `store()` returns a path like `covers/abc.jpg`. Save that path. Do not put the file bytes in the database.

Unset `cover` before `update()` so Eloquent does not try to write the uploaded file object into a string column.

Pass the current path to the page:

```php
'post' => $post->only(['id', 'title', 'excerpt', 'cover_path']),
```

## The Vue form

The `<Form>` component from `@inertiajs/vue3` sends a file field as `multipart/form-data`. PHP does not fill that file on a real `PUT`, `PATCH`, or `DELETE`. Post the form and send `_method` of `put`, which is the spoof Laravel documents. Keep the `name` attribute. That is the key Laravel validates.

```vue
<script setup lang="ts">
import { Form } from "@inertiajs/vue3";

defineProps<{
  post: {
    id: number;
    title: string;
    excerpt: string;
    cover_path: string | null;
  };
}>();
</script>

<template>
  <Form
    :action="`/posts/${post.id}`"
    method="post"
    #default="{ errors, processing, progress }"
    class="space-y-4"
  >
    <input type="hidden" name="_method" value="put" />
    <input name="title" :defaultValue="post.title" />
    <p v-if="errors.title">{{ errors.title }}</p>

    <textarea name="excerpt" :defaultValue="post.excerpt" />
    <p v-if="errors.excerpt">{{ errors.excerpt }}</p>

    <img
      v-if="post.cover_path"
      :src="`/storage/${post.cover_path}`"
      alt=""
      class="max-h-40"
    />

    <input type="file" name="cover" accept="image/*" />
    <p v-if="errors.cover">{{ errors.cover }}</p>
    <progress v-if="progress" :value="progress.percentage" max="100" />

    <button :disabled="processing">Save</button>
  </Form>
</template>
```

`progress` is set while the body is uploading. `processing` stays true until Laravel responds. Disable the button for the whole request, not only while the bar moves.

A validation error for `cover` ("The cover field must be an image") comes back on the same page, the same way `errors.title` does in the CRUD guide.

## Replace and delete

`store()` does not remove the previous file. If the post already has a cover, delete it before saving the new one:

```php
use Illuminate\Support\Facades\Storage;

if ($request->hasFile('cover')) {
    if ($post->cover_path) {
        Storage::disk('public')->delete($post->cover_path);
    }

    $data['cover_path'] = $request->file('cover')->store('covers', 'public');
}
```

Do this in the same request as the database update. A queue is the wrong place for "the user just picked a new avatar" unless the file is large enough that the HTTP request times out.

## Production

The `public` disk is fine for images you are happy to serve from the app server. For anything private, use a non-public disk and a temporary URL. For more than one server, the local disk is the wrong place: the next request may hit a machine that does not have the file. Point the disk at S3-compatible storage then. The Vue form does not change.

`php artisan storage:link` is once per machine when that machine serves the `public` disk. Laravel Cloud resets the app disk on each deploy, so do not rely on the symlink there. The [deploy guide](/deploy-laravel-vue) is the rest of that list. It will not create the `covers` directory for you. `store()` does that on first upload.
