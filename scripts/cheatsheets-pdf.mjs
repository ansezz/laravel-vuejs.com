// Renders the cheat sheets in src/data/cheatsheets.ts to branded A4 PDFs in public/cheatsheets/pdf/<slug>-cheat-sheet.pdf.
// Run locally after editing a sheet: `npm run cheatsheets:pdf` (needs Chrome/Chromium; set CHROME_PATH if it isn't
// /usr/bin/google-chrome). The PDFs are committed, so builds and CI don't need a browser. Each sheet must fit 2 pages:
// the script fails if one runs longer (check with `pdfinfo`).
import fs from 'node:fs'
import os from 'node:os'
import path from 'node:path'
import { execFileSync } from 'node:child_process'
import { pathToFileURL } from 'node:url'
import { codeToHtml } from 'shiki'
import { CHEATSHEETS, pdfPath } from '../src/data/cheatsheets.ts'
import { BRAND, SITE_DOMAIN } from '../src/config/site.ts'

const root = new URL('..', import.meta.url).pathname
const chrome = process.env.CHROME_PATH || '/usr/bin/google-chrome'
const font = (p) => pathToFileURL(path.join(root, 'node_modules/@fontsource-variable', p)).href
const logo = fs.readFileSync(path.join(root, 'src/components/Logo.astro'), 'utf8').match(/<svg[\s\S]*<\/svg>/)[0]
  .replace(/class=\{[^}]+\}/, 'class="logo"').replace(/aria-label=\{title\}/, 'aria-label="Laravel &amp; VueJs"').replace(/<title>\{title\}<\/title>/, '')
const esc = (s) => s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
const only = process.argv.slice(2)
const tmp = fs.mkdtempSync(path.join(os.tmpdir(), 'cheatsheets-'))
fs.mkdirSync(path.join(root, 'public/cheatsheets/pdf'), { recursive: true })

for (const sheet of CHEATSHEETS) {
  if (only.length && !only.includes(sheet.slug)) continue
  const sections = []
  for (const section of sheet.sections) {
    const items = []
    for (const item of section.items) {
      const code = await codeToHtml(item.code, { lang: item.lang, theme: 'github-light-high-contrast' })
      items.push(`<div class="item"><h3>${esc(item.title)}</h3>${code}${item.note ? `<p class="note">${esc(item.note)}</p>` : ''}</div>`)
    }
    sections.push(`<section><h2>${esc(section.title)}</h2>${items.join('')}</section>`)
  }
  const url = `${SITE_DOMAIN}/cheatsheets/${sheet.slug}`
  const html = `<!doctype html><html lang="en"><head><meta charset="utf-8"><title>${esc(sheet.title)}</title><style>
@font-face { font-family: Geist; src: url(${font('geist/files/geist-latin-wght-normal.woff2')}) format('woff2'); font-weight: 100 900; }
@font-face { font-family: 'Geist Mono'; src: url(${font('geist-mono/files/geist-mono-latin-wght-normal.woff2')}) format('woff2'); font-weight: 100 900; }
@page { size: A4; margin: 11mm 10mm 12mm; @bottom-left { content: '${url}'; font: 7pt Geist; color: ${BRAND.slate}; }
  @bottom-right { content: 'Page ' counter(page) ' of ' counter(pages); font: 7pt Geist; color: ${BRAND.slate}; } }
* { box-sizing: border-box; }
body { margin: 0; font: 8pt/1.35 Geist, sans-serif; color: #0d1424; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
header { display: flex; align-items: center; justify-content: space-between; gap: 12pt; background: ${BRAND.slate}; color: #fff; padding: 9pt 12pt; border-bottom: 4pt solid ${BRAND.mint}; }
header .logo { height: 22pt; width: auto; } .logo-shape { fill: ${BRAND.mint}; } .logo-text { fill: #fff; }
header h1 { margin: 0; font-size: 14pt; letter-spacing: -.01em; } header p { margin: 2pt 0 0; font-size: 7.5pt; color: ${BRAND.mist}; }
.badge { font: 600 7pt 'Geist Mono'; background: ${BRAND.purple}; color: #fff; padding: 3pt 6pt; white-space: nowrap; }
main { columns: 2; column-gap: 10pt; margin-top: 9pt; }
section { break-inside: auto; margin-bottom: 7pt; }
h2 { font-size: 9.5pt; margin: 0 0 4pt; padding-bottom: 2pt; border-bottom: 2pt solid ${BRAND.mint}; color: ${BRAND.purple}; break-after: avoid; }
.item { break-inside: avoid; margin-bottom: 5pt; }
h3 { font-size: 7.5pt; margin: 0 0 2pt; color: ${BRAND.slate}; }
pre.shiki { margin: 0; padding: 4pt 5pt; background: #f7f8fc !important; border-left: 2pt solid ${BRAND.purple}; font: 6.6pt/1.32 'Geist Mono', monospace; white-space: pre-wrap; word-break: break-word; }
.note { margin: 2pt 0 0; font-size: 7pt; color: ${BRAND.slate}; font-style: italic; }
footer { break-inside: avoid; margin-top: 6pt; padding-top: 5pt; border-top: 1pt solid ${BRAND.mist}; font-size: 6.8pt; color: ${BRAND.slate}; }
footer strong { color: ${BRAND.purple}; }
</style></head><body>
<header><div><h1>${esc(sheet.title)}</h1><p>${esc(sheet.lead)}</p></div><div style="text-align:right">${logo}<div style="margin-top:5pt"><span class="badge">${esc(sheet.version)}</span></div></div></header>
<main>${sections.join('')}</main>
<footer><strong>Checked ${sheet.checked}</strong> against: ${sheet.sources.map((s) => esc(s.url)).join(' · ')}<br>
Online version with copy buttons: <strong>${url}</strong> · More guides and the monthly newsletter at ${SITE_DOMAIN}</footer>
</body></html>`
  const file = path.join(tmp, `${sheet.slug}.html`)
  fs.writeFileSync(file, html)
  const out = path.join(root, 'public', pdfPath(sheet.slug))
  execFileSync(chrome, ['--headless=new', '--no-sandbox', '--disable-gpu', '--no-pdf-header-footer', '--allow-file-access-from-files',
    '--virtual-time-budget=5000', `--print-to-pdf=${out}`, pathToFileURL(file).href], { stdio: 'pipe' })
  const pages = Number(execFileSync('pdfinfo', [out]).toString().match(/Pages:\s+(\d+)/)?.[1] ?? 0)
  console.log(`${path.relative(root, out)}: ${pages} page(s), ${(fs.statSync(out).size / 1024).toFixed(0)} KB`)
  if (pages > 2) { console.error(`${sheet.slug} is longer than 2 pages: trim it.`); process.exitCode = 1 }
}
