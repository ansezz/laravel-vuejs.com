---
id: 114
title: "Format money before it reaches Vue"
seoTitle: "Format money in Vue"
excerpt: "Store integer cents. Format with Number::currency on the server and pass a string. Do not add money in JavaScript."
description: "Store integer cents. Format with Number::currency on the server and pass a string. Do not add money in JavaScript."
date: 2026-10-11T11:01:00Z
snippet: "Number::currency($cents / 100, in: 'USD')"
categories: [laravel, vuejs]
tags: [laravel, vuejs, php]
---
People searching "format money Vue Laravel" add two prices in the component with `+`. Binary floats make that wrong. Store integer cents. Format once on the server. The [API resource guide](/laravel-api-resources-vue) is the same idea for other fields: the page receives what it should print.

```php
use Illuminate\Support\Number;

'price' => Number::currency($order->total_cents / 100, in: 'USD'),
```

`total_cents` is an integer column. The Vue page prints `price` and does not parse it back into a number to add tax. Tax is another integer on the server.

Do not use a `float` column for money. Do not send cents to the browser and format them with string concatenation. `Number::currency` uses the intl extension, so a missing extension is a deploy problem, not a Vue problem. Do not install a second currency package in the starter kit for one label.
