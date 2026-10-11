---
id: 140
title: "Expose a Vite variable without exposing a secret"
seoTitle: "Vite env vars on a Vue page"
excerpt: "Only VITE_ keys reach import.meta.env. Restart the dev server after you change one. Secrets stay unprefixed."
description: "Only VITE_ keys reach import.meta.env. Restart the dev server after you change one. Secrets stay unprefixed."
date: 2026-10-11T11:27:00Z
snippet: "import.meta.env.VITE_APP_NAME"
categories: [laravel, vuejs]
tags: [laravel, vuejs, tooling]
---
People searching "VITE env Laravel" add `VITE_OPENAI_API_KEY` and then the key is in the built JavaScript. The [Vite guide](/laravel-vite-vue) covers the dev server. This page is the prefix.

A key the browser may see:

```ini
VITE_APP_NAME="${APP_NAME}"
```

```ts
const name = import.meta.env.VITE_APP_NAME;
```

Anything without the prefix is invisible to Vite. That includes `APP_KEY` and provider keys. The [AI SDK guide](/laravel-ai-sdk-vue) keeps those on the server.

Change `.env`, then stop and start `npm run dev`. Vite reads the file at startup. A running dev server keeps the old value, and people think the binding is broken.

Do not print `import.meta.env` on a production page to debug. It lists every public variable. Do not move a secret into `VITE_` for one afternoon and leave it.
