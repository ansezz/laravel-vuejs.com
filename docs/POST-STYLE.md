# Post style guide

Every article on laravel-vuejs.space follows this structure, so readers always know where to look and every post is
easy to skim, quote and trust. It applies to tutorials, release notes ("release watch") and hidden-gem posts alike.
Automated routines that write posts (release-watch, hidden-gems) must follow this file and run the checklist at the end.

**Voice:** a friendly expert talking to one developer. Second person ("you"), short paragraphs (1–3 sentences), concrete
over clever, the occasional light joke. No fluff ("In today's fast-paced world…"), no hype, no filler intros. If a
sentence doesn't teach, decide or warn, cut it.

**Facts:** every version number, date and API name is checked against an official source (docs, changelog, release
notes, PR) and linked in *Sources*. Code is run before it is published. Say what you tested with.

## Anatomy of a post

| # | Part | How |
|---|---|---|
| 1 | **Hook** | 2–3 lines: the problem, in the reader's words. Why should they care today? |
| 2 | **TL;DR** | `<TLDR>` with 2–4 bullets that answer the post on their own, plus `learn`, `audience` and `tested` (versions you ran the code with) or `applies` (versions it was checked against in the docs, when you didn't run it). |
| 3 | **Reading time** | Automatic (shown in the header). |
| 4 | **Table of contents** | Automatic from H2/H3 (sticky on desktop, collapsible on mobile). Write headings that make sense out of context. |
| 5 | **Body** | Short sections. H2 for steps or ideas, H3 for sub-points. One idea per section. |
| 6 | **Code** | Every block has a language and, when it's a file, `title="path/to/file"`. Use diffs for changes, highlights for the line that matters, `<CodeCompare>` for before/after. |
| 7 | **Callouts** | `<Callout type="tip" \| "pro-tip" \| "gotcha" \| "heads-up">`: at most one every few sections. |
| 8 | **Try it yourself** | `<TryIt>`: one copy-paste snippet or mini exercise the reader can run in 2 minutes. |
| 9 | **Table** | When comparing options, versions or before/after behaviour. |
| 10 | **Visual** | The cover art (automatic) plus a `<Diagram>` when a flow, lifecycle or architecture is easier to see than read. |
| 11 | **Recap** | `## Recap`: 3–5 bullets. |
| 12 | **FAQ** | `## FAQ` + `<FAQ items={[...]} />`, 3–5 real questions (emits FAQPage schema). |
| 13 | **Next steps** | `## Next steps`: 2–4 links (our related posts first, then docs). Related posts are also added automatically. |
| 14 | **Sources** | `## Sources`: official links you used. |
| 15 | **Community CTA** | Automatic (Facebook group, Telegram) after the body. Don't repeat it in the text. |

Release notes ("Laravel 13.35: …", "Inertia 3.9: …") use the same skeleton, with one H2 per notable change
(what it is → before/after code → when to use it), then *Upgrade notes*.

## Building blocks

Posts are MDX (`src/content/posts/<slug>.mdx`). The components below are available in every post **without imports**.
Inside components, leave a blank line around Markdown content so it is parsed as Markdown.

````mdx
<TLDR
  audience="Laravel + Vue developers on Inertia 2"
  learn={['What changed in Inertia 3', 'How to update `app.ts`']}
  tested="Laravel 13.35 · Inertia 3.9 · Vue 3.5"
>

- Point one, the actual answer.
- Point two.

</TLDR>

<Callout type="gotcha" title="optional short title">

Markdown, `code` and [links](https://example.com).

</Callout>

<CodeCompare before="Inertia 2" after="Inertia 3">

```ts title="resources/js/app.ts"
old code
```

```ts title="resources/js/app.ts"
new code
```

</CodeCompare>

<Steps>

1. **Install it.** Explanation.
2. **Configure it.** Explanation.

</Steps>

<TryIt title="Try it yourself">

```bash
php artisan make:model Post -mfs
```

</TryIt>

<Diagram name="inertia-upgrade-flow" alt="Describe the flow in words: A, then B, then C." caption="Optional caption" />

## FAQ

<FAQ items={[
  { q: 'Question in the reader’s words?', a: 'One or two sentences. `code` and [links](/posts) work.' },
]} />
````

**Code block features** (Shiki):

- File name: ```` ```php title="app/Models/Post.php" ````
- Highlight lines by number: ```` ```ts {3,5-7} ````
- Inline notations at the end of a line: `// [!code ++]` (added), `// [!code --]` (removed), `// [!code highlight]`,
  `// [!code focus]`. Use the comment syntax of the language (`# [!code ++]` in bash). Blade comments (`{{-- --}}`) are not recognised: use a ```` ```diff ```` block for Blade changes.
- ```` ```diff ```` for a quick unified diff.
- The copy button skips removed (`--`) lines, so readers always copy the "after" version.

**Figures:** `<Figure src={img} alt="…" caption="…" />` for an illustration that is not a diagram. The image needs an
import at the top of the post (`import img from '../../assets/art/<name>.webp'`); it goes through the same AVIF/WebP pipeline as
the cover art.

**Diagrams:** write Mermaid in `docs/diagrams/<name>.mmd`, run `npm run diagrams` (renders light and dark SVGs into
`public/diagrams/` in the brand palette), commit both SVGs, then use `<Diagram name="<name>" alt="…" />`. The `alt` text
must explain the diagram on its own (it is also what the Markdown copy and screen readers get).

**MDX gotchas:** in prose, `{` and `<` start JavaScript/JSX. Wrap them in backticks (`` `{id}` ``, `` `<Form>` ``) or
write `&lt;` / `&#123;`. No HTML comments (`<!-- -->`); use `{/* comment */}`.

## Template

Copy this into `src/content/posts/<slug>.mdx`. The slug is the URL (`/<slug>`), so never rename a published file.

````mdx
---
id: 12                       # next free number (higher = newer)
title: "Clear, specific headline with the main keyword"
seoTitle: "≤ 60 chars, only if the title is longer"
excerpt: "One or two sentences: what the reader gets. Shown in cards, feeds and as the meta description (≤ 155 chars ideal)."
date: 2026-10-20T07:00:00Z   # future dates stay hidden until then (scheduled publishing)
updated: 2026-10-20T07:00:00Z # optional, when you change facts later
snippet: "the one-line command shown on the cover"
categories: [laravel]        # see src/content/taxonomies.json
tags: [inertia, vuejs]
---

You did X, and now Y happens. Hook in 2–3 lines.

<TLDR audience="…" learn={['…', '…']} tested="Laravel 13.x · PHP 8.4 · Vue 3.5">

- The answer in one line.
- The second thing they must know.

</TLDR>

## The problem

## The fix

<CodeCompare>…</CodeCompare>

<Callout type="tip">…</Callout>

## Going further

<TryIt>…</TryIt>

## Recap

- …

## FAQ

<FAQ items={[{ q: '…', a: '…' }]} />

## Next steps

- [Related post](/slug)

## Sources

- [Official docs](https://…)
````

Also add a cover: generated art at `src/assets/art/<slug>.webp` (1376×768, mint/purple brand style, no people, no
third-party logos) and an OG card with `node scripts/og.mjs http://localhost:4400 public/og <slug>` (see the top of the script).

## Checklist (run before opening the PR)

- [ ] Hook is 2–3 lines and names a real problem.
- [ ] `<TLDR>` answers the post on its own, with `audience`, `learn` and `tested` (or `applies`) filled in. Only say `tested` when you ran it.
- [ ] Every version, date and API name checked against an official source; *Sources* section links them.
- [ ] Code was run; each block has a language, files have `title="…"`, changes use diff notation or `<CodeCompare>`.
- [ ] Headings are short and meaningful out of context (they become the table of contents and search snippets).
- [ ] Paragraphs ≤ 3 sentences; no filler; second person; at least one light moment is fine, a stand-up set is not.
- [ ] At least one `<Callout>`, one `<TryIt>` or copy-paste snippet, and a table where comparing things.
- [ ] A `<Diagram>` if there is a flow or architecture to explain, with a descriptive `alt`.
- [ ] `## Recap`, `## FAQ` with `<FAQ>` (3–5 questions), `## Next steps`, `## Sources`, in that order.
- [ ] `title` ≤ 60 chars or a `seoTitle`; `excerpt` ≤ ~155 chars and specific.
- [ ] Internal links use site paths (`/requirements`), not full URLs; external links go to official sources.
- [ ] `date` is the planned publish time (UTC); scheduled posts stay hidden in production until then.
- [ ] Cover art + OG image added; `npm run build`, `npx astro check` and `npm run check:links` pass.
