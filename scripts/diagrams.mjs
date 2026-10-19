// Renders docs/diagrams/<name>.mmd (Mermaid) to public/diagrams/<name>-light.svg and <name>-dark.svg in the brand palette.
// Run locally after adding or editing a diagram: `npm run diagrams` (needs Chrome/Chromium; set CHROME_PATH if it isn't
// /usr/bin/google-chrome). The SVGs are committed, so builds and CI don't need a browser.
// Use in a post: <Diagram name="<name>" alt="What the diagram shows, in one or two sentences" caption="Optional caption" />
import fs from 'node:fs'
import os from 'node:os'
import path from 'node:path'
import { execFileSync } from 'node:child_process'

const root = new URL('..', import.meta.url).pathname
const src = path.join(root, 'docs/diagrams'), out = path.join(root, 'public/diagrams')
const only = process.argv.slice(2)
const font = 'Geist, Inter, ui-sans-serif, system-ui, sans-serif'
const themes = {
  light: { background: 'transparent', primaryColor: '#F1ECFF', primaryBorderColor: '#6936D3', primaryTextColor: '#0D1424', secondaryColor: '#E3FCF8',
    secondaryBorderColor: '#0F9F8F', tertiaryColor: '#F7F8FC', tertiaryBorderColor: '#AAB3C2', lineColor: '#5A6577', textColor: '#0D1424',
    noteBkgColor: '#FFF7E0', noteBorderColor: '#D9A400', noteTextColor: '#0D1424', actorBkg: '#F1ECFF', actorBorder: '#6936D3', actorTextColor: '#0D1424',
    signalColor: '#384457', signalTextColor: '#0D1424', labelBoxBkgColor: '#F1ECFF', clusterBkg: '#F7F8FC', clusterBorder: '#AAB3C2', edgeLabelBackground: '#FFFFFF', fontFamily: font },
  dark: { background: 'transparent', primaryColor: '#221A45', primaryBorderColor: '#A988FF', primaryTextColor: '#EEF1F6', secondaryColor: '#0F2E2B',
    secondaryBorderColor: '#63F9E6', tertiaryColor: '#131927', tertiaryBorderColor: '#4A5568', lineColor: '#8E98AA', textColor: '#EEF1F6',
    noteBkgColor: '#3A3115', noteBorderColor: '#D9A400', noteTextColor: '#EEF1F6', actorBkg: '#221A45', actorBorder: '#A988FF', actorTextColor: '#EEF1F6',
    signalColor: '#C9D0DC', signalTextColor: '#EEF1F6', labelBoxBkgColor: '#221A45', clusterBkg: '#131927', clusterBorder: '#4A5568', edgeLabelBackground: '#0E131F', fontFamily: font },
}
const tmp = fs.mkdtempSync(path.join(os.tmpdir(), 'diagrams-'))
const puppeteer = path.join(tmp, 'puppeteer.json')
fs.writeFileSync(puppeteer, JSON.stringify({ executablePath: process.env.CHROME_PATH || '/usr/bin/google-chrome', args: ['--no-sandbox'] }))
for (const file of fs.readdirSync(src).filter(f => f.endsWith('.mmd'))) {
  const name = path.basename(file, '.mmd')
  if (only.length && !only.includes(name)) continue
  for (const [mode, themeVariables] of Object.entries(themes)) {
    const cfg = path.join(tmp, `${mode}.json`)
    fs.writeFileSync(cfg, JSON.stringify({ theme: 'base', themeVariables, htmlLabels: false, flowchart: { htmlLabels: false, curve: 'basis', padding: 14 }, sequence: { mirrorActors: false }, fontFamily: font }))
    const target = path.join(out, `${name}-${mode}.svg`)
    execFileSync(process.env.MMDC || 'npx', [...(process.env.MMDC ? [] : ['-y', '@mermaid-js/mermaid-cli@11']), '-q', '-i', path.join(src, file), '-o', target, '-c', cfg, '-p', puppeteer, '-b', 'transparent'], { stdio: 'inherit' })
    // Drop editor-only data attributes Mermaid leaves behind (they can be most of the file size).
    fs.writeFileSync(target, fs.readFileSync(target, 'utf8').replace(/\s data-(?:points|id|look|et|edge|node)="[^"]*"/g, '')
      // Round path coordinates to 1 decimal: shapes are drawn as long point lists.
      .replace(/ d="([^"]*)"/g, (_, d) => ` d="${d.replace(/-?\d+\.\d+/g, n => String(Math.round(Number(n) * 10) / 10))}"`))
    console.log(`[diagrams] ${path.relative(root, target)} (${(fs.statSync(target).size / 1024).toFixed(1)} KB)`)
  }
}
