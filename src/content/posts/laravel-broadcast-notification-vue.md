---
id: 127
title: "Broadcast a notification to a Vue page"
seoTitle: "Broadcast a notification"
excerpt: "Add broadcast to via() only after the Reverb page is in place. Do not open a second Echo client."
description: "Add broadcast to via() only after the Reverb page is in place. Do not open a second Echo client."
date: 2026-10-11T11:14:00Z
snippet: "return ['database', 'broadcast'];"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---
People searching "Laravel broadcast notification Vue" add a second Echo connection beside the one the kit has. The [Reverb guide](/laravel-reverb-vue) subscribes with `useEchoPublic`. The [notifications guide](/laravel-vue-notifications) is the database bell. A broadcast channel is a third delivery of the same notification, not a second app.

```php
public function via(object $notifiable): array
{
    return ['database', 'broadcast'];
}
```

The database row is the thing the page can still show after a reload. The broadcast is the nudge. If the socket is down, the bell still works on the next visit.

Do not skip the database channel because the socket "felt instant". A missed socket message is gone. Do not broadcast the full user model. Broadcast the sentence and the id. Private channels, when you need them, are authorized in `routes/channels.php` the way the Reverb guide describes. This page does not add a new channel.
