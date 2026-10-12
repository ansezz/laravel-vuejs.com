// Checks the reel picker against the same module the page imports.
import { existsSync } from "node:fs";
import { fileURLToPath } from "node:url";
import { nextSpin, spinIdeas } from "../src/data/spin.ts";

const fail = (message) => {
  console.error(message);
  process.exit(1);
};

function mulberry32(seed) {
  let a = seed >>> 0;
  return () => {
    a |= 0;
    a = (a + 0x6d2b79f5) | 0;
    let t = Math.imul(a ^ (a >>> 15), 1 | a);
    t = (t + Math.imul(t ^ (t >>> 7), 61 | t)) ^ t;
    return ((t ^ (t >>> 14)) >>> 0) / 4294967296;
  };
}

const pool = [
  {
    id: "a",
    title: "Alpha",
    prompt: "Prompt for alpha.",
    guide: "/alpha",
    guideTitle: "Alpha guide",
  },
  {
    id: "b",
    title: "Beta",
    prompt: "Prompt for beta.",
    guide: "/beta",
    guideTitle: "Beta guide",
  },
  {
    id: "c",
    title: "Gamma",
    prompt: "Prompt for gamma.",
    guide: "/gamma",
    guideTitle: "Gamma guide",
  },
];

function sequence(source, steps, start = []) {
  const random = mulberry32(source);
  let shown = start;
  const ids = [];
  for (let i = 0; i < steps; i += 1) {
    const result = nextSpin(pool, shown, random);
    if (!pool.includes(result.idea))
      fail(`result ${result.idea?.id} is not in the fixed pool`);
    const member = pool.find((item) => item.id === result.idea.id);
    if (result.idea !== member)
      fail("picker returned a copy instead of the pool idea");
    if (!result.idea.prompt || result.idea.prompt !== member.prompt) {
      fail(`prompt for ${result.idea.id} is not that idea's prompt`);
    }
    ids.push(result.idea.id);
    shown = result.shown;
  }
  return { ids, shown };
}

const k = pool.length;
const first = sequence(1, k);
if (new Set(first.ids).size !== k) {
  fail(`first ${k} picks were not distinct: ${first.ids.join(",")}`);
}
if (first.shown.join(",") !== first.ids.join(",")) {
  fail(`shown ids drifted from the picks: ${first.shown.join(",")}`);
}

const atOne = nextSpin(pool, [], () => 1);
if (atOne.idea !== pool[pool.length - 1])
  fail("random() of 1 walked off the pool");

const held = ["a"];
const heldBefore = held.slice();
nextSpin(pool, held, () => 0);
if (held.length !== heldBefore.length || held[0] !== heldBefore[0]) {
  fail("nextSpin mutated the shown list");
}

const longer = sequence(99, k + 2);
const again = sequence(99, k + 2);
if (longer.ids.join(",") !== again.ids.join(",")) {
  fail("the same seed did not yield the same sequence");
}
const restarted = nextSpin(
  pool,
  pool.map((item) => item.id),
  () => 0,
);
if (restarted.shown.length !== 1 || restarted.shown[0] !== restarted.idea.id) {
  fail("an exhausted pool did not start a new shown list");
}
if (!pool.includes(restarted.idea)) fail("exhausted pick left the pool");

if (spinIdeas.length < 2) fail("the live pool needs more than one idea");
const liveIds = new Set();
const liveTitles = new Set();
for (const item of spinIdeas) {
  if (liveIds.has(item.id)) fail(`duplicate id ${item.id}`);
  liveIds.add(item.id);
  if (liveTitles.has(item.title)) fail(`duplicate title ${item.title}`);
  liveTitles.add(item.title);
  if (!item.prompt.trim()) fail(`${item.id} has an empty prompt`);
  if (item.prompt !== spinIdeas.find((row) => row.id === item.id)?.prompt) {
    fail(`${item.id} prompt does not match the pool`);
  }
  const blob = `${item.title}\n${item.prompt}\n${item.guideTitle}`;
  if (blob.includes("\u2014") || blob.includes("\u2013")) {
    fail(`${item.id} contains an em dash or an en dash`);
  }
  if (
    /openai/i.test(blob) ||
    /api key/i.test(blob) ||
    blob.includes("VITE_") ||
    blob.includes("sk-")
  ) {
    fail(`${item.id} mentions a paid API or a provider key`);
  }
  if (/\bbuy\b/i.test(blob))
    fail(`${item.id} tells the reader to buy a service`);
  if (item.prompt.includes(item.title))
    fail(`${item.id} prompt repeats its title`);
  if (!item.prompt.includes(`https://laravel-vuejs.space${item.guide}`)) {
    fail(`${item.id} prompt does not name its guide`);
  }
  if (!item.prompt.includes("Show the diff. Do not commit.")) {
    fail(`${item.id} prompt does not close with the diff line`);
  }
  if (!/\bDo not\b/.test(item.prompt))
    fail(`${item.id} prompt has no constraint`);
  if (!item.prompt.includes("Screens:"))
    fail(`${item.id} prompt has no screens`);
  if (!item.prompt.includes("Models:")) fail(`${item.id} prompt has no models`);
  const slug = item.guide.replace(/^\//, "");
  const post = fileURLToPath(
    new URL(`../src/content/posts/${slug}.md`, import.meta.url),
  );
  if (!existsSync(post)) fail(`${item.guide} is not a published guide file`);
}

const relay = spinIdeas.find((item) => item.id === "relay");
if (!relay) fail("the announcement project is missing");
if (
  /private channel/i.test(relay.title) ||
  /Listen on a private channel/.test(relay.prompt)
) {
  fail(
    "the announcement project still tells the reader to use a private channel",
  );
}
if (!relay.prompt.includes("ShouldBroadcast"))
  fail("the announcement project does not name ShouldBroadcast");
if (!/public Channel/.test(relay.prompt))
  fail("the announcement project does not keep the public channel");
if (!relay.prompt.includes("Listen with useEchoPublic."))
  fail("the announcement project does not listen with useEchoPublic");
if (!relay.prompt.includes("Do not listen with useEcho on a public channel.")) {
  fail(
    "the announcement project does not forbid useEcho on the public channel",
  );
}

const live = sequenceLive(7, spinIdeas.length);
if (new Set(live).size !== spinIdeas.length) {
  fail("the live pool repeated an idea before every idea was shown");
}
const liveAgain = sequenceLive(7, spinIdeas.length);
if (live.join(",") !== liveAgain.join(","))
  fail("the live pool seed was not stable");

function sequenceLive(source, steps) {
  const random = mulberry32(source);
  let shown = [];
  const ids = [];
  for (let i = 0; i < steps; i += 1) {
    const result = nextSpin(spinIdeas, shown, random);
    if (!spinIdeas.includes(result.idea)) fail("live pick left the pool");
    if (!result.idea.prompt) fail("live pick had an empty prompt");
    ids.push(result.idea.id);
    shown = result.shown;
  }
  return ids;
}

console.log(`spin ok: ${spinIdeas.length} projects`);
