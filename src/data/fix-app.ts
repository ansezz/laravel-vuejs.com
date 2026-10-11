import { guideBlocks, type GuideBrief } from "./prompt-builder";

export type FixMatch = {
  id: string;
  title: string;
  slugs: string[];
};

const ERROR_RULES: {
  id: string;
  title: string;
  slugs: string[];
  test: (text: string) => boolean;
}[] = [
  {
    id: "hot",
    title: "The dev server file or the Vite manifest is in the error.",
    slugs: ["laravel-vite-vue", "deploy-laravel-vue"],
    test: (text) => /public\/hot|vite manifest/i.test(text),
  },
  {
    id: "cors",
    title: "The browser blocked the response.",
    slugs: ["laravel-vue-cors"],
    test: (text) =>
      /access-control-allow-origin|blocked by cors|cors policy/i.test(text),
  },
  {
    id: "csrf",
    title: "The session token was rejected.",
    slugs: ["laravel-sanctum-vue-spa"],
    test: (text) => /\b419\b|csrf token mismatch|page expired/i.test(text),
  },
  {
    id: "sanctum401",
    title: "The API did not see the login session.",
    slugs: ["laravel-sanctum-vue-spa"],
    test: (text) =>
      /\b401\b|unauthenticated/i.test(text) &&
      /sanctum|\/api\/user|stateful/i.test(text),
  },
  {
    id: "ziggy",
    title: "Ziggy is still in the error.",
    slugs: ["laravel-ziggy-vue"],
    test: (text) => /ziggy/i.test(text),
  },
];

export function matchesFromError(text: string): FixMatch[] {
  const sample = text.trim();
  if (!sample) return [];
  return ERROR_RULES.filter((rule) => rule.test(sample)).map((rule) => ({
    id: rule.id,
    title: rule.title,
    slugs: rule.slugs,
  }));
}

function readDeps(raw: string): Record<string, string> | "empty" | "invalid" {
  const trimmed = raw.trim();
  if (!trimmed) return "empty";
  try {
    const data = JSON.parse(trimmed) as {
      require?: Record<string, string>;
      "require-dev"?: Record<string, string>;
      dependencies?: Record<string, string>;
      devDependencies?: Record<string, string>;
    };
    if (!data || typeof data !== "object" || Array.isArray(data))
      return "invalid";
    return {
      ...(data.require ?? {}),
      ...(data["require-dev"] ?? {}),
      ...(data.dependencies ?? {}),
      ...(data.devDependencies ?? {}),
    };
  } catch {
    return "invalid";
  }
}

function major(spec: string | undefined): number | null {
  const match = spec?.match(/\d+/);
  return match ? Number(match[0]) : null;
}

export function matchesFromManifests(
  composerRaw: string,
  packageRaw: string,
): { matches: FixMatch[]; notes: string[] } {
  const composer = readDeps(composerRaw);
  const npm = readDeps(packageRaw);
  const notes: string[] = [];
  if (composer === "invalid") notes.push("composer.json is not JSON.");
  if (npm === "invalid") notes.push("package.json is not JSON.");
  const php = composer === "empty" || composer === "invalid" ? {} : composer;
  const js = npm === "empty" || npm === "invalid" ? {} : npm;
  const matches: FixMatch[] = [];
  const add = (match: FixMatch) => matches.push(match);

  if (php["tightenco/ziggy"]) {
    add({
      id: "ziggy",
      title: "Ziggy is installed. The Vue starter kit uses Wayfinder.",
      slugs: ["laravel-ziggy-vue"],
    });
  }
  if (php["laravel/breeze"] || php["laravel/jetstream"]) {
    add({
      id: "breeze",
      title: "Breeze or Jetstream is installed beside the app.",
      slugs: ["laravel-breeze-jetstream-vue"],
    });
  }
  if (php["laravel/sanctum"] && php["laravel/passport"]) {
    add({
      id: "both-tokens",
      title: "Sanctum and Passport are both installed.",
      slugs: ["laravel-sanctum-vs-passport"],
    });
  }
  if (
    js["vue-router"] &&
    (js["@inertiajs/vue3"] || php["inertiajs/inertia-laravel"])
  ) {
    add({
      id: "router",
      title: "Vue Router is beside Inertia.",
      slugs: ["vue-router-laravel-spa"],
    });
  }
  const inertia =
    Boolean(js["@inertiajs/vue3"]) || Boolean(php["inertiajs/inertia-laravel"]);
  if (inertia && !php["laravel/wayfinder"]) {
    add({
      id: "wayfinder",
      title: "Inertia is installed and Wayfinder is not.",
      slugs: ["laravel-wayfinder-vue"],
    });
  }
  if (
    major(php["inertiajs/inertia-laravel"]) === 2 ||
    major(js["@inertiajs/vue3"]) === 2
  ) {
    add({
      id: "inertia2",
      title: "Inertia 2 is in these files.",
      slugs: ["upgrade-inertia-2-to-3"],
    });
  }
  return { matches, notes };
}

export const FIX_SLUGS = [
  ...new Set([
    ...ERROR_RULES.flatMap((rule) => rule.slugs),
    "laravel-ziggy-vue",
    "laravel-breeze-jetstream-vue",
    "laravel-sanctum-vs-passport",
    "vue-router-laravel-spa",
    "laravel-wayfinder-vue",
    "upgrade-inertia-2-to-3",
  ]),
];

/** One prompt. Guides that are not published yet are left out, not invented. */
export function fixPrompt(
  kind: "error" | "files",
  raw: { error?: string; composer?: string; package?: string },
  guides: Record<string, GuideBrief>,
): { prompt: string; count: number } {
  const end = "Show the diff. Do not commit.";
  if (kind === "error") {
    const text = raw.error ?? "";
    if (!text.trim()) {
      return { count: 0, prompt: "Paste an error above." };
    }
    const matches = matchesFromError(text);
    if (!matches.length) {
      return {
        count: 0,
        prompt:
          "No guide on this site matches that text. Paste a Laravel, Vite, Inertia, Sanctum, or CORS line.",
      };
    }
    const blocks = guideBlocks(
      matches.flatMap((match) => match.slugs),
      guides,
    );
    return {
      count: blocks.length,
      prompt: [
        "The error matches these guides. Fix only what they describe.",
        ...matches.map((match) => match.title),
        "Follow the guides in this order. Each block is that guide.",
        ...blocks,
        end,
      ].join("\n\n"),
    };
  }

  const { matches, notes } = matchesFromManifests(
    raw.composer ?? "",
    raw.package ?? "",
  );
  if (!raw.composer?.trim() && !raw.package?.trim()) {
    return { count: 0, prompt: "Paste composer.json, package.json, or both." };
  }
  const unpublished = matches.filter((match) =>
    match.slugs.every((slug) => !guides[slug]),
  );
  const blocks = guideBlocks(
    matches.flatMap((match) => match.slugs),
    guides,
  );
  if (!blocks.length && !notes.length && !unpublished.length) {
    return {
      count: 0,
      prompt:
        "Nothing in these files matches a guide here. The checks are Ziggy, Breeze, Jetstream, Passport beside Sanctum, Vue Router beside Inertia, a missing Wayfinder install, and Inertia 2.",
    };
  }
  const held = unpublished.length
    ? "A matching guide is not published yet, so those steps are left out."
    : "";
  return {
    count: blocks.length,
    prompt: [
      "These files match guides on this site. Change only what they describe.",
      ...notes,
      ...matches.map((match) => match.title),
      blocks.length
        ? "Follow the guides in this order. Each block is that guide."
        : "",
      ...blocks,
      held,
      end,
    ]
      .filter(Boolean)
      .join("\n\n"),
  };
}
