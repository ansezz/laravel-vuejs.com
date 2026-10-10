---
id: 41
title: "Breeze, Jetstream, and the Vue starter kit"
excerpt: "Both packages still install. laravel new no longer offers them. The Vue starter kit already has the screens those tutorials are trying to publish."
description: "Breeze and Jetstream still install. laravel new offers the Vue starter kit instead. Map the old screens before you add either package."
seoTitle: "Breeze, Jetstream, and the Vue kit"
date: 2026-10-10T08:30:00Z
snippet: "laravel new my-app"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---

A search for "Laravel Vue auth" still ends on `php artisan breeze:install vue` or `php artisan jetstream:install inertia`. Those commands publish an older starter into the app. Laravel 13's installer does not offer either package. `laravel new` asks for the current kits: Vue, React, Svelte, or Livewire.

Breeze and Jetstream still exist as Composer packages. Each GitHub readme says the package is for Laravel 11 and prior, and points new apps at [laravel.com/starter-kits](https://laravel.com/starter-kits). Do not install either one on top of the Vue starter kit. You would get two login stacks, two sets of routes, and a Vite config fighting itself.

The choice of Inertia, a separate SPA, or Nuxt is [Laravel and Vue in 2026](/laravel-vue-in-2026). The kit's login actions are [Fortify](/laravel-fortify-vue).

## A new app

```bash
laravel new my-app
```

Pick the Vue starter kit. It gives you login, registration, password reset, email verification, and profile settings, with the Vue pages living in the app rather than inside a package. [What you need](/requirements) is the version check. The [first page](/application-setup) is the next thing to build.

This page does not migrate an existing Breeze or Jetstream app. If that app already runs, leave the package in place and keep shipping features. A rewrite is a different project.

## Where the old screens went

| Old tutorial                                           | Vue starter kit                                                                                                        |
| ------------------------------------------------------ | ---------------------------------------------------------------------------------------------------------------------- |
| Breeze login, register, forgot password, reset, verify | `resources/js/pages/auth`, posting to Fortify                                                                          |
| Breeze profile                                         | The kit's settings pages                                                                                               |
| Jetstream two-factor                                   | Fortify two-factor, already enabled on the kit                                                                         |
| Jetstream teams                                        | A teams option when the kit is generated                                                                               |
| Jetstream API tokens                                   | [Sanctum tokens](/laravel-sanctum-vue-spa), or [Passport](/laravel-sanctum-vs-passport) when the client must use OAuth |

The Fortify actions are `app/Actions/Fortify/CreateNewUser.php` and `ResetUserPassword.php`. Edit those when registration needs another column. Do not register a second `POST /login`.

## The commands to skip

On a fresh app that is not the Vue starter kit, the old installers are still the ones tutorials paste:

```bash
composer require laravel/breeze --dev
php artisan breeze:install vue
```

```bash
composer require laravel/jetstream
php artisan jetstream:install inertia
```

Run neither inside an app you created with the Vue starter kit. Breeze's `vue` stack publishes its own Inertia pages, layout, and Vite setup. Jetstream's `inertia` stack does the same, and it also pulls in teams and Sanctum token UI that the kit does not expect to share a routes file with.

## Teams, tokens, and two-factor

The [Laravel 13 starter kit docs](https://laravel.com/docs/13.x/starter-kits) say the Vue kit may be generated with team support. Each user then belongs to a team, and the team screens ship in that app. That option is chosen when the app is created. Adding Jetstream later is not how you turn teams on.

Jetstream's API token screen was a Sanctum personal access token. The Vue kit's browser login is a session cookie. A phone or a script that needs a token uses the token section of the Sanctum guide. A third party with its own client id uses Passport. Neither case needs Jetstream installed beside the kit.

Two-factor authentication is already a Fortify feature on the starter kit. The challenge routes are documented with the rest of Fortify. This page does not add a second two-factor form.

## What to build next

Auth is done when `laravel new` finishes and the kit's login page accepts a user. The first feature is [create, edit, delete, and search](/laravel-inertia-vue-crud). A separate Vue app that is not this kit is the [Sanctum cookie guide](/laravel-sanctum-vue-spa), and it still does not get Breeze installed on the Laravel side.
