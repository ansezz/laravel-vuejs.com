---
id: 84
title: "Share a prop with every Inertia page"
seoTitle: "Inertia shared props"
excerpt: "HandleInertiaRequests::share() runs for every Inertia response. Keep the query cheap and leave secrets out."
description: "HandleInertiaRequests::share() runs for every Inertia response. Keep the query cheap and leave secrets out."
date: 2026-10-11T10:31:00Z
snippet: "parent::share($request)"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---
People searching "Inertia shared data Vue" put a post query in `share()` and then every page loads it, including the login screen. The [setup guide](/application-setup) already shares `auth.user`. Add one more value only when every page needs it.

```php
public function share(Request $request): array
{
    return [
        ...parent::share($request),
        'appName' => config('app.name'),
    ];
}
```

Read it from the page object:

```vue
<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";

const page = usePage();
</script>

<template>
  <p>{{ page.props.appName }}</p>
</template>
```

A list of posts belongs on the controller that renders the list, not here. A shared closure should be lazy when the work is heavy, so a response that does not read the prop does not run it.

Do not share `$request->user()` a second time under another key. The kit already did it. Do not share an API token. Shared props are in the HTML of every visit.
