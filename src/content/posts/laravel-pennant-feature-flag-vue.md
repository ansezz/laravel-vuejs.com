---
id: 111
title: "Send a Pennant flag to a Vue page"
seoTitle: "Pennant flag on a Vue page"
excerpt: "Feature::for($user)->active() becomes a boolean prop. The controller checks the same flag before it writes."
description: "Feature::for($user)->active() becomes a boolean prop. The controller checks the same flag before it writes."
date: 2026-10-11T10:58:00Z
snippet: "composer require laravel/pennant"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---
People searching "Laravel Pennant Vue" hide a button and let the POST through. A flag is a server check that you also copy into a prop. The [stack guide](/laravel-vue-in-2026) is the app this flag sits on.

```shell
composer require laravel/pennant
```

```php
use Laravel\Pennant\Feature;

Feature::define('new-editor', function (User $user) {
    return (bool) $user->is_admin;
});
```

Define that in a service provider, not in the Vue page.

```php
$enabled = $request->user()
    ? Feature::for($request->user())->active('new-editor')
    : false;

return Inertia::render('posts/Edit', [
    'newEditor' => $enabled,
]);
```

```vue
<section v-if="newEditor">New editor</section>
```

The store method checks `active('new-editor')` again before it writes. Do not send the flag list to the browser and trust a posted `newEditor: true`. Do not call the provider from the page to "evaluate the flag".
