// Runs after `astro build`: turns each built post page into clean Markdown at dist/<slug>.md and concatenates them into
// dist/llms-full.txt. Working from the rendered HTML means MDX components (TL;DR, callouts, code compare, FAQ, steps,
// diagrams) come out as portable Markdown, and scheduled posts that are not in the build are never exported.
import fs from 'node:fs'
import TurndownService from 'turndown'
import { gfm } from 'turndown-plugin-gfm'

const SITE = 'https://laravel-vuejs.space'
const AUTHOR = { name: 'Anass Ez-zouaine', url: '/author/anass-ez-zouaine' }
const dist = new URL('../dist/', import.meta.url)
const posts = JSON.parse(fs.readFileSync(new URL('api/posts.json', dist), 'utf8'))
const day = s => s.slice(0, 10)

const td = new TurndownService({ headingStyle: 'atx', codeBlockStyle: 'fenced', bulletListMarker: '-', emDelimiter: '_' })
td.use(gfm)
td.remove(['script', 'style', 'button', 'svg'])
td.addRule('anchors', { filter: n => n.nodeName === 'A' && n.classList?.contains('anchor'), replacement: () => '' })
td.addRule('darkDiagram', { filter: n => n.nodeName === 'IMG' && n.classList?.contains('only-dark'), replacement: () => '' })
td.addRule('srOnly', { filter: n => n.classList?.contains('sr-only'), replacement: () => '' })
td.addRule('picture', { filter: 'picture', replacement: (_, n) => { const img = n.querySelector('img'); return img?.getAttribute('alt') ? `![${img.getAttribute('alt')}](${SITE}${img.getAttribute('src')})` : '' } })
td.addRule('diagram', { filter: n => n.nodeName === 'FIGURE' && n.classList?.contains('diagram'), replacement: (_, n) => {
  const img = n.querySelector('img.only-light'); const cap = n.querySelector('figcaption')?.textContent?.trim()
  return `\n\n![${img?.getAttribute('alt') ?? 'Diagram'}](${SITE}${img?.getAttribute('src')})${cap ? `\n_${cap}_` : ''}\n\n`
} })
td.addRule('codeFrame', { filter: n => n.nodeName === 'DIV' && n.classList?.contains('code'), replacement: (_, n) => {
  const pre = n.querySelector('pre'); const lang = pre?.getAttribute('data-language') ?? ''
  const file = n.querySelector('.code-file')?.textContent?.trim()
  const lines = pre ? Array.from(pre.querySelectorAll('.line')) : []
  const hasDiff = lines.some(l => l.classList.contains('diff'))
  const body = lines.length ? lines.map(l => (hasDiff ? (l.classList.contains('add') ? '+ ' : l.classList.contains('remove') ? '- ' : '  ') : '') + l.textContent).join('\n') : pre?.textContent ?? ''
  return `\n\n${file ? `\`${file}\`\n` : ''}\`\`\`${hasDiff ? 'diff' : lang === 'plaintext' ? '' : lang}\n${body.replace(/\n+$/, '')}\n\`\`\`\n\n`
} })
td.addRule('codeCompare', { filter: n => n.nodeName === 'DIV' && n.classList?.contains('code-compare'), replacement: (content, n) => {
  const [a, b] = (n.getAttribute('style') ?? '').match(/'[^']*'/g) ?? ["'Before'", "'After'"]
  const parts = content.split(/(?=\n\n(?:`[^`\n]+`\n)?```)/).filter(s => s.trim())
  return parts.length === 2 ? `\n\n**${a.slice(1, -1)}:**${parts[0]}\n\n**${b.slice(1, -1)}:**${parts[1]}\n\n` : content
} })
const quote = s => s.trim().split('\n').map(l => `> ${l}`.trimEnd()).join('\n')
td.addRule('callout', { filter: n => (n.nodeName === 'ASIDE' || n.nodeName === 'DIV') && n.classList?.contains('callout'), replacement: content => `\n\n${quote(content)}\n\n` })
td.addRule('tldr', { filter: n => n.nodeName === 'SECTION' && (n.classList?.contains('tldr') || n.classList?.contains('try-it')), replacement: content => `\n\n${quote(content)}\n\n` })
td.addRule('faq', { filter: 'details', replacement: (_, n) => `\n\n**Q: ${n.querySelector('summary')?.textContent?.trim()}**\n\n${td.turndown(n.querySelector('.answer')?.innerHTML ?? '')}\n\n` })
td.addRule('absLinks', { filter: n => n.nodeName === 'A' && n.getAttribute('href')?.startsWith('/'), replacement: (c, n) => `[${c}](${SITE}${n.getAttribute('href')})` })

const docs = []
for (const p of posts) {
  const html = fs.readFileSync(new URL(`${p.slug}/index.html`, dist), 'utf8')
  const start = html.indexOf('<div class="prose post-body"')
  const end = html.indexOf('<section class="community-cta"', start)
  if (start < 0 || end < 0) throw new Error(`[markdown] could not find the article body in ${p.slug}`)
  // Tidy turndown output outside code fences: "## 1\\. Title" -> "## 1. Title", "-   item" -> "- item".
  const body = td.turndown(html.slice(start, end)).replace(/\n{3,}/g, '\n\n').split(/(^```[\s\S]*?^```$)/m)
    .map((part, i) => i % 2 ? part : part.replace(/^(#+ \d+)\\\./gm, '$1.').replace(/^(\s*)(-|\d+\.) {2,3}/gm, '$1$2 ')).join('').trim()
  const meta = [`URL: ${SITE}${p.url}`, `Author: ${p.author}${p.author === AUTHOR.name ? ` (${SITE}${AUTHOR.url})` : ''}`, `Published: ${day(p.date)}`,
    ...(p.updated ? [`Updated: ${day(p.updated)}`] : []), `Topics: ${[...new Set([...p.categories.map(c => c.name), ...p.tags])].join(', ')}`]
  const md = `# ${p.title}\n\n> ${p.excerpt}\n\n${meta.map(m => `- ${m}`).join('\n')}\n\n${body}\n`
  fs.writeFileSync(new URL(`${p.slug}.md`, dist), md)
  docs.push(md)
}
fs.writeFileSync(new URL('llms-full.txt', dist), `# Laravel & VueJs: full text of every article\n\n> Tutorials, guides and a friendly community for developers building with Laravel and Vue. Source: ${SITE}. Generated ${new Date().toISOString().slice(0, 10)}.\n\n${docs.join('\n\n---\n\n')}`)
console.log(`[markdown] wrote ${docs.length} Markdown post(s) and llms-full.txt`)
