---
id: 91
title: "Hide a Vue button with a gate"
seoTitle: "Hide a button with a gate"
excerpt: "Share the gate as a boolean. The controller still calls authorize on the POST."
description: "Share the gate as a boolean. The controller still calls authorize on the POST."
date: 2026-10-11T10:38:00Z
snippet: "'canUpdate' => $request->user()?->can('update', $post)"
categories: [laravel, vuejs]
tags: [laravel, vuejs, permissions]
---
People searching "Laravel gate Vue button" hide the button and stop. The POST still runs. Share a boolean for the button, and keep `authorize` on the write. The [policy guide](/laravel-vue-policies) defines `update`.

```php
return Inertia::render('posts/Show', [
    'post' => $post->only(['id', 'title']),
    'canUpdate' => $request->user()?->can('update', $post),
]);
```

```vue
<button v-if="canUpdate" type="button" @click="edit">Edit</button>
```

`can` runs the same policy the controller will run. The boolean is a copy from the last response. It goes stale if a teammate changes the owner's id. The next POST still checks.

Do not send the whole gate map, or the user model, so the page can call `can` itself. Vue cannot see the policy. Do not hide the button with CSS. `v-if` removes it. A person can still POST, which is why the controller check stays.
