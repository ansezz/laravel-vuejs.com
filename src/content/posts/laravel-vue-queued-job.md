---
id: 44
title: "Show a queued Laravel job in Vue"
excerpt: "Dispatch the job, store pending, ready, or failed, and reload that row in the Vue page until the file can be downloaded."
description: "Dispatch a Laravel job, store pending, ready, or failed, and reload that status in a Vue page until the file is ready."
seoTitle: "Show a Laravel queue in Vue"
date: 2026-10-10T09:00:00Z
snippet: "php artisan make:job BuildExport"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---

The page lies if it says "done" at the moment you dispatch. The job is a row in `jobs` until a worker runs it. Store your own status, return that row to Vue, and read it again until it leaves `pending`.

If the status stays `pending`, nothing is processing the `jobs` table. `composer run dev` starts a queue listener with the app server. `php artisan serve` alone does not. Run `php artisan queue:work` in that case. The production worker, and `queue:restart` on deploy, stay in the [deploy guide](/deploy-laravel-vue).

A new Laravel app already ships the jobs migration and `QUEUE_CONNECTION=database`. Run `php artisan migrate` if that table is not in the database yet. Do not create a second jobs migration. This page is also not the posts CRUD. The row is an export. The stack is [Laravel and Vue in 2026](/laravel-vue-in-2026).

## The row and the job

```bash
php artisan make:model Export -m
php artisan make:job BuildExport
```

```php
Schema::create('exports', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('status')->default('pending');
    $table->string('path')->nullable();
    $table->timestamps();
});
```

`status` is `pending`, `ready`, or `failed`. `path` stays null until the file exists. Add `user_id`, `status`, and `path` to the model's `$fillable` array.

```php
use App\Models\Export;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class BuildExport implements ShouldQueue
{
    use Queueable;

    public function __construct(public Export $export) {}

    public function handle(): void
    {
        $path = 'exports/'.$this->export->id.'.csv';
        $stored = Storage::disk('local')->put(
            $path,
            "id,status\n{$this->export->id},ready\n",
        );

        if ($stored !== true) {
            throw new RuntimeException('Export file was not written.');
        }

        $this->export->update([
            'status' => 'ready',
            'path' => $path,
        ]);
    }

    public function failed(?Throwable $exception): void
    {
        $this->export->update(['status' => 'failed']);
    }
}
```

`local` is the private disk. Do not write this file onto the `public` disk, and do not copy it under `storage/app/public`. The download below checks the owner. A URL that anyone can guess is not a check.

## Dispatch, then show the row

```php
public function store(Request $request): RedirectResponse
{
    $export = Export::query()->create([
        'user_id' => $request->user()->id,
        'status' => 'pending',
    ]);

    BuildExport::dispatch($export);

    return to_route('exports.show', $export);
}

public function show(Request $request, Export $export): Response
{
    abort_unless($request->user()->id === $export->user_id, 403);

    return Inertia::render('exports/Show', [
        'export' => $export->only(['id', 'status', 'path']),
    ]);
}

public function download(Request $request, Export $export)
{
    abort_unless(
        $request->user()->id === $export->user_id && $export->status === 'ready',
        403,
    );

    return Storage::disk('local')->download($export->path);
}
```

Register those three routes behind `auth`. Name them `exports.store`, `exports.show`, and `exports.download`. `only` keeps the page props to the fields Vue prints. The path is not a public URL. The download action is the only way out of the private disk.

## The Vue page

Poll while the row is `pending`. `router.reload({ only: ['export'] })` is the same partial reload as the [partial reloads guide](/inertia-partial-reloads). Two seconds is enough to see the change without a websocket. Start the timer in `onMounted` and clear it in `onUnmounted`. Do not read `window` in setup. This page can be server-rendered.

```vue
<script setup lang="ts">
import { onMounted, onUnmounted } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps<{
  export: { id: number; status: string; path: string | null };
}>();

let timer: ReturnType<typeof setInterval> | undefined;

onMounted(() => {
  if (props.export.status !== "pending") {
    return;
  }

  timer = setInterval(() => {
    if (props.export.status !== "pending") {
      clearInterval(timer);
      return;
    }

    router.reload({ only: ["export"] });
  }, 2000);
});

onUnmounted(() => {
  if (timer) {
    clearInterval(timer);
  }
});
</script>

<template>
  <p v-if="export.status === 'pending'">Preparing the file.</p>
  <p v-else-if="export.status === 'failed'">The export failed.</p>
  <a v-else :href="`/exports/${export.id}/download`">Download</a>
</template>
```

The download link is a normal anchor. An Inertia `<Link>` would try to treat the file as a page visit.

When the status should appear without a timer, replace the interval with the broadcast in the [Reverb guide](/laravel-reverb-vue). This page does not install Echo. The row you stored is still the source of truth. The broadcast only tells the browser to reload it.

## A test

```php
use App\Jobs\BuildExport;
use App\Models\Export;
use App\Models\User;
use Illuminate\Support\Facades\Queue;

it('queues an export', function () {
    Queue::fake();

    $this->actingAs(User::factory()->create())
        ->post('/exports')
        ->assertRedirect();

    Queue::assertPushed(BuildExport::class);
});

it('marks the export ready', function () {
    $export = Export::query()->create([
        'user_id' => User::factory()->create()->id,
        'status' => 'pending',
    ]);

    (new BuildExport($export))->handle();

    expect($export->fresh()->status)->toBe('ready');
});
```

`php artisan test --filter=ExportTest`. `Queue::fake()` proves the dispatch. Calling `handle()` proves the file write and the status change without a worker. The download test is the same ownership check as the controller: another user, and a row that is still `pending`, both receive 403.
