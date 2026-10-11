export type AgentTask = {
  slug: string;
  ask: string;
  intent: string;
  command: string;
  files: string[];
  steps: string[];
  avoid: string[];
};

export const agentTasks: AgentTask[] = [
  {
    slug: "laravel-vue-file-upload",
    ask: "Upload a file",
    intent: "Add a cover image on the existing post form.",
    command: "php artisan storage:link",
    files: [
      "a migration that adds cover_path",
      "Post $fillable",
      "update() on the post controller",
      "the Vue page that already edits the post",
    ],
    steps: [
      "Post the form with method post and a hidden _method of put.",
      "Validate cover as an image, max 2048 kilobytes.",
      "Store it with store('covers', 'public') and save the path.",
    ],
    avoid: [
      "Do not send the file with PUT, PATCH, or DELETE.",
      "Do not run storage:link on Laravel Cloud.",
      "Do not write the file bytes into the database.",
    ],
  },
  {
    slug: "laravel-vue-pagination",
    ask: "Paginate a list",
    intent:
      "Page a Laravel list in Vue with the links that method actually returns.",
    command: "orderBy('id')->cursorPaginate()",
    files: ["the controller query", "resources/js/pages/posts/Index.vue"],
    steps: [
      "Use paginate or simplePaginate when offset pages can skip or repeat.",
      "Use cursorPaginate only when the order column is unique. Order by id.",
    ],
    avoid: [
      "Do not use a duplicated published_at as the cursor bound.",
      "Do not read last_page or total off simplePaginate.",
    ],
  },
  {
    slug: "deploy-laravel-vue",
    ask: "Deploy the app",
    intent:
      "Ship the Vue starter kit without leaving the dev server file on the machine.",
    command: "npm run build:ssr",
    files: [
      "the Cloud or Forge build command",
      "the deploy command",
      "bootstrap/ssr when pages need server HTML",
    ],
    steps: [
      "On Laravel Cloud, the deploy command is php artisan migrate --force.",
      "Use npm run build:ssr when those pages need server HTML.",
      "On a VPS, run storage:link once for the public disk and supervise the queue.",
    ],
    avoid: [
      "Do not put storage:link or queue:restart in the Cloud deploy command.",
      "Do not deploy public/hot.",
      "Do not run composer dev:ssr. The kit has no such script.",
    ],
  },
  {
    slug: "laravel-sanctum-vue-spa",
    ask: "Log in from a Vue SPA",
    intent:
      "Log the SPA in with the session cookie, then read the current user.",
    command: "php artisan install:api",
    files: [
      "bootstrap/app.php",
      "SANCTUM_STATEFUL_DOMAINS",
      "config/cors.php",
      "resources/js/api.ts",
    ],
    steps: [
      "POST /login on the web routes. The response is 204, with no body.",
      "Then call currentUser() on the credentialed api client.",
    ],
    avoid: [
      'Do not call axios.get("/api/user"). That request does not send the session cookie.',
      "Do not treat a missing SANCTUM_STATEFUL_DOMAINS as a 419. That case is 401.",
      "A 419 is CSRF: check SESSION_DOMAIN and supports_credentials.",
    ],
  },
];

const editorial = new Set([
  "roadmap",
  "who-we-are",
  "laravel-vuejs-open-source-cms",
]);

/** Rich prompts stay as written. Every other practical guide gets the same block from its own excerpt. */
export function agentTaskFor(post: {
  slug: string;
  title: string;
  excerpt: string;
  tags: { slug: string }[];
}): AgentTask | undefined {
  const written = agentTasks.find((task) => task.slug === post.slug);
  if (written) return written;
  if (editorial.has(post.slug)) return undefined;
  if (
    post.tags.some((tag) =>
      ["community", "roadmap", "open-source"].includes(tag.slug),
    )
  ) {
    return undefined;
  }
  return {
    slug: post.slug,
    ask: post.title,
    intent: post.excerpt,
    command: "",
    files: [],
    steps: [],
    avoid: [],
  };
}
