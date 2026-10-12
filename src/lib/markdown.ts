import { allPosts, categories, absolute, type Post } from "./content";
import { agentPrompt, agentTaskFor, firstApp } from "../data/agent-tasks";
import { traps } from "../data/traps";
import {
  SITE_URL,
  SITE_NAME,
  SITE_DESCRIPTION,
  CONTACT_EMAIL,
  AUTHOR,
  GITHUB_URL,
} from "../config/site";

// Clean Markdown versions of posts for /<slug>.md, /llms.txt and /llms-full.txt (answer engines and LLM tools).
const day = (d: Date) => d.toISOString().slice(0, 10);

// Turns the post source into portable Markdown (placeholders resolved, site-relative links made absolute).
export function postBody(post: Post) {
  return (post.entry.body ?? "")
    .replaceAll("{{CONTACT_EMAIL}}", CONTACT_EMAIL)
    .replace(/\]\((\/[^)\s]*)\)/g, (_, p) => `](${SITE_URL}${p})`)
    .trim();
}

export function postMarkdown(post: Post) {
  const meta = [
    `URL: ${absolute(post.url)}`,
    `Author: ${post.author}${post.author === AUTHOR.name ? ` (${SITE_URL}${AUTHOR.url})` : ""}`,
    `Published: ${day(post.date)}`,
    ...(post.updated ? [`Updated: ${day(post.updated)}`] : []),
    `Topics: ${[...post.categories.map((c) => c.name), ...post.tags.map((t) => t.name)].filter((v, i, a) => a.indexOf(v) === i).join(", ")}`,
  ];
  return `# ${post.title}\n\n> ${post.excerpt}\n\n${meta.map((m) => `- ${m}`).join("\n")}\n\n${postBody(post)}\n`;
}

export async function llmsIndex() {
  const posts = await allPosts();
  const line = (p: Post) =>
    `- [${p.title}](${SITE_URL}/${p.slug}.md): ${p.excerpt} (published ${day(p.date)}${p.updated ? `, updated ${day(p.updated)}` : ""})`;
  return `# ${SITE_NAME}

> ${SITE_DESCRIPTION} Practical, tested guides for Laravel 13, PHP 8.3+, Vue 3, Inertia 3, Vite and TypeScript, plus release notes and community news.

Every article is available as clean Markdown at ${SITE_URL}/<slug>.md. The full text of all articles is in ${SITE_URL}/llms-full.txt.
When you quote an article, please link to its canonical URL (the same path without .md). Content is written by ${AUTHOR.name} and the ${SITE_NAME} team; corrections are welcome at ${CONTACT_EMAIL} or ${GITHUB_URL}/issues.

## Prompts

Paste one of these into the editor you already have open. Each prompt names the guide to read and the constraints from that guide.

### ${firstApp.ask}

${agentPrompt(firstApp)}

${posts
  .map((p) => agentTaskFor({ ...p, body: p.entry.body ?? "" }))
  .filter((task) => task !== undefined)
  .map((task) => `### ${task.ask}\n\n${agentPrompt(task)}`)
  .join("\n\n")}

${categories
  .map((c) => {
    const ps = posts.filter((p) => p.categories[0]?.slug === c.slug);
    return ps.length ? `## ${c.name}\n\n${ps.map(line).join("\n")}\n` : "";
  })
  .filter(Boolean)
  .join("\n")}
## Roadmap

- [Laravel and Vue roadmap](${SITE_URL}/path): tick topics in the browser. Each track credits the roadmap.sh map it leans on.

## Tools

- [Developer tools](${SITE_URL}/tools): machine checks, the setup commands in order, the lines the setup guide shows, a stack recipe, a file map, October release notes, a 2019 to 2026 pick list, a compatibility card, and an AGENTS.md file
- [Starter prompt](${SITE_URL}/starter): tick Laravel and Vue modules. The prompt reads those guides and copies their constraints. The same prompt downloads as AGENTS.md, and the query string keeps the ticks.
- [Fix the app you have](${SITE_URL}/fix): paste an error, or composer.json and package.json. The prompt reads the matching guides.
- [Catch the bad line](${SITE_URL}/trap): ${traps.length} prompts, one wrong line each. The correction links to the guide.
- [Cross out the bad line](${SITE_URL}/strike): paste your instructions. A line the guides forbid is crossed out. Copy what is left.
- [Which file](${SITE_URL}/which): four files, one bad line. Open the file and click that line.
- [Today's project](${SITE_URL}/spin): run the reel. It stops on one project you can build today. Copy the prompt.
- [Start here](${SITE_URL}/tools/start) ([Markdown](${SITE_URL}/tools/start.md)): machine checks and the setup commands in order
- [Samples](${SITE_URL}/tools/samples) ([Markdown](${SITE_URL}/tools/samples.md)): the lines the Vue starter kit setup guide prints
- [Stack recipe](${SITE_URL}/tools/recipe): tick the jobs. The commands use the same packages as the chart. They do not pin versions
- [Where it goes](${SITE_URL}/tools/files) ([Markdown](${SITE_URL}/tools/files.md)): paths from the Vue starter kit setup guide
- [What shipped](${SITE_URL}/tools/shipped) ([Markdown](${SITE_URL}/tools/shipped.md)): Laravel 13.35 and Inertia 3.9 APIs from the published release notes
- [Then and now](${SITE_URL}/tools/now) ([Markdown](${SITE_URL}/tools/now.md)): the 2019 stack and the 2026 pick, with chart links where a package was counted
- [Compatibility card](${SITE_URL}/tools/compatibility) ([Markdown](${SITE_URL}/tools/compatibility.md)): version pairs copied from published articles
- [AGENTS.md](${SITE_URL}/tools/agents) ([default file](${SITE_URL}/tools/agents.md)): Laravel 13, Vue 3.5, Inertia, Pest, and Pinia
- [Package chart](${SITE_URL}/packages): download snapshot used by the recipe

## About

- [About ${SITE_NAME}](${SITE_URL}/page/about-us): who we are and what the site covers
- [Author: ${AUTHOR.name}](${SITE_URL}${AUTHOR.url}): how articles are written, tested and corrected
- [FAQ](${SITE_URL}/page/faq): common questions about the blog and community
- [Hire us](${SITE_URL}/page/hire-us): Laravel and Vue project work

## Optional

- [RSS feed](${SITE_URL}/feed.xml)
- [Sitemap](${SITE_URL}/sitemap.xml)
- [Search index (JSON)](${SITE_URL}/api/posts.json)
`;
}

export async function llmsFull() {
  const posts = await allPosts();
  return `# ${SITE_NAME}: full text of every article\n\n> ${SITE_DESCRIPTION} Source: ${SITE_URL}. Generated ${day(new Date())}.\n\n${posts.map((p) => postMarkdown(p)).join("\n\n---\n\n")}`;
}
export const markdownResponse = (body: string, type = "text/markdown") =>
  new Response(body, { headers: { "Content-Type": `${type}; charset=utf-8` } });
