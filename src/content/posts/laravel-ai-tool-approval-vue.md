---
id: 148
title: "Approve an AI SDK tool before it runs"
seoTitle: "Approve an AI SDK tool"
excerpt: "pendingApprovals means the agent stopped. Resuming that approval needs the conversation. A one-shot prompt cannot resume it."
description: "pendingApprovals means the agent stopped. Resuming that approval needs the conversation. A one-shot prompt cannot resume it."
date: 2026-10-11T11:35:00Z
snippet: "$response->pendingApprovals"
categories: [laravel, vuejs]
tags: [laravel, vuejs]
---

People searching "Laravel AI tool approval" call a tool that sends mail and are surprised it ran. A tool that needs a person to say yes stops on `pendingApprovals`. The [AI SDK guide](/laravel-ai-sdk-vue) has no tools. Add one only when the approval path exists.

The response tells you the agent is waiting. `hasPendingApprovals()` is the check. `pendingApprovals` is the list.

```php
if ($response->hasPendingApprovals()) {
    return Inertia::render('notes/Approve', [
        'conversation' => $response->conversationId,
    ]);
}
```

Store the conversation first, the way the [conversation guide](/laravel-ai-conversation-vue) does, and check ownership before you resume. The Vue page posts the decision. Every pending call needs one. Resume with `continue` and a `Decisions` object. A one-shot `prompt()` with no conversation cannot approve the call.

```php
use Laravel\Ai\Approvals\Decision;
use Laravel\Ai\Approvals\Decisions;
use Laravel\Ai\Contracts\ConversationStore;

$store = app(ConversationStore::class);

abort_unless($store->conversationBelongsTo(
    $validated['conversation'],
    $request->user()->getMorphClass(),
    $request->user()->getKey(),
), 403);

$response = (new DraftReply)
    ->continue($validated['conversation'], as: $request->user())
    ->prompt(Decisions::from([
        $validated['call_id'] => Decision::approve(),
    ]));
```

Do not auto-approve inside the tool to "get the demo working". That deletes the reason the approval exists. Do not call the provider from the browser to skip the wait.
