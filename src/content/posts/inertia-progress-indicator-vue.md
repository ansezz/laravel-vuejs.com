---
id: 63
title: "Show the Inertia progress bar"
seoTitle: "Inertia progress bar in Vue"
excerpt: "The progress bar is a setting on createInertiaApp. A second progress library fights the one the kit starts."
description: "The progress bar is a setting on createInertiaApp. A second progress library fights the one the kit starts."
date: 2026-10-11T10:10:00Z
snippet: "progress: { color: \"#6422e0\" }"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---
People searching "Inertia progress bar Vue" think the visit has no feedback. The Vue starter kit already starts the bar in `resources/js/app.ts`. A slow [pagination](/laravel-vue-pagination) request is when you notice the color.

Find `createInertiaApp` and set the color if the default disappears on your background:

```ts
createInertiaApp({
  progress: {
    color: "#6422e0",
  },
  // setup stays as the kit generated it
});
```

`progress: false` turns the bar off. That is the line to delete if a tutorial told you to disable it and the page now looks frozen.

The bar tracks Inertia visits: `Link`, `router.post`, and `useForm`. It does not track a `fetch()` you wrote beside Inertia. A file upload uses the Form component's own progress, which the [upload guide](/laravel-vue-file-upload) reads. Do not install NProgress. The kit already includes the indicator.

Do not hide the bar by setting the color to the page background and then report that visits "do nothing".
