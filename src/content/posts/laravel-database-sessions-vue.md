---
id: 133
title: "Store sessions in the database"
seoTitle: "Database sessions for Vue"
excerpt: "File sessions break when two servers handle the next request. database sessions follow the user."
description: "File sessions break when two servers handle the next request. database sessions follow the user."
date: 2026-10-11T11:20:00Z
snippet: "SESSION_DRIVER=database"
categories: [laravel, vuejs]
tags: [laravel, vuejs, setup]
---
People searching "Laravel database session Vue" stay on the file driver and then login sticks on one server and 419s on the other. The cookie is fine. The session file is on the other disk. The [Sanctum guide](/laravel-sanctum-vue-spa) is the cookie. This page is the driver.

```shell
php artisan session:table
php artisan migrate
```

```ini
SESSION_DRIVER=database
```

Inertia visits then read the session from the database, including the CSRF token and the logged-in user. One database, many app servers.

Do not use the file driver on a platform that runs more than one machine, or that does not keep local disk. Do not put session rows in the same backup story as "we can delete the sessions table to clean up" without knowing you will log everyone out. That part is fine on purpose. Doing it in the middle of the day is the outage.
