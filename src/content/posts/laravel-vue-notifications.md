---
id: 31
title: "Laravel database notifications in Vue"
excerpt: "A notification written to the database is a prop on the next Inertia visit. Live delivery is the Reverb guide, not a second copy of Echo."
description: "Store a Laravel notification in the database and show the latest unread rows on a Vue page."
seoTitle: "Database notifications in Vue"
date: 2026-10-10T07:20:00Z
snippet: "php artisan make:notification PostPublished"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---

The database channel writes a row the page can read on the next visit. It does not push that row to an open browser. If the bell has to update while the user sits on the page, that is [Reverb](/laravel-reverb-vue). This page stops at the stored notification and the Vue list.

The app those pages belong to is [Inertia, a SPA, or Nuxt](/laravel-vue-in-2026).

## Store one

```bash
php artisan make:notification PostPublished
php artisan make:notifications-table
php artisan migrate
```

`via` returns the database channel only. `toArray` is the JSON stored on the row. Keep it small. The Vue page will print `data.title`.

```php
// app/Notifications/PostPublished.php
public function via(object $notifiable): array
{
    return ['database'];
}

public function toArray(object $notifiable): array
{
    return [
        'title' => $this->post->title,
    ];
}
```

Pass the post into the constructor and call `notify` on the user who should see it. `Notifiable` is already on the starter kit's `User`.

```php
$user->notify(new PostPublished($post));
```

Mail, Slack, and broadcast drivers are other `via` values. Leave them out until you mean to send them. A broadcast notification needs the queue and the Reverb process from that guide. Do not half-configure Echo here.

## Show ten

Share the unread rows from `HandleInertiaRequests` or from the controller that renders the layout's data. Limit the query. An unbounded `notifications` relation will grow into the props.

```php
'notifications' => $request->user()
    ?->unreadNotifications()
    ->latest()
    ->limit(10)
    ->get(['id', 'data', 'created_at']) ?? [],
```

```vue
<ul>
  <li v-for="notification in notifications" :key="notification.id">
    {{ notification.data.title }}
  </li>
</ul>
```

`data` is the array from `toArray`, decoded. It is not the Eloquent model. If the title is missing, the notification class returned different keys than the template reads.

Mark one read with a normal POST. Scope it to the current user so an id from someone else 404s.

```php
Route::post('/notifications/{id}/read', function (Request $request, string $id) {
    $notification = $request->user()
        ->notifications()
        ->whereKey($id)
        ->firstOrFail();

    $notification->markAsRead();

    return back();
})->middleware('auth');
```

The Vue control is an Inertia `Link` or `Form` with `method="post"`. After `back()`, the shared query hides the row because it is no longer unread.

## Where this stops

Nothing in this page opens a websocket. Polling `router.reload({ only: ['notifications'] })` works and is the [partial reload](/inertia-partial-reloads) guide. A live bell is Reverb. Pick one. Do not poll and subscribe to the same list.
