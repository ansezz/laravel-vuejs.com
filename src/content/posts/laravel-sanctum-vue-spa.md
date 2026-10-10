---
id: 15
title: "Authenticate a Vue SPA with Laravel Sanctum"
excerpt: "Cookie sessions for a first-party Vue app, CSRF, stateful domains, and the token path that is only for a phone or a third party."
description: "Laravel Sanctum SPA authentication for Vue 3: CSRF cookie, session login, CORS, and when a bearer token is the wrong tool."
seoTitle: "Laravel Sanctum Vue SPA authentication"
date: 2026-10-10T04:40:00Z
snippet: "php artisan install:api"
categories: [laravel, vuejs]
tags: [laravel, vuejs, sanctum]
---

"Laravel Sanctum Vue" tutorials still tell you to store a bearer token in `localStorage` for an app you wrote yourself. Sanctum's docs say the opposite. A first-party SPA uses the session cookie. Tokens are for a phone, a script, or someone else's server.

If the screen is an Inertia page from the Vue starter kit, you already have login. Read [which stack to use](/laravel-vue-in-2026) before you add a second auth system. This guide is for a Vue app that calls a Laravel API.

## Install the API

```bash
php artisan install:api
```

That command installs Sanctum and publishes the API routes. Then allow cookie authentication from your own front end:

```php
// bootstrap/app.php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->statefulApi();
})
```

`statefulApi()` is what makes a request from your SPA use the session, while a request with an `Authorization: Bearer` header can still use a token.

## Domains, cookies, and CORS

The SPA and the API must share a top-level domain. `app.example.com` and `api.example.com` work. `localhost:5173` calling `localhost:8000` works only if the port is listed.

Add the SPA origin, including the port, to `SANCTUM_STATEFUL_DOMAINS`. For Vite that is often `localhost:5173`. For Nuxt it is often `localhost:3000`. Also include the Laravel host you actually open, such as `localhost:8000`.

If the SPA is on another origin, publish CORS and allow credentials:

```bash
php artisan config:publish cors
```

```php
// config/cors.php
'supports_credentials' => true,
```

For two real subdomains, set the session cookie on the parent:

```php
// config/session.php
'domain' => '.example.com',
```

Leave `SESSION_DOMAIN` empty when everything is `localhost`. A leading dot on `localhost` is a common way to get a cookie that never sticks.

Send `Accept: application/json` on API calls. Without it, a failed login can come back as a redirect to an HTML page instead of a 422.

## The login route is a web route

The session and the CSRF check live on the `web` middleware group. Put login there, not in `routes/api.php`.

```php
// routes/web.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (! Auth::attempt($credentials, $request->boolean('remember'))) {
        throw ValidationException::withMessages([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    $request->session()->regenerate();

    return response()->noContent();
});

Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return response()->noContent();
});
```

Protect the JSON routes with the `sanctum` guard:

```php
// routes/api.php
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
```

[Laravel Fortify](https://laravel.com/docs/13.x/fortify) can own `/login` instead of the closure above. Use it when you also need registration, password reset, and two-factor. The cookie rules do not change.

## The Vue side

Inertia 3 no longer bundles Axios. A separate SPA installs it:

```bash
npm install axios
```

```ts
// resources/js/api.ts, or the SPA's src/api.ts
import axios from "axios";

export const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL ?? "",
  withCredentials: true,
  withXSRFToken: true,
  headers: { Accept: "application/json" },
});
```

`withXSRFToken` makes Axios copy the `XSRF-TOKEN` cookie into the `X-XSRF-TOKEN` header. That is the CSRF check.

```ts
export async function login(email: string, password: string) {
  await api.get("/sanctum/csrf-cookie");
  await api.post("/login", { email, password });
}

export async function currentUser() {
  const { data } = await api.get("/api/user");
  return data;
}
```

Call `/sanctum/csrf-cookie` before the first POST. Laravel sets the cookie on that response. A later POST without it returns **419**. A POST with a valid cookie but no session returns **401** from `auth:sanctum`. Send the user back to the login page on either of those.

A 419 after a deploy is often `SESSION_DOMAIN`, `SANCTUM_STATEFUL_DOMAINS`, or a missing `supports_credentials`. It is rarely "Sanctum is broken."

## Tokens, only for the other clients

A phone app cannot rely on the SPA cookie. Issue a personal access token and send it as `Authorization: Bearer`.

```php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
}
```

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
        'device_name' => ['required'],
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => 'The provided credentials are incorrect.',
        ]);
    }

    return ['token' => $user->createToken($request->device_name)->plainTextToken];
});
```

Show `plainTextToken` once. Sanctum stores the hash. Revoke a lost device with `$user->tokens()->where('id', $id)->delete()`.

Do not put that token in `localStorage` for the Vue app that shares your domain. Any script that can read the page can read the token. The session cookie can be `HttpOnly`. That is the point of the SPA flow.

A third party that must use OAuth, with its own client id, is [Sanctum or Passport](/laravel-sanctum-vs-passport). The separate Vue app still needs its own URLs. That router is [Vue Router on a Laravel API](/vue-router-laravel-spa), and it does not belong in an Inertia app.

## A test

```php
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('returns the user from a token', function () {
    Sanctum::actingAs(User::factory()->create());

    $this->getJson('/api/user')->assertOk();
});
```

`actingAs` covers the bearer-token guard. For the cookie login, post to `/login` in a feature test and follow with `getJson('/api/user')`. The test client keeps the session.

Private broadcast channels from this SPA need a different auth route than a normal Inertia app. The [Reverb guide](/laravel-reverb-vue) links to that case. Start with login. Add websockets after `/api/user` returns the account you expect.
