import { SITE_URL } from "../config/site.ts";

export type StartCheck = {
  id: string;
  check: string;
  command: string;
  pass: string;
  sourcePath: string;
};

// Shell checks printed in the published requirements article. No version
// beyond what that article states is added here.
export const START_CHECKS: readonly StartCheck[] = [
  {
    id: "php",
    check: "PHP",
    command: "php -v",
    pass: "PHP 8.3 to 8.5. Laravel 13 was released on March 17, 2026.",
    sourcePath: "/requirements",
  },
  {
    id: "composer",
    check: "Composer",
    command: "composer -V",
    pass: "Composer 2.",
    sourcePath: "/requirements",
  },
  {
    id: "extensions",
    check: "Extensions",
    command: "php -m",
    pass: "Ctype, cURL, DOM, Fileinfo, Filter, Hash, Mbstring, OpenSSL, PCRE, PDO, Session, Tokenizer, and XML.",
    sourcePath: "/requirements",
  },
  {
    id: "node",
    check: "Node.js",
    command: "node -v",
    pass: "v22.12+ or v24.",
    sourcePath: "/requirements",
  },
  {
    id: "npm",
    check: "npm",
    command: "npm -v",
    pass: "The article does not pin an npm version. npm, pnpm, or Bun are named.",
    sourcePath: "/requirements",
  },
];

export type StartStep = {
  id: string;
  command: string;
  rule: string;
  sourcePath: string;
};

// Commands in the order the published setup guide runs them. The installer
// prompts are answers, not flags. An empty command is a browser step.
export const START_STEPS: readonly StartStep[] = [
  {
    id: "installer",
    command: "composer global require laravel/installer",
    rule: "Composer's global bin directory must be on PATH so the laravel command is available.",
    sourcePath: "/application-setup",
  },
  {
    id: "create",
    command: "laravel new blog",
    rule: "Pick starter kit Vue, Laravel's built-in authentication, and Pest. The installer then installs Composer and npm dependencies, creates a SQLite database, and runs the first migrations. The Vue kit includes Inertia 3, Vue 3, TypeScript, Tailwind CSS 4, and shadcn-vue.",
    sourcePath: "/application-setup",
  },
  {
    id: "enter",
    command: "cd blog",
    rule: "Run the rest of these commands from the new app.",
    sourcePath: "/application-setup",
  },
  {
    id: "dev",
    command: "composer run dev",
    rule: "Starts the PHP server, the queue worker, the log viewer, and Vite. The app is at http://localhost:8000. Log in and Register work.",
    sourcePath: "/application-setup",
  },
  {
    id: "model",
    command: "php artisan make:model Post -mfs",
    rule: "Also creates the migration, factory, and seeder. Fill those in before the next command. The migration has title, a unique slug, excerpt, and a nullable published_at.",
    sourcePath: "/application-setup",
  },
  {
    id: "migrate",
    command: "php artisan migrate",
    rule: "Run this after the migration file is filled in.",
    sourcePath: "/application-setup",
  },
  {
    id: "seed",
    command: "php artisan db:seed --class=PostSeeder",
    rule: "The seeder creates 12 posts from the factory.",
    sourcePath: "/application-setup",
  },
  {
    id: "controller",
    command: "php artisan make:controller PostController",
    rule: "Then render posts/Index with Inertia and add GET /posts named posts.index in routes/web.php. The guide adds no API route for this list. The Vue page is resources/js/pages/posts/Index.vue.",
    sourcePath: "/application-setup",
  },
  {
    id: "open",
    command: "",
    rule: "After that page exists, open http://localhost:8000/posts. Vite reloads as you edit. Laravel serves the data.",
    sourcePath: "/application-setup",
  },
  {
    id: "test",
    command: "php artisan test",
    rule: "After tests/Feature/PostsTest.php exists. Pest. assertInertia checks the component posts/Index.",
    sourcePath: "/application-setup",
  },
  {
    id: "build",
    command: "npm run build",
    rule: "Production front-end build.",
    sourcePath: "/application-setup",
  },
  {
    id: "ssr",
    command: "npm run build:ssr",
    rule: "npm run dev already server-renders. Build the SSR bundle with this command when you deploy.",
    sourcePath: "/application-setup",
  },
];

export function startMarkdown(): string {
  const lines = [
    "# Start a Laravel and Vue app",
    "",
    `Machine checks copied from ${SITE_URL}/requirements. Commands copied in order from ${SITE_URL}/application-setup. The guide does not pass flags to laravel new. Answer the installer.`,
    "",
    "## Check the machine",
    "",
    "| Check | Command | Pass | Source |",
    "| --- | --- | --- | --- |",
  ];
  for (const row of START_CHECKS) {
    lines.push(
      `| ${row.check} | \`${row.command}\` | ${row.pass} | [Requirements](${SITE_URL}/requirements) |`,
    );
  }
  lines.push(
    "",
    "New apps use SQLite. MySQL, MariaDB, PostgreSQL, and SQL Server are supported for production.",
    "Herd (https://herd.laravel.com), php.new (https://php.new), or Sail (https://laravel.com/docs/sail) can install the PHP side.",
    "The front end the article names is Vue 3.5, Vite 8, and Inertia 3. Vue 3.6 Vapor mode was a release candidate as of October 2026, not the default. Nuxt 4 is the standalone Vue front end. Nuxt 3 reached end of life on July 31, 2026.",
    "Tailwind CSS 4 ships with the Vue starter kit and is not in the download chart.",
    "",
    "## Commands in order",
    "",
    "| Step | Command | Rule | Source |",
    "| --- | --- | --- | --- |",
  );
  START_STEPS.forEach((row, index) => {
    const commandCell = row.command
      ? `\`${row.command}\``
      : "Open in the browser";
    lines.push(
      `| ${index + 1} | ${commandCell} | ${row.rule} | [Setup guide](${SITE_URL}/application-setup) |`,
    );
  });
  lines.push(
    "",
    "Do not start a new app with composer require laravel/framework. Use laravel new blog and answer the installer.",
    "The guide's later edits are a show page with route model binding on slug, and Inertia forms with useForm. It does not give commands for those.",
    `Requirements article: ${SITE_URL}/requirements`,
    `Setup guide: ${SITE_URL}/application-setup`,
    `HTML tables: ${SITE_URL}/tools/start`,
  );
  return lines.join("\n");
}
