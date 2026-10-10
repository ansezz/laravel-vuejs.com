---
id: 16
title: "Laravel and Vue CRUD with Inertia"
excerpt: "Create, edit, and delete posts from a Vue page, with validation errors, search, and pagination. Continues the official Vue starter kit."
description: "A Laravel 13 and Vue 3 CRUD with Inertia: controller actions, the Form component, validation errors, search, and pagination."
seoTitle: "Laravel Vue CRUD with Inertia"
date: 2026-10-10T04:50:00Z
snippet: "php artisan make:controller PostController"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---

The usual "Laravel Vue CRUD" tutorial still installs Breeze on Laravel 10 and dumps every row into the page. This one continues the [setup guide](/application-setup). You already have a `Post` model, a factory, and an index page. Here you add create, update, delete, search, and pages of ten.

The stack is Laravel 13, Inertia 3, and Vue 3 with `<script setup>`. Routing stays in Laravel. Do not add Vue Router for these screens. If you are still choosing an architecture, read [Inertia, a SPA, or Nuxt](/laravel-vue-in-2026) first.

## Routes

```php
// routes/web.php
use App\Http\Controllers\PostController;

Route::resource('posts', PostController::class)->except(['show']);
```

`except(['show'])` keeps the list, the form, and the destroy action. Add `show` later with route model binding on `slug` if the public URL needs it.

## The controller

```php
// app/Http/Controllers/PostController.php
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->string('search')->trim()->toString();

        return Inertia::render('posts/Index', [
            'filters' => ['search' => $search],
            'posts' => Post::query()
                ->when($search !== '', fn ($query) => $query->where('title', 'like', "%{$search}%"))
                ->latest('published_at')
                ->paginate(10)
                ->withQueryString(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('posts/Form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['required', 'string'],
        ]);

        Post::create([
            ...$data,
            'slug' => str($data['title'])->slug(),
            'published_at' => now(),
        ]);

        return to_route('posts.index');
    }

    public function edit(Post $post): Response
    {
        return Inertia::render('posts/Form', [
            'post' => $post->only(['id', 'title', 'excerpt']),
        ]);
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['required', 'string'],
        ]);

        $post->update([
            ...$data,
            'slug' => str($data['title'])->slug(),
        ]);

        return to_route('posts.index');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return to_route('posts.index');
    }
}
```

`paginate(10)` returns the current page, the total, and `prev_page_url` / `next_page_url`. `withQueryString()` keeps `?search=` on those links. Send the search string back as `filters` so the input does not forget it on the next visit.

The model from the setup guide already lists `title`, `slug`, `excerpt`, and `published_at` as fillable. Keep it that way. Do not pass `$request->all()` into `create()`.

## The list page

```vue
<!-- resources/js/pages/posts/Index.vue -->
<script setup lang="ts">
import { ref, watch } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";

interface Post {
  id: number;
  title: string;
  excerpt: string;
}

interface Page {
  data: Post[];
  current_page: number;
  last_page: number;
  prev_page_url: string | null;
  next_page_url: string | null;
}

const props = defineProps<{
  posts: Page;
  filters: { search: string };
}>();

const search = ref(props.filters.search);
let timer = 0;

watch(search, (value) => {
  window.clearTimeout(timer);
  timer = window.setTimeout(() => {
    router.get(
      "/posts",
      { search: value },
      {
        preserveState: true,
        preserveScroll: true,
        replace: true,
      },
    );
  }, 250);
});
</script>

<template>
  <Head title="Posts" />

  <main class="mx-auto max-w-3xl space-y-6 p-8">
    <div class="flex items-center justify-between gap-4">
      <h1 class="text-3xl font-semibold">Posts</h1>
      <Link href="/posts/create" class="underline">New post</Link>
    </div>

    <input
      v-model="search"
      type="search"
      placeholder="Search titles"
      class="w-full border px-3 py-2"
    />

    <article
      v-for="post in posts.data"
      :key="post.id"
      class="rounded-xl border p-6"
    >
      <h2 class="text-xl font-medium">{{ post.title }}</h2>
      <p class="mt-2">{{ post.excerpt }}</p>
      <div class="mt-4 flex gap-4">
        <Link :href="`/posts/${post.id}/edit`" class="underline">Edit</Link>
        <Link
          :href="`/posts/${post.id}`"
          method="delete"
          as="button"
          class="underline"
          >Delete</Link
        >
      </div>
    </article>

    <nav class="flex gap-4">
      <Link v-if="posts.prev_page_url" :href="posts.prev_page_url"
        >Previous</Link
      >
      <span>Page {{ posts.current_page }} of {{ posts.last_page }}</span>
      <Link v-if="posts.next_page_url" :href="posts.next_page_url">Next</Link>
    </nav>
  </main>
</template>
```

The index from the setup guide used `posts` as an array. Pagination wraps that array in `data`. Update the `v-for` or the page will render nothing.

`router.get` writes the search into the URL. That is what you want: a shared link opens the same filter, and the back button returns to the previous term. `preserveState` keeps the input focused while Inertia replaces the list.

## The form

Inertia 3's `<Form>` component posts like a normal form and puts validation errors in the slot. You do not need `v-model` on each field.

```vue
<!-- resources/js/pages/posts/Form.vue -->
<script setup lang="ts">
import { Form, Head, Link } from "@inertiajs/vue3";

defineProps<{
  post?: { id: number; title: string; excerpt: string };
}>();
</script>

<template>
  <Head :title="post ? 'Edit post' : 'New post'" />

  <main class="mx-auto max-w-3xl space-y-6 p-8">
    <Form
      :action="post ? `/posts/${post.id}` : '/posts'"
      :method="post ? 'put' : 'post'"
      #default="{ errors, processing }"
      class="space-y-4"
    >
      <div>
        <label for="title">Title</label>
        <input
          id="title"
          name="title"
          :defaultValue="post?.title ?? ''"
          class="w-full border px-3 py-2"
        />
        <p v-if="errors.title">{{ errors.title }}</p>
      </div>

      <div>
        <label for="excerpt">Excerpt</label>
        <textarea
          id="excerpt"
          name="excerpt"
          :defaultValue="post?.excerpt ?? ''"
          class="w-full border px-3 py-2"
        />
        <p v-if="errors.excerpt">{{ errors.excerpt }}</p>
      </div>

      <button :disabled="processing" class="border px-4 py-2">
        {{ processing ? "Saving…" : "Save" }}
      </button>
      <Link href="/posts" class="ml-4 underline">Cancel</Link>
    </Form>
  </main>
</template>
```

A failed `validate()` call comes back as a 422 with the same page. `errors.title` is the first message for that field. Fix the copy in a `FormRequest` later if you want custom sentences. The rules above are enough to prove the round trip.

`useForm` is still there for screens that build the payload in code. The `<Form>` component is the one to reach for when the fields are inputs. File fields are covered in the [upload guide](/laravel-vue-file-upload).

## A test

```php
// tests/Feature/PostsTest.php
use App\Models\Post;

it('creates a post', function () {
    $this->post('/posts', [
        'title' => 'Hello Laravel 13',
        'excerpt' => 'A short excerpt.',
    ])->assertRedirect('/posts');

    $this->assertDatabaseHas('posts', ['title' => 'Hello Laravel 13']);
});

it('rejects an empty title', function () {
    $this->post('/posts', ['title' => '', 'excerpt' => 'Body'])
        ->assertSessionHasErrors('title');
});

it('searches by title', function () {
    Post::factory()->create(['title' => 'Inertia forms']);
    Post::factory()->create(['title' => 'Something else']);

    $this->get('/posts?search=Inertia')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('posts.data', 1)
        );
});
```

```bash
php artisan test --filter=PostsTest
```

The starter kit uses Pest. These tests hit the web routes, so they use the session and the CSRF middleware that a browser would use. Feature tests do not need a CSRF token.

## What this page does not do

It does not tell the reader the save worked. That sentence is a [flash](/laravel-vue-flash). It does not upload a file, broadcast a "post created" event, or render the list on the server for Google. Those are the [upload](/laravel-vue-file-upload), [Reverb](/laravel-reverb-vue), and [deploy](/deploy-laravel-vue) guides. Other paginators, live validation, and who may edit a row are the [pagination](/laravel-vue-pagination), [Precognition](/laravel-precognition-vue), and [permissions](/laravel-vue-permissions) guides. Keep this controller boring. That is the page people can finish in an afternoon.
