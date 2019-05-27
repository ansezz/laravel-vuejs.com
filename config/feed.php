<?php

return [
    'feeds' => [
        'main' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * 'App\Model@getAllFeedItems'
             *
             * You can also pass an argument to that method:
             * ['App\Model@getAllFeedItems', 'argument']
             */
            'items' => 'LaravelVueJs\Services\FeedService@getMainFeed',

            /*
             * The feed will be available on this url.
             */
            'url' => '/feed',

            'title' => 'Laravel VueJs feeds',

            /*
             * The view that will render the feed.
             */
            'view' => 'feed::feed',
        ],
        'posts' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * 'App\Model@getAllFeedItems'
             *
             * You can also pass an argument to that method:
             * ['App\Model@getAllFeedItems', 'argument']
             */
            'items' => 'LaravelVueJs\Services\FeedService@getPostFeed',

            /*
             * The feed will be available on this url.
             */
            'url' => '/feed/posts',

            'title' => 'Laravel VueJs posts feeds',

            /*
             * The view that will render the feed.
             */
            'view' => 'feed::feed',
        ],
        'categories' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * 'App\Model@getAllFeedItems'
             *
             * You can also pass an argument to that method:
             * ['App\Model@getAllFeedItems', 'argument']
             */
            'items' => 'LaravelVueJs\Services\FeedService@getCategoryFeed',

            /*
             * The feed will be available on this url.
             */
            'url' => '/feed/categories',

            'title' => 'Laravel VueJs categories feed',

            /*
             * The view that will render the feed.
             */
            'view' => 'feed::feed',
        ],
        'tags' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * 'App\Model@getAllFeedItems'
             *
             * You can also pass an argument to that method:
             * ['App\Model@getAllFeedItems', 'argument']
             */
            'items' => 'LaravelVueJs\Services\FeedService@getTagFeed',

            /*
             * The feed will be available on this url.
             */
            'url' => '/feed/tags',

            'title' => 'Laravel VueJs tags feed',

            /*
             * The view that will render the feed.
             */
            'view' => 'feed::feed',
        ],
        'media' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * 'App\Model@getAllFeedItems'
             *
             * You can also pass an argument to that method:
             * ['App\Model@getAllFeedItems', 'argument']
             */
            'items' => 'LaravelVueJs\Services\FeedService@getMediaFeed',

            /*
             * The feed will be available on this url.
             */
            'url' => '/feed/medias',

            'title' => 'Laravel VueJs medias feed',

            /*
             * The view that will render the feed.
             */
            'view' => 'feed::feed',
        ],
    ],
];
