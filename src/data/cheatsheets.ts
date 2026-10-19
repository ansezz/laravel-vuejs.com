// Cheat sheets: one source for the /cheatsheets/<slug> pages and the branded PDFs (scripts/cheatsheets-pdf.mjs).
// Every API here was checked against the official docs on the "checked" date (laravel.com/docs/13.x,
// inertiajs.com/docs/v3, vuejs.org). Keep snippets short: they must fit two A4 pages.

export type CheatItem = { title: string; lang: 'php' | 'vue' | 'ts' | 'js' | 'bash'; code: string; note?: string }
export type CheatSection = { title: string; items: CheatItem[] }
export type CheatSheet = {
  slug: string
  title: string
  short: string
  version: string
  description: string
  lead: string
  checked: string
  sources: { label: string; url: string }[]
  sections: CheatSection[]
}

const eloquent: CheatSheet = {
  slug: 'eloquent',
  title: 'Eloquent cheat sheet for Laravel 13',
  short: 'Eloquent',
  version: 'Laravel 13',
  description: 'Laravel 13 Eloquent on one page: queries, relationships, eager loading, scopes, casts, mass assignment, chunking, lazy collections and N+1 fixes.',
  lead: 'Queries, relationships, eager loading, scopes, casts, mass assignment, chunking and the N+1 fixes, in the Laravel 13 syntax (model attributes like #[Fillable] and #[Scope]).',
  checked: '2026-10-15',
  sources: [
    { label: 'Eloquent: Getting Started', url: 'https://laravel.com/docs/13.x/eloquent' },
    { label: 'Eloquent: Relationships', url: 'https://laravel.com/docs/13.x/eloquent-relationships' },
    { label: 'Eloquent: Mutators & Casting', url: 'https://laravel.com/docs/13.x/eloquent-mutators' },
  ],
  sections: [
    {
      title: 'Model setup',
      items: [
        { title: 'Attributes instead of properties', lang: 'php', code: `use Illuminate\\Database\\Eloquent\\Attributes\\{Fillable, Hidden, Table};

#[Table('flights', key: 'flight_id')]
#[Fillable(['name', 'destination'])]
#[Hidden(['secret'])]
class Flight extends Model
{
    use HasFactory, SoftDeletes;
}` },
        { title: 'Strict mode in AppServiceProvider::boot()', lang: 'php', code: `Model::preventLazyLoading(! $this->app->isProduction());
Model::preventSilentlyDiscardingAttributes($this->app->isLocal());
Model::shouldBeStrict(! $this->app->isProduction()); // all of the above + missing attributes` },
      ],
    },
    {
      title: 'Queries',
      items: [
        { title: 'Retrieve', lang: 'php', code: `Flight::find(1);              Flight::findOrFail(1);
Flight::where('active', 1)->orderBy('name')->limit(10)->get();
Flight::firstWhere('number', 'FR 900');
Flight::where('legs', '>', 3)->firstOr(fn () => null);
Flight::where('active', 1)->count();  // sum, max, avg...
Flight::whereIn('id', $ids)->pluck('name', 'id');
Flight::latest()->paginate(15);       // simplePaginate, cursorPaginate` },
        { title: 'Create, update, upsert', lang: 'php', code: `$flight = Flight::create(['name' => 'London to Paris']);
$flight->update(['name' => 'Paris to London']);
Flight::firstOrCreate(['name' => 'X'], ['delayed' => 1]);
Flight::updateOrCreate(['departure' => 'OAK'], ['price' => 99]);
Flight::upsert($rows, uniqueBy: ['departure', 'destination'], update: ['price']);
$flight->isDirty('name'); $flight->wasChanged(); $flight->getOriginal('name');` },
        { title: 'Subquery select and order', lang: 'php', code: `Destination::addSelect(['last_flight' => Flight::select('name')
    ->whereColumn('destination_id', 'destinations.id')
    ->latest('arrived_at')->limit(1),
])->get();` },
      ],
    },
    {
      title: 'Relationships',
      items: [
        { title: 'Define', lang: 'php', code: `public function posts(): HasMany      { return $this->hasMany(Post::class); }
public function user(): BelongsTo     { return $this->belongsTo(User::class); }
public function roles(): BelongsToMany
{
    return $this->belongsToMany(Role::class)->withPivot('active')->withTimestamps();
}
public function latestOrder(): HasOne { return $this->hasOne(Order::class)->latestOfMany(); }
public function comments(): MorphMany { return $this->morphMany(Comment::class, 'commentable'); }` },
        { title: 'Query and write through relations', lang: 'php', code: `$user->posts()->where('active', 1)->get();
Post::has('comments', '>=', 3)->get();
Post::whereHas('comments', fn ($q) => $q->where('approved', true))->get();
Post::whereRelation('comments', 'is_approved', false)->get();
Post::whereBelongsTo($user)->get();
$user->posts()->create(['title' => 'Hi']);
$user->roles()->attach($id); ->detach($id); ->sync([1, 2]); ->toggle([3]);` },
      ],
    },
    {
      title: 'Eager loading',
      items: [
        { title: 'Load up front', lang: 'php', code: `Book::with('author')->get();
Book::with(['author.contacts', 'publisher'])->get();
Book::with('author:id,name')->get();            // include the foreign/primary keys
User::with(['posts' => fn ($q) => $q->latest()])->get();
User::withWhereHas('posts', fn ($q) => $q->where('featured', true))->get();` },
        { title: 'Counts and aggregates without loading', lang: 'php', code: `Post::withCount('comments')->get();        // $post->comments_count
Post::withExists('comments')->get();       // $post->comments_exists
Post::withSum('orders', 'total')->get();   // withAvg, withMin, withMax
$books->load('author'); $books->loadMissing('author'); $post->loadCount('likes');` },
      ],
    },
    {
      title: 'Scopes',
      items: [
        { title: 'Local scope with #[Scope]', lang: 'php', code: `use Illuminate\\Database\\Eloquent\\Attributes\\Scope;

#[Scope]
protected function ofType(Builder $query, string $type): void
{
    $query->where('type', $type);
}

User::ofType('admin')->popular()->get();
User::popular()->orWhere->active()->get();` },
        { title: 'Global scope', lang: 'php', code: `#[ScopedBy([AncientScope::class])]
class User extends Model {}

User::withoutGlobalScope(AncientScope::class)->get();
User::withoutGlobalScopes()->get();` },
      ],
    },
    {
      title: 'Casts and accessors',
      items: [
        { title: 'casts() method', lang: 'php', code: `protected function casts(): array
{
    return [
        'is_admin'   => 'boolean',
        'options'    => AsArrayObject::class,
        'tags'       => AsCollection::class,
        'status'     => OrderStatus::class,   // backed enum
        'paid_at'    => 'immutable_datetime',
        'secret'     => 'encrypted',
        'password'   => 'hashed',
    ];
}` },
        { title: 'Accessor / mutator', lang: 'php', code: `protected function firstName(): Attribute
{
    return Attribute::make(
        get: fn (string $value) => ucfirst($value),
        set: fn (string $value) => strtolower($value),
    );
}` },
      ],
    },
    {
      title: 'Big tables: chunk, lazy, cursor',
      items: [
        { title: 'Pick the right one', lang: 'php', code: `Flight::chunk(200, fn (Collection $flights) => /* ... */);
Flight::where('departed', true)              // updating the filtered column?
    ->chunkById(200, fn ($flights) => $flights->each->update(['departed' => false]));
foreach (Flight::lazy() as $flight) { }      // chunked queries, one stream
Flight::where('departed', true)->lazyById(200)->each->update(['departed' => false]);
foreach (Flight::cursor() as $flight) { }    // one query, no eager loading` },
      ],
    },
    {
      title: 'N+1 fixes',
      items: [
        { title: 'Spot it, then fix it', lang: 'php', code: `// N+1: one query per book
foreach (Book::all() as $book) { echo $book->author->name; }

// Fix: eager load (2 queries)
foreach (Book::with('author')->get() as $book) { echo $book->author->name; }

// Counting? Don't load the rows
Post::withCount('comments')->get();

// Child needs its parent back: chaperone() sets the inverse without a query
public function comments(): HasMany { return $this->hasMany(Comment::class)->chaperone(); }

// Opt in to automatic lazy eager loading (whole app or one collection)
Model::automaticallyEagerLoadRelationships();
$users->withRelationshipAutoloading();`, note: 'Turn on Model::preventLazyLoading() outside production so every N+1 throws in development and tests.' },
      ],
    },
  ],
}

const inertia: CheatSheet = {
  slug: 'inertia',
  title: 'Inertia 3 cheat sheet for Laravel and Vue',
  short: 'Inertia 3',
  version: 'Inertia 3 · Laravel · Vue 3',
  description: 'Inertia 3 with Laravel and Vue: responses, deferred, optional, once and merge props, useForm, Link, partial reloads, shared data, validation errors and SSR.',
  lead: 'Responses, prop types (deferred, optional, once, merge), useForm, Link, partial reloads, shared data, validation errors and SSR with the @inertiajs/vite plugin.',
  checked: '2026-10-15',
  sources: [
    { label: 'Inertia v3 upgrade guide', url: 'https://inertiajs.com/docs/v3/getting-started/upgrade-guide' },
    { label: 'Deferred props', url: 'https://inertiajs.com/docs/v3/data-props/deferred-props' },
    { label: 'Forms', url: 'https://inertiajs.com/docs/v3/the-basics/forms' },
    { label: 'Server-side rendering', url: 'https://inertiajs.com/docs/v3/advanced/server-side-rendering' },
  ],
  sections: [
    {
      title: 'Install and boot',
      items: [
        { title: 'Packages', lang: 'bash', code: `composer require inertiajs/inertia-laravel:^3.0
npm install @inertiajs/vue3@^3.0 @inertiajs/vite@^3.0` },
        { title: 'resources/js/app.ts', lang: 'ts', code: `import { createInertiaApp } from '@inertiajs/vue3'

createInertiaApp({
    pages: './Pages',          // resolved by the @inertiajs/vite plugin
    progress: { color: '#6936D3' },
})` },
      ],
    },
    {
      title: 'Responses',
      items: [
        { title: 'Render a page', lang: 'php', code: `use Inertia\\Inertia;

return Inertia::render('Event/Show', [
    'event' => $event->only('id', 'title', 'start_date'),
]);

Route::inertia('/about', 'About');           // no controller needed
return to_route('users.index');              // redirects after POST/PUT/DELETE` },
        { title: 'Flash data (not kept in history)', lang: 'php', code: `Inertia::flash('message', 'User created.');
return Inertia::flash('newUserId', $user->id)->back();` },
      ],
    },
    {
      title: 'Props: lazy, optional, deferred, once, merge',
      items: [
        { title: 'Prop types', lang: 'php', code: `return Inertia::render('Users/Index', [
    'users'       => fn () => User::all(),                     // lazy: only if requested
    'companies'   => Inertia::optional(fn () => Company::all()), // never on first load
    'roles'       => Inertia::always(Role::all()),               // even on partial reloads
    'permissions' => Inertia::defer(fn () => Permission::all()), // fetched after render
    'teams'       => Inertia::defer(fn () => Team::all(), 'sidebar'), // grouped request
    'plans'       => Inertia::once(fn () => Plan::all()),        // cached across visits
    'posts'       => Inertia::merge(fn () => Post::paginate())->append('data', matchOn: 'id'),
    'chat'        => Inertia::deepMerge($chatData),
]);`, note: 'Inertia::lazy() is gone in v3: use Inertia::optional(). Prop types now work inside nested arrays and closures.' },
        { title: '<Deferred> in Vue', lang: 'vue', code: `<Deferred data="permissions">
  <template #fallback><p>Loading…</p></template>
  <template #default="{ reloading }">
    <PermissionList :items="permissions" :class="{ dim: reloading }" />
  </template>
</Deferred>
<WhenVisible data="comments"><template #fallback>…</template></WhenVisible>` },
      ],
    },
    {
      title: 'Forms with useForm',
      items: [
        { title: 'Submit, errors, progress', lang: 'vue', code: `<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'

const form = useForm({ email: '', password: '', avatar: null as File | null })
const submit = () => form.post('/login', {
  preserveScroll: true,
  onSuccess: () => form.reset('password'),
})
</script>

<template>
  <form @submit.prevent="submit">
    <input v-model="form.email" type="email">
    <p v-if="form.errors.email">{{ form.errors.email }}</p>
    <progress v-if="form.progress" :value="form.progress.percentage" max="100" />
    <button :disabled="form.processing">Log in</button>
    <span v-if="form.recentlySuccessful">Saved.</span>
  </form>
</template>` },
        { title: 'Helpers', lang: 'ts', code: `form.put(url); form.patch(url); form.delete(url); form.submit('post', url)
form.transform(data => ({ ...data, remember: true })).post('/login')
form.reset(); form.reset('field'); form.defaults(); form.cancel()
form.clearErrors('email'); form.setError('email', 'Taken')
form.isDirty; form.hasErrors; form.wasSuccessful
useForm('EditUser:' + user.id, data)   // remembered in history state` },
      ],
    },
    {
      title: 'Links and manual visits',
      items: [
        { title: '<Link>', lang: 'vue', code: `<Link href="/users">Users</Link>
<Link href="/logout" method="post" as="button">Log out</Link>
<Link href="/search" :data="{ query }" preserve-state preserve-scroll>Search</Link>
<Link href="/users" prefetch>Users</Link>
<Link href="/users" :class="{ active: $page.url.startsWith('/users') }">Users</Link>` },
        { title: 'router', lang: 'ts', code: `import { router } from '@inertiajs/vue3'
router.visit('/users', { method: 'get', preserveState: true })
router.post('/users', data, { onHttpException: () => false }) // stay on page
router.cancelAll()                                            // v3: replaces cancel()` },
      ],
    },
    {
      title: 'Partial reloads',
      items: [
        { title: 'Ask for some props only', lang: 'ts', code: `router.reload({ only: ['users'] })
router.reload({ except: ['companies'] })
router.reload({ only: ['auth.notifications'] })     // dot notation in v3
<Link href="/users?active=true" :only="['users']">Active</Link>`, note: 'Wrap expensive props in closures (or Inertia::optional) so a partial reload skips them.' },
      ],
    },
    {
      title: 'Shared data',
      items: [
        { title: 'HandleInertiaRequests middleware', lang: 'php', code: `public function share(Request $request): array
{
    return [
        ...parent::share($request),
        'appName'   => config('app.name'),
        'auth.user' => fn () => $request->user()?->only('id', 'name', 'email'),
    ];
}
public function shareOnce(Request $request): array
{
    return [...parent::shareOnce($request), 'countries' => fn () => Country::all()];
}` },
        { title: 'Read it in Vue', lang: 'ts', code: `import { usePage } from '@inertiajs/vue3'
const page = usePage()
page.props.auth.user   // or $page.props in templates` },
      ],
    },
    {
      title: 'Validation errors',
      items: [
        { title: 'Server validates, client reads errors', lang: 'php', code: `$request->validate(['email' => ['required', 'email']]);  // redirects back with errors
// Inertia puts them in props.errors (first message per field by default)
protected $withAllErrors = true;   // in HandleInertiaRequests: all messages`, note: "Several forms on one page? Name an error bag: form.post('/companies', { errorBag: 'createCompany' }), then read form.errors as usual." },
      ],
    },
    {
      title: 'SSR',
      items: [
        { title: 'With the @inertiajs/vite plugin', lang: 'js', code: `// vite.config.js
plugins: [laravel({ input: ['resources/js/app.ts'], refresh: true }), inertia()]

// package.json: "build": "vite build && vite build --ssr"
// dev: npm run dev (SSR runs in Vite, no Node server)
// prod: npm run build && php artisan inertia:start-ssr`, note: 'Turn SSR off for tests with Inertia::disableSsr(app()->runningUnitTests()). Head tags use data-inertia (was inertia in v2).' },
      ],
    },
  ],
}

const vue: CheatSheet = {
  slug: 'vue-composition-api',
  title: 'Vue 3 Composition API cheat sheet',
  short: 'Vue 3 Composition API',
  version: 'Vue 3.5',
  description: 'Vue 3.5 Composition API on one page: ref, reactive, computed, watch, lifecycle hooks, props and emits, defineModel, composables, provide/inject and script setup.',
  lead: 'ref, reactive, computed and watch, lifecycle hooks, props and emits, defineModel, composables, provide/inject and the script setup macros, for Vue 3.5 with TypeScript.',
  checked: '2026-10-15',
  sources: [
    { label: 'Reactivity API: Core', url: 'https://vuejs.org/api/reactivity-core.html' },
    { label: '<script setup>', url: 'https://vuejs.org/api/sfc-script-setup.html' },
    { label: 'Component v-model', url: 'https://vuejs.org/guide/components/v-model.html' },
    { label: 'Composables', url: 'https://vuejs.org/guide/reusability/composables.html' },
  ],
  sections: [
    {
      title: 'Reactive state',
      items: [
        { title: 'ref and reactive', lang: 'ts', code: `import { ref, reactive, shallowRef, toRefs, readonly } from 'vue'

const count = ref(0)              // count.value in script, {{ count }} in template
const user = ref<User | null>(null)
const state = reactive({ items: [] as Item[], filter: '' })  // objects only
const { filter } = toRefs(state)  // destructure without losing reactivity
const big = shallowRef(hugeList)  // only .value is tracked
const locked = readonly(state)` },
        { title: 'computed', lang: 'ts', code: `const total = computed(() => cart.items.reduce((s, i) => s + i.price, 0))
const fullName = computed({
  get: () => \`\${first.value} \${last.value}\`,
  set: (v) => { [first.value, last.value] = v.split(' ') },
})` },
      ],
    },
    {
      title: 'Watchers',
      items: [
        { title: 'watch and watchEffect', lang: 'ts', code: `watch(query, (now, before) => search(now))
watch([a, () => state.b], ([a, b]) => { /* ... */ })
watch(() => state.filter, run, { immediate: true, once: true })
watch(state, save, { deep: true })            // deep: number limits depth (3.5)
watchEffect(() => console.log(count.value))   // runs now, tracks what it reads

watch(id, async (id) => {
  const controller = new AbortController()
  onWatcherCleanup(() => controller.abort()) // 3.5
  data.value = await fetch(\`/api/\${id}\`, { signal: controller.signal }).then((r) => r.json())
})
const stop = watch(src, cb); stop()          // also pause() / resume()` },
      ],
    },
    {
      title: 'Lifecycle',
      items: [
        { title: 'Hooks', lang: 'ts', code: `onBeforeMount(() => {})
onMounted(() => el.value?.focus())       // DOM is ready
onBeforeUpdate(() => {}); onUpdated(() => {})
onBeforeUnmount(() => {}); onUnmounted(() => clearInterval(timer))
onErrorCaptured((err) => false)          // stop propagation
onActivated(() => {}); onDeactivated(() => {})   // <KeepAlive>
await nextTick()                         // after the DOM updates` },
      ],
    },
    {
      title: 'Props and emits',
      items: [
        { title: 'Typed, with defaults (3.5 destructure)', lang: 'vue', code: `<script setup lang="ts">
const { title, size = 'md' } = defineProps<{
  title: string
  size?: 'sm' | 'md' | 'lg'
}>()

const emit = defineEmits<{
  change: [id: number]
  update: [value: string]
}>()
emit('change', 1)
</script>`, note: 'Destructured props stay reactive in 3.5; pass them to watch as a getter: watch(() => size, ...).' },
      ],
    },
    {
      title: 'defineModel (v-model on components)',
      items: [
        { title: 'Child and parent', lang: 'vue', code: `<!-- Child.vue -->
<script setup lang="ts">
const model = defineModel<string>({ required: true })
const count = defineModel<number>('count', { default: 0 })
const [text, modifiers] = defineModel<string, 'trim'>({
  set: (v) => (modifiers.trim ? v.trim() : v),
})
</script>
<template><input v-model="model"></template>

<!-- Parent.vue -->
<Child v-model="name" v-model:count="n" />` },
      ],
    },
    {
      title: 'script setup macros and template refs',
      items: [
        { title: 'Everything at the top level is in the template', lang: 'vue', code: `<script setup lang="ts">
import { useTemplateRef, useId, useAttrs, useSlots } from 'vue'
defineOptions({ inheritAttrs: false })
const input = useTemplateRef<HTMLInputElement>('input')   // 3.5
const id = useId()                                       // SSR-safe id (3.5)
const slots = defineSlots<{ default(props: { item: Item }): any }>()
defineExpose({ focus: () => input.value?.focus() })
</script>
<template><label :for="id">Name</label><input :id="id" ref="input"></template>` },
      ],
    },
    {
      title: 'Composables',
      items: [
        { title: 'useX: state + logic you can reuse', lang: 'ts', code: `// composables/useFetch.ts
import { ref, toValue, watchEffect, type MaybeRefOrGetter } from 'vue'

export function useFetch<T>(url: MaybeRefOrGetter<string>) {
  const data = ref<T | null>(null)
  const error = ref<unknown>(null)
  watchEffect(async () => {
    data.value = null; error.value = null
    try { data.value = await (await fetch(toValue(url))).json() }
    catch (e) { error.value = e }
  })
  return { data, error }   // return refs, not reactive()
}

const { data } = useFetch<User[]>(() => \`/api/users?page=\${page.value}\`)` },
      ],
    },
    {
      title: 'provide / inject',
      items: [
        { title: 'Typed with an InjectionKey', lang: 'ts', code: `// keys.ts
export const ThemeKey: InjectionKey<Ref<'light' | 'dark'>> = Symbol('theme')

// Ancestor
const theme = ref<'light' | 'dark'>('light')
provide(ThemeKey, theme)                 // provide readonly(theme) to block writes
app.provide('apiBase', '/api')          // app-wide

// Any descendant
const theme = inject(ThemeKey)           // Ref | undefined
const base = inject('apiBase', '/api')  // with default` },
      ],
    },
  ],
}

export const CHEATSHEETS: CheatSheet[] = [eloquent, inertia, vue]
export const cheatsheetBySlug = (slug: string) => CHEATSHEETS.find((s) => s.slug === slug)
export const pdfPath = (slug: string) => `/cheatsheets/pdf/${slug}-cheat-sheet.pdf`
