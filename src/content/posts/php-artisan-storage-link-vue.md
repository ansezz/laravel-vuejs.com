---
id: 118
title: "Fix an image 404 with storage:link"
seoTitle: "storage:link and an image 404"
excerpt: "storage:link maps public/storage to storage/app/public. Laravel Cloud does not keep that symlink."
description: "storage:link maps public/storage to storage/app/public. Laravel Cloud does not keep that symlink."
date: 2026-10-11T11:05:00Z
snippet: "php artisan storage:link"
categories: [laravel, vuejs]
tags: [laravel, vuejs, setup]
---
People searching "Laravel storage link Vue" save a file and the `<img>` is 404. The public disk writes `storage/app/public`. The browser asks for `/storage/...`. The link connects them. The [upload guide](/laravel-vue-file-upload) stores the file. The [deploy guide](/deploy-laravel-vue) says to skip this command on Laravel Cloud.

```shell
php artisan storage:link
```

That creates `public/storage`. Run it once per machine that serves the public disk. The Vue page prints a root-relative URL:

```vue
<img v-if="post.cover_url" :src="post.cover_url" alt="" />
```

`cover_url` is something like `/storage/covers/a.jpg`, from `Storage::url($path)` when the disk is `public`.

Do not commit `public/storage` as a real directory of uploads. The symlink is local. Do not run this on Laravel Cloud and expect the next deploy to keep it. Cloud's disk resets. User uploads there belong in the bucket the deploy guide points at.
