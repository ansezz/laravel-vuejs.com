---
id: 29
title: "GitHub login with Laravel Socialite and Vue"
excerpt: "The GitHub button is a normal link. The callback reads the Socialite user, finds or creates a local user, and logs that session in."
description: "Add GitHub login to a Laravel and Vue app with Socialite, a full-page redirect, and a user matched on email."
seoTitle: "GitHub login with Socialite"
date: 2026-10-10T07:00:00Z
snippet: "composer require laravel/socialite"
categories: [laravel, vuejs]
tags: [laravel, vuejs, socialite]
---

Socialite sends the browser to GitHub and back. It is not an XHR. A Vue click handler that `axios.get`s the redirect URL will not follow GitHub's login page. The control is a normal link. The session it creates is still Laravel's session, which is the same cookie story as [Sanctum for a Vue SPA](/laravel-sanctum-vue-spa) when the front end is another origin. On the Inertia starter kit the link can live on the existing login page. The architecture is [Inertia, a SPA, or Nuxt](/laravel-vue-in-2026).

## Install

```bash
composer require laravel/socialite
```

The client id and secret come from the environment, through `config/services.php`. Do not read `env()` in the controller.

```php
// config/services.php
'github' => [
    'client_id' => env('GITHUB_CLIENT_ID'),
    'client_secret' => env('GITHUB_CLIENT_SECRET'),
    'redirect' => env('GITHUB_REDIRECT_URI'),
],
```

`GITHUB_REDIRECT_URI` is the callback you register at GitHub, such as `http://localhost:8000/auth/github/callback`. The Inertia app served by Sail is `http://localhost` instead. Use the host the browser actually returns to.

## Two routes and a link

```php
// routes/web.php
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

Route::get('/auth/github/redirect', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('/auth/github/callback', function () {
    $githubUser = Socialite::driver('github')->user();

    $user = User::query()->firstOrNew([
        'email' => $githubUser->getEmail(),
    ]);

    $user->name = $githubUser->getName() ?: $githubUser->getNickname();

    if (! $user->exists) {
        $user->password = Hash::make(str()->random(40));
    }

    $user->save();

    Auth::login($user);

    return redirect('/dashboard');
});
```

```vue
<a href="/auth/github/redirect">Continue with GitHub</a>
```

Match on email. Put the random password on the create path only. `updateOrCreate` with a new password in the second array resets that password on every GitHub login, including for someone who already had one.

GitHub does not always return an email. If `getEmail()` is null, do not insert a user with an empty email. Ask them to make the email visible on GitHub, or store the GitHub id and collect an email yourself. This callback does not invent a second account-linking flow.

The users table from the starter kit requires `password`. The random string satisfies that column. The person signs in through GitHub, not by typing it.

## Where this stops

Socialite does not replace Fortify's password reset. Email and password stay [Fortify](/laravel-fortify-vue). The callback above does not check a [permission](/laravel-vue-permissions). A new GitHub user is a normal user until you give them one.

Add scopes only when you need an API GitHub will not return by default. The login above uses the default user. Extra scopes are a decision you can point at the [Socialite docs](https://laravel.com/docs/13.x/socialite), not a list to paste in before the first redirect works.
