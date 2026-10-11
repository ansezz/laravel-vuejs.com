---
id: 62
title: "Keep the scroll position on an Inertia visit"
seoTitle: "Inertia preserveScroll"
excerpt: "preserveScroll stops a filter or a save from jumping to the top of a long Vue page."
description: "preserveScroll stops a filter or a save from jumping to the top of a long Vue page."
date: 2026-10-11T10:09:00Z
snippet: "form.get(\"/posts\", { preserveScroll: true })"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---
People searching "Inertia preserve scroll" lose their place every time a search box reloads the list. The [CRUD guide](/laravel-inertia-vue-crud) already passes `preserveScroll` on that filter. This page is the same option on a save that redirects back to a long page.

```ts
form.post(`/posts/${post.id}`, {
  preserveScroll: true,
});
```

Inertia follows the redirect and then scrolls to the top, unless you say otherwise. `preserveScroll: true` keeps the window where it was. Use it for a row action on a list. Do not use it for a "next page" link. The next page should start at the top, and `<Link>` does that by default.

There is a second scroll: a layout with `overflow: auto` on a div. `preserveScroll` tracks the window, not that div. If the list lives in a nested scroller, keep that element's `scrollTop` yourself. Do not add a second router to do it.

Do not turn on `html { scroll-behavior: smooth }` and then expect a test to see the final position immediately. The site you are reading does that. A product app can make the same mistake in a browser test.
