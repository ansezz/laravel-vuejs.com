// /ads.txt (the file name is fixed by the IAB standard), built from PUBLIC_PARTNER_ID ("ca-pub-..." -> "pub-...").
// Empty when no partner ID is set.
const id = (import.meta.env.PUBLIC_PARTNER_ID ?? '').trim().replace(/^ca-/, '')
const body = id ? `google.com, ${id}, DIRECT, f08c47fec0942fa0\n` : ''
export const GET = () => new Response(body, { headers: { 'Content-Type': 'text/plain; charset=utf-8' } })
