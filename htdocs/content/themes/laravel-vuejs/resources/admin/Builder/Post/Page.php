<?php

namespace Theme\Admin\Builder\Post;


use Themosis\Facades\Metabox;

class Page
{
    public static function build()
    {
        Metabox::make(
            'Properties',
            'page',
            ['priority' => 'high', 'context' => 'side']
        )->set(PageProperties::addFields());
    }

    public static function buildPermalink($postId, $permalink)
    {
        // override default permalink here
        return $permalink;
    }
}