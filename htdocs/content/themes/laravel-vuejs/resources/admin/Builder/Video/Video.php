<?php

namespace Theme\Admin\Builder\Video;


use Themosis\Facades\Metabox;
use Themosis\Facades\PostType;

class Video
{
    public static function build()
    {
        /**
         * Register the video post type.
         */
        $qa = PostType::make('video', 'Videos', 'Video')->set([
            'description' => 'Videos',
            'supports' => ['title', 'thumbnail', 'editor', 'author', 'excerpt', 'comments', 'revisions'],
            'menu_icon' => 'dashicons-playlist-video',
            'taxonomies' => ['post_tag', 'category'],
            'public' => true,
        ]);

        Metabox::make(
            'Properties',
            $qa->get('name'),
            ['priority' => 'high', 'context' => 'side']
        )->set(VideoProperties::addFields());

        Metabox::make(
            'Details',
            $qa->get('name'),
            ['priority' => 'high', 'context' => 'normal']
        )->set(VideoDetails::addFields());
    }

    public static function buildPermalink($postId, $permalink)
    {
        // default
        return $permalink;
    }
}