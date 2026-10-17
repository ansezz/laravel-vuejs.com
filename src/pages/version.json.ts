// Build identity for the post-deploy check (scripts/check-live.mjs): which commit the live site was built from.
// Workers Builds sets WORKERS_CI_COMMIT_SHA and WORKERS_CI_BRANCH; GitHub Actions sets GITHUB_SHA; local builds say "unknown".
import { BUILD_TIME } from '../lib/content'

const env = (globalThis as { process?: { env: Record<string, string | undefined> } }).process?.env ?? {}

export const GET = () =>
  new Response(
    JSON.stringify({
      sha: env.WORKERS_CI_COMMIT_SHA ?? env.GITHUB_SHA ?? 'unknown',
      branch: env.WORKERS_CI_BRANCH ?? env.GITHUB_REF_NAME ?? 'unknown',
      builtAt: BUILD_TIME.toISOString(),
    }),
    { headers: { 'Content-Type': 'application/json; charset=utf-8', 'Cache-Control': 'no-store' } },
  )
