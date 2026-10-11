// Rehype plugin for posts (.md and .mdx): adds "#" anchors to h2/h3 (runs after rehypeHeadingIds, see astro.config.mjs)
// and resolves the {{CONTACT_EMAIL}} placeholder in Markdown posts. Code frames are added by the Shiki transformer in
// shiki-frame.mjs, because highlighting runs after user rehype plugins.
const CONTACT = 'contact@laravel-vuejs.space'
const LANG = { md: 'markdown', sh: 'bash', js: 'javascript', ts: 'typescript', plaintext: 'text', txt: 'text' }
const svg = (cls, d) => ({ type: 'element', tagName: 'svg', properties: { className: [cls], width: 14, height: 14, viewBox: '0 0 24 24', fill: 'none', stroke: 'currentColor', strokeWidth: 2, strokeLinecap: 'round', strokeLinejoin: 'round', ariaHidden: 'true' }, children: d })
const el = (tagName, properties, children = []) => ({ type: 'element', tagName, properties, children })
const text = value => ({ type: 'text', value })
const copyIcons = [
  svg('i-copy', [el('rect', { x: 9, y: 9, width: 13, height: 13, rx: 2 }), el('path', { d: 'M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1' })]),
  svg('i-check', [el('path', { d: 'M20 6 9 17l-5-5' })]),
]

// Shiki transformer: wraps every highlighted block in the site's code frame (file name or language, copy button).
// ```ts title="resources/js/app.ts" sets the file name.
export function transformerFrame() {
  return {
    name: 'laravel-vuejs:frame',
    pre(node) {
      const m = this.options.meta?.__raw?.match(/title="([^"]+)"/)
      if (m) node.properties['data-title'] = m[1]
    },
    root(root) {
      const pre = root.children.find(n => n.type === 'element' && n.tagName === 'pre')
      if (!pre) return
      const lang = this.options.lang ?? 'text'
      const title = pre.properties['data-title']
      const label = [title ? el('span', { className: ['code-file'] }, [text(title)]) : null,
        el('span', { className: ['code-lang'] }, [text(LANG[lang] ?? lang)])].filter(Boolean)
      root.children = [el('div', { className: title ? ['code', 'has-title'] : ['code'] }, [
        el('div', { className: ['code-head'] }, [...label,
          el('button', { type: 'button', className: ['copy-btn'], ariaLabel: 'Copy code' }, [...copyIcons, el('span', { className: ['copy-label'] }, [text('Copy')])])]),
        pre,
      ])]
    },
  }
}

export default function rehypePost() {
  return tree => walk(tree)
}
function walk(node) {
  if (!node.children) return
  node.children = node.children.map(child => {
    if (child.type === 'text' && child.value.includes('{{CONTACT_EMAIL}}')) {
      const parts = child.value.split('{{CONTACT_EMAIL}}')
      return parts.flatMap((p, i) => i ? [el('a', { href: `mailto:${CONTACT}` }, [text(CONTACT)]), text(p)] : [text(p)])
    }
    if (child.type === 'element' && /^h[23]$/.test(child.tagName) && child.properties?.id) {
      child.children.push(el('a', { className: ['anchor'], href: `#${child.properties.id}`, ariaLabel: 'Link to this section' }, [text('#')]))
    }
    walk(child)
    return child
  }).flat()
}
