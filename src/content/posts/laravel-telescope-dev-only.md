---
id: 134
title: "Install Telescope for local debugging"
seoTitle: "Telescope only in local"
excerpt: "Telescope is a dev dependency. The default gate should not let the public open /telescope."
description: "Telescope is a dev dependency. The default gate should not let the public open /telescope."
date: 2026-10-11T11:21:00Z
snippet: "composer require laravel/telescope --dev"
categories: [laravel, vuejs]
tags: [laravel, vuejs, tooling]
---
People searching "Laravel Telescope Vue" install it in production to watch Inertia requests. It records request bodies. That includes passwords if you are not careful, and it is a second app on your URL. Keep it local.

```shell
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

The published `TelescopeServiceProvider` gates `viewTelescope`. Leave that gate on `local`. Do not return true for every user so a Vue admin link can open it.

Inertia requests show up as HTTP requests. You can see the props and the session. That is useful on your machine. It is not a product feature, and the Vue page should not iframe it.

Do not require Telescope without `--dev` and then try to prune it later. Do not register it in every environment because CI was missing the provider. CI does not need the UI.
