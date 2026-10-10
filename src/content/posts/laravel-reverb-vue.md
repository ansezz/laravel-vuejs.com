---
id: 13
title: "Listen for Laravel events in Vue with Reverb"
excerpt: "Install Reverb, broadcast a public event through the queue, and subscribe from a Vue page with useEcho."
description: "Laravel Reverb and Vue: install broadcasting, fire a ShouldBroadcast event, and listen with the useEcho hook from Echo Vue."
seoTitle: "Laravel Reverb and Vue Echo"
date: 2026-10-10T04:20:00Z
snippet: "php artisan install:broadcasting --reverb"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---

Polling the [posts list](/laravel-inertia-vue-crud) every few seconds works until it does not. Reverb is Laravel's WebSocket server. Echo is the client. A Vue page can subscribe with `useEcho` from `@laravel/echo-vue` and update when a PHP event fires.

The official write-up is the [broadcasting docs](https://laravel.com/docs/13.x/broadcasting). This page is the short path for a Vue starter kit.

## Install

```bash
php artisan install:broadcasting --reverb
```

That installs Reverb, the Echo packages, and the `VITE_REVERB_*` keys. Restart Vite after it changes `.env`, or the browser will still see empty keys.

Broadcasts are queued. The [setup guide](/application-setup) starts a queue worker with `composer run dev`. If you are not using that script, run `php artisan queue:work` yourself. Then start the socket server:

```bash
php artisan reverb:start
```

Leave both running. An event with no worker sits in the `jobs` table. An event with no Reverb process never reaches the browser.

## The event

```bash
php artisan make:event PostPublished
```

```php
namespace App\Events;

use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostPublished implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Post $post) {}

    public function broadcastOn(): Channel
    {
        return new Channel('posts');
    }
}
```

`ShouldBroadcast` is the line that sends it. A public `Channel` needs no auth. Use `PrivateChannel` when only a logged-in user should hear it, and authorize that name in `routes/channels.php`.

Dispatch it after the row exists:

```php
PostPublished::dispatch($post);
```

Put that in `store` after `Post::create()`. The queued job serializes the model. Keep the payload small. Echo will hand the public properties to the browser, so hide anything you would not print on the page.

## The Vue page

```vue
<script setup lang="ts">
import { ref } from "vue";
import { useEcho } from "@laravel/echo-vue";

const titles = ref<string[]>([]);

useEcho("posts", "PostPublished", (event: { post: { title: string } }) => {
  titles.value.unshift(event.post.title);
});
</script>

<template>
  <ul>
    <li v-for="title in titles" :key="title">{{ title }}</li>
  </ul>
</template>
```

`useEcho` subscribes when the component is set up and leaves the channel when the component goes away. The event name matches the class name, `PostPublished`, unless you set `broadcastAs()`.

Create a post from another window. The title should appear without a reload. If it does not, check the queue worker, then Reverb, then the browser console for a failed WebSocket. A missing `VITE_REVERB_APP_KEY` fails quietly until you look.

## Private channels and a separate SPA

An Inertia app on the same origin can use the defaults `install:broadcasting` wrote. A Vue SPA on another port is the Sanctum case. Private channels then authorize through `/api/broadcasting/auth`, and Echo needs a custom authorizer that uses the credentialed Axios instance. The setup is in the [Sanctum broadcasting section](https://laravel.com/docs/13.x/sanctum#authorizing-private-broadcast-channels) and depends on the cookie login from [the Sanctum guide](/laravel-sanctum-vue-spa).

Do not point that authorizer at a bearer token you stored for your own SPA. Fix the cookie first.

## Production

Reverb is a process, like the queue worker. Laravel Cloud can run it as a managed WebSocket cluster and injects the `REVERB_*` variables. On a VPS you run `php artisan reverb:start` under a supervisor and proxy the socket port. The Vue bundle only needs the `VITE_REVERB_*` values from the production env at build time. The [deploy guide](/deploy-laravel-vue) covers the asset build. It does not start Reverb for you.
