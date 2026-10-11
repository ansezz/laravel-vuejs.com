---
id: 128
title: "Queue a broadcast instead of blocking the save"
seoTitle: "ShouldBroadcast needs a worker"
excerpt: "ShouldBroadcast queues the event. ShouldBroadcastNow runs it inside the request. The Vue listener is the Reverb guide."
description: "ShouldBroadcast queues the event. ShouldBroadcastNow runs it inside the request. The Vue listener is the Reverb guide."
date: 2026-10-11T11:15:00Z
snippet: "class PostPublished implements ShouldBroadcast"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---
People searching "ShouldBroadcast Vue" implement `ShouldBroadcastNow` and then every save waits on the socket. `ShouldBroadcast` implements the queue. The event class, the public channel, and `useEchoPublic` are already in the [Reverb guide](/laravel-reverb-vue). This page is the interface and the worker.

```php
class PostPublished implements ShouldBroadcast
{
    // broadcastOn stays the public Channel from the Reverb guide
}
```

`PostPublished::dispatch($post)` after the row exists. Nothing reaches the browser until a worker is running. Local:

```shell
php artisan queue:listen
```

If the title never appears, check the worker before you rewrite the Vue listener. `ShouldBroadcastNow` is the tool when the event must go out before the response, and you accept the cost. A post save is not that case.

Do not listen with `useEcho` on a public channel. The Reverb guide shows why that hook asks for a private channel and then misses this event. Do not put the provider key, or the Reverb secret, in the event payload.
