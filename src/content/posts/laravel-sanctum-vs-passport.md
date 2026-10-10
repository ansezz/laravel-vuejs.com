---
id: 42
title: "Sanctum or Passport for a Vue app"
excerpt: "Sanctum is the cookie and the API token. Passport is the OAuth server for a third party that brings its own client id."
description: "Use Sanctum for a Vue SPA, a mobile app, or API tokens. Use Passport only when a third party must log in with OAuth."
seoTitle: "Sanctum or Passport"
date: 2026-10-10T08:40:00Z
snippet: "php artisan install:api --passport"
categories: [laravel, vuejs]
tags: [laravel, vuejs, sanctum, passport]
---

Laravel's own split is the one to use. If the app must speak OAuth 2, use Passport. If you are authenticating a single-page app, a mobile app, or issuing API tokens, use Sanctum. Sanctum does not support OAuth 2. The [Passport docs](https://laravel.com/docs/13.x/passport) state that directly.

The Vue starter kit's login is a session. Your own Vue SPA on another origin is also a session cookie, which is [Sanctum for a Vue SPA](/laravel-sanctum-vue-spa). A bearer token in that article is for a phone or a script you own. Passport is the next step only when some other product redirects a user to you, gets a code, and exchanges it for a token. The stack choice is [Laravel and Vue in 2026](/laravel-vue-in-2026).

Do not put Sanctum's `HasApiTokens` and Passport's `HasApiTokens` on `User` together. `php artisan install:api --passport` replaces the API token machinery. The `web` guard stays `session`, so the kit's login page keeps working.

## Install Passport

```bash
php artisan install:api --passport
```

That publishes and runs the OAuth migrations and creates the encryption keys. Then `User` implements Passport's contract and uses Passport's trait. Keep `HasFactory` and `Notifiable`. Remove Sanctum's `HasApiTokens` import if the model already has it. The two traits share a name and must not both be applied.

```php
use Laravel\Passport\Contracts\OAuthenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements OAuthenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
}
```

`config/auth.php` must send API requests through Passport:

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],
],
```

On the first deploy, generate keys on the server with `php artisan passport:keys`. Do not commit those files. You can point Passport at a directory with `Passport::loadKeysFrom` in `AppServiceProvider`. To load the keys from the environment instead, publish the config and set `PASSPORT_PRIVATE_KEY` and `PASSPORT_PUBLIC_KEY`:

```bash
php artisan vendor:publish --tag=passport-config
```

## The consent screen

Passport 13 does not ship a Blade consent page. Register one in `AppServiceProvider::boot`. The docs pass the whole request into Inertia. The form only needs three scalars, plus the CSRF token, so pass those:

```php
use Inertia\Inertia;
use Laravel\Passport\Passport;

Passport::authorizationView(function (array $parameters) {
    return Inertia::render('auth/OAuth/Authorize', [
        'state' => $parameters['request']->string('state')->toString(),
        'clientId' => (string) $parameters['client']->getKey(),
        'clientName' => $parameters['client']->name,
        'authToken' => $parameters['authToken'],
        'scopes' => collect($parameters['scopes'])->map(fn ($scope) => [
            'id' => $scope->id,
            'description' => $scope->description,
        ])->values(),
        'csrf' => csrf_token(),
    ]);
});
```

`/oauth/authorize` is already registered. Approve is a POST to the named route `passport.authorizations.approve`. Deny is a DELETE to `passport.authorizations.deny`. Both expect `state`, `client_id`, and `auth_token`. A browser form cannot send DELETE, so the deny form posts with `_method` set to `DELETE`.

```vue
<script setup lang="ts">
defineProps<{
  state: string;
  clientId: string;
  clientName: string;
  authToken: string;
  scopes: { id: string; description: string }[];
  csrf: string;
}>();
</script>

<template>
  <h1>Allow {{ clientName }}?</h1>
  <ul>
    <li v-for="scope in scopes" :key="scope.id">{{ scope.description }}</li>
  </ul>

  <form method="post" action="/oauth/authorize">
    <input type="hidden" name="_token" :value="csrf" />
    <input type="hidden" name="state" :value="state" />
    <input type="hidden" name="client_id" :value="clientId" />
    <input type="hidden" name="auth_token" :value="authToken" />
    <button type="submit">Allow</button>
  </form>

  <form method="post" action="/oauth/authorize">
    <input type="hidden" name="_method" value="DELETE" />
    <input type="hidden" name="_token" :value="csrf" />
    <input type="hidden" name="state" :value="state" />
    <input type="hidden" name="client_id" :value="clientId" />
    <input type="hidden" name="auth_token" :value="authToken" />
    <button type="submit">Deny</button>
  </form>
</template>
```

Save it as `Authorize.vue` inside `pages/auth/OAuth`, next to the kit's other auth pages. Do not read `document` while the script is setting up. The page can be server-rendered, and the form is a normal POST so Passport can redirect back to the other app.

A first-party client can skip this prompt. Extend Passport's `Client` and return `$this->firstParty()` from `skipsAuthorization`. The [docs](https://laravel.com/docs/13.x/passport) show that override. A third-party client should keep the prompt.

## The other app asks for a token

Create the client with `php artisan passport:client`. When it asks for the redirect URI, a comma-separated list is accepted. For a client owned by one of your users, the docs call `createAuthorizationCodeGrantClient` on `ClientRepository`. Show `$client->plainSecret` once. `$user->oauthApps()` lists that user's clients.

The consuming app, not your Vue bundle, redirects the browser to `/oauth/authorize` with `client_id`, `redirect_uri`, `response_type=code`, `scope`, and a `state` you stored in that app's session (`Str::random(40)`). `prompt` may be `none`, `consent`, or `login`. After the user allows access, the callback checks `state`, then exchanges the code from the server:

```php
$response = Http::asForm()->post('https://passport-app.test/oauth/token', [
    'grant_type' => 'authorization_code',
    'client_id' => 'your-client-id',
    'client_secret' => 'your-client-secret',
    'redirect_uri' => 'https://third-party-app.com/callback',
    'code' => $request->code,
]);
```

The JSON has `access_token`, `refresh_token`, and `expires_in`. The client secret stays on that server. It never goes in a Vue file, a Vite env var, or `localStorage`.

A public client that cannot keep a secret uses `php artisan passport:client --public` and the PKCE grant in the same docs. Do not use the implicit grant for a new SPA. The grant list, scopes, and refresh flow stay in the Passport docs rather than copied here.

Protect your API with `auth:api`. Callers send `Authorization: Bearer` and the access token. That header is for the third party. Your own Inertia pages keep using the session.
