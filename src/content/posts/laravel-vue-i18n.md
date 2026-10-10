---
id: 23
title: "Laravel and Vue translations"
excerpt: "Laravel holds the strings. vue-i18n renders them. The instance is created once, so a locale change has to push new messages into it."
description: "Translate a Laravel and Vue app with lang files, a shared locale prop, and vue-i18n in legacy: false mode."
seoTitle: "Laravel and Vue translations"
date: 2026-10-10T06:00:00Z
snippet: "npm install vue-i18n"
categories: [laravel, vuejs]
tags: [laravel, vuejs, i18n]
---

Laravel already has a `lang` directory. Vue does not read it. The job is to share the locale and the strings as Inertia props, then let vue-i18n render them. Do not add a second translation package that syncs files. The stack around this page is [Inertia, a SPA, or Nuxt](/laravel-vue-in-2026).

## The PHP strings

```php
// lang/en/messages.php
return [
    'posts' => 'Posts',
    'saved' => 'Saved.',
];
```

```php
// lang/fr/messages.php
return [
    'posts' => 'Articles',
    'saved' => 'Sauvegarde.',
];
```

Share the active file from `HandleInertiaRequests`. `Lang::get('messages')` returns the array for that locale. Set the locale from the session before you load the file, or the French page still receives the English array.

```php
// app/Http/Middleware/HandleInertiaRequests.php
use Illuminate\Support\Facades\Lang;

public function share(Request $request): array
{
    $locale = $request->session()->get('locale', config('app.locale'));
    app()->setLocale($locale);

    return [
        ...parent::share($request),
        'i18n' => [
            'locale' => $locale,
            'messages' => Lang::get('messages'),
        ],
    ];
}
```

```php
// routes/web.php
Route::post('/locale', function (Request $request) {
    $locale = $request->validate([
        'locale' => ['required', 'in:en,fr'],
    ])['locale'];

    $request->session()->put('locale', $locale);

    return back();
});
```

The allow-list is the point. Do not write `$request->string('locale')` straight into `setLocale`.

## vue-i18n

```bash
npm install vue-i18n
```

Register it beside Pinia, inside the starter kit's `setup` callback. `legacy: false` is the Composition API mode. The `props` argument here is Inertia's setup props, so the first page's data is `props.initialPage.props`.

```ts
import { createI18n } from "vue-i18n";
import { createPinia } from "pinia";

// inside setup({ el, App, props, plugin })
const page = props.initialPage.props;
const i18n = createI18n({
  legacy: false,
  locale: page.i18n.locale,
  messages: {
    [page.i18n.locale]: page.i18n.messages,
  },
});

createApp({ render: () => h(App, props) })
  .use(plugin)
  .use(createPinia())
  .use(i18n)
  .mount(el);
```

That instance is created once. A later visit can change `page.props.i18n` without rebuilding it. Update the instance when the shared prop changes. A layout that is always mounted is the right place.

```vue
<script setup lang="ts">
import { watch } from "vue";
import { useI18n } from "vue-i18n";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const { locale, mergeLocaleMessage } = useI18n();

watch(
  () => page.props.i18n,
  (i18n) => {
    mergeLocaleMessage(i18n.locale, i18n.messages);
    locale.value = i18n.locale;
  },
);
</script>
```

In a page, `t` reads the key you put in the PHP file.

```vue
<script setup lang="ts">
import { useI18n } from "vue-i18n";

const { t } = useI18n();
</script>

<template>
  <h1>{{ t("posts") }}</h1>
</template>
```

The locale switch is a normal Inertia form posting to `/locale`. `back()` loads the same page again, the middleware shares the other file, and the watcher swaps `t("posts")`.

## Where this stops

Dates and money still use `Intl` in the browser or Carbon on the server. This page does not format them. Client-only drafts stay in [Pinia](/pinia-laravel-inertia). Pinia is the wrong place to copy the language files.
