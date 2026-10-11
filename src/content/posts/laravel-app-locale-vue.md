---
id: 112
title: "Switch the app locale from Vue"
seoTitle: "Switch locale from Vue"
excerpt: "Set the locale from an allow-list. A query string is not a locale until you have checked it."
description: "Set the locale from an allow-list. A query string is not a locale until you have checked it."
date: 2026-10-11T10:59:00Z
snippet: "App::setLocale($locale)"
categories: [laravel, vuejs]
tags: [laravel, vuejs, i18n]
---
People searching "Laravel locale Vue" call `App::setLocale($request->query('locale'))` with no list. The [i18n guide](/laravel-vue-i18n) is the Vue strings. This page is the one line that picks the language for Laravel's own translator.

```php
$locale = $request->string('locale')->toString();

if (in_array($locale, ['en', 'fr', 'ar'], true)) {
    $request->user()->update(['locale' => $locale]);
    App::setLocale($locale);
}
```

Share the current locale if the layout needs it. Validation messages then use that language on the next response.

Do not pass the raw query string into `setLocale`. An unknown locale falls through to odd file lookups. Do not store the locale only in `localStorage`. The server renders the flash and the mail, and it cannot see that key.
