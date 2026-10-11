import { SITE_URL } from "../config/site.ts";

export type GuideSample = {
  id: string;
  thing: string;
  path: string;
  lang: "php" | "vue";
  extent: string;
  code: string;
  sourcePath: string;
};

// Lines printed in the published setup guide. Shell commands stay on the
// start sheet. Nothing here is a file the guide did not show.
export const GUIDE_SAMPLES: readonly GuideSample[] = [
  {
    id: "migration",
    thing: "Migration",
    path: "database/migrations/xxxx_xx_xx_create_posts_table.php",
    lang: "php",
    extent:
      "The up() method only. Paste it into the migration artisan created.",
    sourcePath: "/application-setup",
    code: `// database/migrations/xxxx_xx_xx_create_posts_table.php
public function up(): void
{
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('excerpt');
        $table->timestamp('published_at')->nullable();
        $table->timestamps();
    });
}`,
  },
  {
    id: "model",
    thing: "Model",
    path: "app/Models/Post.php",
    lang: "php",
    extent: "The class body only. Keep the imports artisan generated.",
    sourcePath: "/application-setup",
    code: `// app/Models/Post.php
class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'excerpt', 'published_at'];

    protected function casts(): array
    {
        return ['published_at' => 'datetime'];
    }
}`,
  },
  {
    id: "factory",
    thing: "Factory",
    path: "database/factories/PostFactory.php",
    lang: "php",
    extent: "The definition() method only.",
    sourcePath: "/application-setup",
    code: `// database/factories/PostFactory.php
public function definition(): array
{
    $title = fake()->sentence();

    return [
        'title' => $title,
        'slug' => str($title)->slug(),
        'excerpt' => fake()->paragraph(),
        'published_at' => now(),
    ];
}`,
  },
  {
    id: "seeder",
    thing: "Seeder",
    path: "database/seeders/PostSeeder.php",
    lang: "php",
    extent: "The run() method only. It creates 12 posts.",
    sourcePath: "/application-setup",
    code: `// database/seeders/PostSeeder.php
public function run(): void
{
    Post::factory()->count(12)->create();
}`,
  },
  {
    id: "controller",
    thing: "Controller",
    path: "app/Http/Controllers/PostController.php",
    lang: "php",
    extent:
      "The class and the three use lines the guide shows. The Controller import is not in the sample.",
    sourcePath: "/application-setup",
    code: `// app/Http/Controllers/PostController.php
use App\\Models\\Post;
use Inertia\\Inertia;
use Inertia\\Response;

class PostController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('posts/Index', [
            'posts' => Post::query()
                ->latest('published_at')
                ->get(['id', 'title', 'slug', 'excerpt', 'published_at']),
        ]);
    }
}`,
  },
  {
    id: "route",
    thing: "Route",
    path: "routes/web.php",
    lang: "php",
    extent:
      "Lines to add. Leave the routes the starter kit already registered. GET /posts, named posts.index. No API route.",
    sourcePath: "/application-setup",
    code: `// routes/web.php
use App\\Http\\Controllers\\PostController;

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');`,
  },
  {
    id: "page",
    thing: "Vue page",
    path: "resources/js/pages/posts/Index.vue",
    lang: "vue",
    extent:
      "The full component the guide shows. The folder is pages, lowercase. The Inertia component name is posts/Index.",
    sourcePath: "/application-setup",
    code: `<!-- resources/js/pages/posts/Index.vue -->
<script setup lang="ts">
import { Head } from '@inertiajs/vue3'

interface Post {
  id: number
  title: string
  slug: string
  excerpt: string
  published_at: string
}

defineProps<{ posts: Post[] }>()
</script>

<template>
  <Head title="Posts" />

  <main class="mx-auto max-w-3xl space-y-6 p-8">
    <h1 class="text-3xl font-semibold">Posts</h1>

    <article v-for="post in posts" :key="post.id" class="rounded-xl border p-6">
      <h2 class="text-xl font-medium">{{ post.title }}</h2>
      <p class="mt-2 text-muted-foreground">{{ post.excerpt }}</p>
    </article>
  </main>
</template>`,
  },
  {
    id: "test",
    thing: "Feature test",
    path: "tests/Feature/PostsTest.php",
    lang: "php",
    extent:
      "The example the guide shows. It has no opening PHP tag. Pest. assertInertia checks the component posts/Index.",
    sourcePath: "/application-setup",
    code: `// tests/Feature/PostsTest.php
use App\\Models\\Post;

it('lists posts', function () {
    Post::factory()->create(['title' => 'Hello Laravel 13']);

    $this->get('/posts')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('posts/Index')
            ->has('posts', 1)
        );
});`,
  },
];

export function samplesMarkdown(): string {
  const lines = [
    "# Lines the setup guide shows",
    "",
    `Copied from ${SITE_URL}/application-setup. A method or a class body is not a whole file. Do not replace a generated file with a partial sample. The Vue page is the full component the guide shows.`,
    "",
  ];
  for (const sample of GUIDE_SAMPLES) {
    lines.push(
      `## ${sample.thing}`,
      "",
      sample.extent,
      "",
      `Path: \`${sample.path}\``,
      "",
      "```" + sample.lang,
      sample.code,
      "```",
      "",
    );
  }
  lines.push(
    "Artisan already writes the surrounding class, the namespace, and the imports. Paste a method into that file. Paste the Vue sample as the whole page.",
    "The list is an Inertia page on a web route. The setup guide does not add an API route for it.",
    `Setup guide: ${SITE_URL}/application-setup`,
    `HTML samples: ${SITE_URL}/tools/samples`,
  );
  return lines.join("\n");
}
