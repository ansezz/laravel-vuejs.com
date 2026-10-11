---
id: 113
title: "Format a timestamp in the user's zone"
seoTitle: "Format a time in the user zone"
excerpt: "Store UTC. Format with the user's timezone when you send the prop. Do not save local time into a timestamp column."
description: "Store UTC. Format with the user's timezone when you send the prop. Do not save local time into a timestamp column."
date: 2026-10-11T11:00:00Z
snippet: "$post->created_at->timezone($zone)->toIso8601String()"
categories: [laravel, vuejs]
tags: [laravel, vuejs, php]
---
People searching "Laravel timezone Vue" set `APP_TIMEZONE` to the user's city and then every row shifts when someone else signs in. `config('app.timezone')` is the app default. The database connection should store UTC. Convert for display.

```php
$zone = in_array($request->user()->timezone, timezone_identifiers_list(), true)
    ? $request->user()->timezone
    : config('app.timezone');

'createdAt' => $post->created_at->timezone($zone)->toIso8601String(),
```

The Vue page prints the string. It does not add an offset again. Adding it twice is how a 10:00 post becomes 12:00.

Do not store a local datetime in a `timestamp` column by formatting it in PHP and writing the string. The next reader in another zone cannot undo a conversion you did not record. Do not trust a timezone name that is not in `timezone_identifiers_list()`.
