---
id: 126
title: "Send mail and a database notification"
seoTitle: "Mail and database notification"
excerpt: "via() can return mail and database. The Vue bell reads the database row. It does not read the mailable."
description: "via() can return mail and database. The Vue bell reads the database row. It does not read the mailable."
date: 2026-10-11T11:13:00Z
snippet: "return ['mail', 'database'];"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---
People searching "Laravel notification mail and database" create a mailable and a notification and send both by hand. One notification can list both channels. The [notifications guide](/laravel-vue-notifications) is the bell. This page is `via()`.

```php
public function via(object $notifiable): array
{
    return ['mail', 'database'];
}
```

The database channel needs the notifications table:

```shell
php artisan notifications:table
php artisan migrate
```

`toArray()` is what the bell stores. `toMail()` is the email. Keep the secrets out of both. The Vue page still loads the unread rows the way the notifications guide shows. You do not poll the mailbox.

Do not `Mail::send` and `notify` with two different texts that can drift. Do not put the HTML of the mail into the database column and render it with `v-html`.
