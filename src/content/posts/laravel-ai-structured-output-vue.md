---
id: 145
title: "Return a structured score from the AI SDK"
seoTitle: "Structured output from the AI SDK"
excerpt: "HasStructuredOutput defines a schema. The Vue page receives the fields you read from the response, not the provider payload."
description: "HasStructuredOutput defines a schema. The Vue page receives the fields you read from the response, not the provider payload."
date: 2026-10-11T11:32:00Z
snippet: "public function schema(JsonSchema $schema): array"
categories: [laravel, vuejs]
tags: [laravel, vuejs, inertia]
---
People searching "Laravel AI SDK structured output" print the whole provider response in Vue. Define a schema and pass one field. The [AI SDK guide](/laravel-ai-sdk-vue) is the text agent and the rule that the key stays on the server. This page is the schema.

```php
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;

class ScoreNote implements Agent, HasStructuredOutput
{
    use Promptable;

    public function instructions(): string
    {
        return 'Score the note from 1 to 5.';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'score' => $schema->integer()->required(),
        ];
    }
}
```

```php
$response = (new ScoreNote)->prompt($validated['note']);

return Inertia::render('notes/Show', [
    'score' => $response['score'],
]);
```

The page prints `score`. It does not parse JSON.

Do not pass `$request->all()` to `prompt()`. Do not add a `VITE_` key so Vue can "check the score" with the provider. The [AI SDK guide](/laravel-ai-sdk-vue) already refuses that.
