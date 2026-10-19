# Contributing

Bug reports, corrections and new articles are welcome. This page is the short version; the README has the setup and the
layout, and `docs/POST-STYLE.md` has everything about writing a post.

## Reporting a problem

- Wrong fact, outdated version or broken code in an article: open an issue with the article URL and what you ran. We fix
  articles in place and note the change in `updated`.
- Site bug (layout, search, forms): open an issue with the page, browser and a screenshot if it helps.
- Security: see `SECURITY.md`. Please don't open a public issue.

## Sending a pull request

1. Fork, then branch from `master`.
2. `npm install`, make your change, and run the same checks CI runs:

   ```bash
   npm run check && npm run check:worker && npm run build && npm run check:links
   ```

   For changes under `src/data/`, also run `npm run check:packages` and `npm run check:tools`.
3. Keep the change focused. One article, one fix or one feature per PR.
4. Open the PR against `master`. CI builds it and Cloudflare posts a preview URL on the PR.

## Writing an article

Follow `docs/POST-STYLE.md`: the anatomy of a post, the MDX components, the template and the checklist at the end. The short
rules:

- **Run the code.** Say what you tested with in the `tested` field of `<TLDR>`, or use `applies` when you checked a release
  against its notes and PRs without running it.
- **Link every fact** to an official source in *Sources*.
- **Pick the date** (UTC) the post should go live. Future-dated posts are hidden in production until then and published by
  the daily workflow, so it is fine to merge early.
- Add the cover art, the OG card and, when there is a flow to show, a diagram. The README's "Writing a post" section has
  the commands.

## After a merge

Pushes to `master` are deployed by Cloudflare Workers Builds. The `Post-deploy check` workflow waits for the deploy and
verifies the live site (key pages, headers, feeds, sitemap, the newest post and its Markdown twin). If it goes red, the
deploy needs a look before anything else.

## License

By contributing you agree that your contribution is released under the MIT license, like the rest of the project.
