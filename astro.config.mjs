import { defineConfig } from 'astro/config'
import mdx from '@astrojs/mdx'
import { transformerNotationDiff, transformerNotationHighlight, transformerMetaHighlight, transformerNotationFocus } from '@shikijs/transformers'
import { rehypeHeadingIds } from '@astrojs/markdown-remark'
import rehypePost, { transformerFrame } from './src/lib/markdown/rehype-post.mjs'

export default defineConfig({
  site: 'https://laravel-vuejs.space',
  output: 'static',
  // Pages are served without a trailing slash (wrangler.jsonc: drop-trailing-slash)
  trailingSlash: 'ignore',
  build: { format: 'directory', assets: '_astro', inlineStylesheets: 'always' },
  prefetch: { prefetchAll: true, defaultStrategy: 'hover' },
  integrations: [mdx()],
  markdown: {
    shikiConfig: {
      themes: { light: 'github-light-high-contrast', dark: 'github-dark-dimmed' },
      defaultColor: false,
      wrap: false,
      // Code blocks in posts: title="file.ts", {2,4-6} line highlights, and // [!code ++] / [!code --] / [!code highlight] / [!code focus] notations.
      transformers: [transformerFrame(), transformerMetaHighlight(), transformerNotationHighlight(), transformerNotationDiff(), transformerNotationFocus()],
    },
    // rehypeHeadingIds first so rehypePost can add anchors to the generated ids (same ids Astro reports as headings).
    rehypePlugins: [rehypeHeadingIds, rehypePost],
  },
})
