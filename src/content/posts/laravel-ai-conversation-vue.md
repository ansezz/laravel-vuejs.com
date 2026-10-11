---
id: 147
title: "Continue an AI SDK conversation you own"
seoTitle: "Store an AI SDK conversation"
excerpt: "RemembersConversations stores the thread. Check that the id belongs to the user before you continue it."
description: "RemembersConversations stores the thread. Check that the id belongs to the user before you continue it."
date: 2026-10-11T11:34:00Z
snippet: "->continue($id, as: $user)"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---

People searching "Laravel AI conversation" pass a conversation id from Vue straight into `continue()`. The SDK does not check that this user owns that id. The [AI SDK guide](/laravel-ai-sdk-vue) is the one-shot reply. This page is the thread.

Publish the migrations before you store anything. `RemembersConversations` needs `agent_conversations` and `agent_conversation_messages`.

```php
use Laravel\Ai\Concerns\RemembersConversations;
use Laravel\Ai\Contracts\Conversational;

class DraftReply implements Agent, Conversational
{
    use Promptable, RemembersConversations;
}
```

Do not also define `messages()` on that class. The trait is skipped when you do, and the stored thread is ignored.

```php
$reply = (new DraftReply)->forUser($request->user())->prompt($validated['note']);
```

The response exposes `conversationId`. On the next post, continue only after the conversation store says this user owns that id. `continue` does not check.

```php
use Laravel\Ai\Contracts\ConversationStore;

$store = app(ConversationStore::class);

abort_unless($store->conversationBelongsTo(
    $validated['conversation'],
    $request->user()->getMorphClass(),
    $request->user()->getKey(),
), 403);

$reply = (new DraftReply)
    ->continue($validated['conversation'], as: $request->user())
    ->prompt($validated['note']);
```

Do not trust the hidden field alone. Do not render the stored messages with `v-html`.
