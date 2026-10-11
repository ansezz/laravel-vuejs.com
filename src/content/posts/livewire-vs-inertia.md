---
id: 36
title: "Livewire or Inertia for a Laravel app"
excerpt: "Livewire keeps the UI in Blade. Inertia keeps it in Vue and leaves the routes in Laravel. The starter kit you pick is the decision."
description: "Choose the official Livewire starter kit or Inertia with Vue, based on who writes the interface and whether you need a separate API."
seoTitle: "Livewire or Inertia"
date: 2026-10-10T08:10:00Z
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---

"Livewire vs Inertia" is a team question wearing a package question. Both ship as official Laravel starter kits. Both use Laravel routes. They do not split a single screen cleanly. Pick one for the product UI.

Laravel's current AI docs talk about Livewire 2, 3, and 4, so a new Livewire starter kit is the Livewire 4 line. This page does not pin a kit build number. The Vue side of the same choice, including a separate SPA and Nuxt, is [Inertia, a SPA, or Nuxt](/laravel-vue-in-2026).

## What each one is

Livewire renders Blade and updates the parts of the page that changed. You write PHP classes and HTML. JavaScript shows up when a screen needs it, not as the structure of the app. Choose the Livewire starter kit when the people building the product are comfortable in Laravel and do not want a Vue codebase.

Inertia renders Vue pages. Controllers return `Inertia::render`. The browser app is Vue 3, with the kit's TypeScript and Vite. Routes stay in `routes/web.php`. There is no Vue Router on those screens. Choose the Vue starter kit when the interface is a Vue interface, or when the people building it already work in components.

A separate HTTP API, for a mobile app or a second front end, is a third path. Inertia is not that API. Livewire is not that API either. [Sanctum](/laravel-sanctum-vue-spa) is the cookie layer if the other front end is Vue.

## The same jobs, different files

| Job             | Livewire starter kit                | Vue and Inertia                                                      |
| --------------- | ----------------------------------- | -------------------------------------------------------------------- |
| First page      | A Livewire component                | [Application setup](/application-setup)                              |
| Create and edit | Component properties and actions    | [CRUD](/laravel-inertia-vue-crud)                                    |
| Login           | The kit's auth screens              | The kit's auth screens, or [Fortify](/laravel-fortify-vue) for a SPA |
| Who may edit    | A policy, called from the component | A [policy](/laravel-vue-policies), called from the controller        |
| Public HTML     | Blade is already HTML               | [SSR](/inertia-ssr), and only if you need it                         |

The policy is the same class either way. Do not rewrite authorization because the template language changed.

## Do not install both for one screen

A Livewire component inside a Vue page, or a Vue island inside a Livewire screen, is two systems owning one URL. Validation, redirects, and loading state will not agree. If a single widget has to be interactive and the rest of the app is Livewire, Livewire can host that widget. If the product is Vue, build the widget as a component and talk to Laravel through Inertia.

You can still change your mind before the first feature. You cannot cheaply change your mind after a year of pages. The starter kit is the migration. Running `composer require livewire/livewire` inside the Vue kit, or the reverse, is how the two clients end up in one repo without a plan.

## Where this stops

Requirements that apply to both, including PHP 8.3 and Node when you are on the Vue kit, are [what you need](/requirements). Deploying the Vue build is [deploy](/deploy-laravel-vue). The Livewire starter kit also runs Vite, so `npm run dev` writes `public/hot` there too. Do not deploy that file from either kit.
