<?php

namespace Theme\Admin\Builder\Post;

use Themosis\Facades\Metabox;

class Post
{
    public static function build()
    {
        Metabox::make(
            'Properties',
            'post',
            ['priority' => 'high', 'context' => 'side']
        )->set(PostProperties::addFields());
    }

    public static function buildPermalink($postId, $permalink)
    {
        $locale = get_post_meta($postId, 'locale', true);

        $permalink = str_replace(
            get_home_url(),
            get_home_url('', $locale),
            $permalink
        );

        $permalink = str_replace(
            get_home_url('', $locale . '/' . $locale),
            get_home_url('', $locale),
            $permalink
        );

        return $permalink;
    }
}