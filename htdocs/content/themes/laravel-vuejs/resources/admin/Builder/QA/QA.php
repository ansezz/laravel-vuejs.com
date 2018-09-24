<?php

namespace Theme\Admin\Builder\QA;


use Theme\Admin\Builder\QA\QADetails;
use Theme\Admin\Builder\QA\QAProperties;
use Themosis\Facades\Config;
use Themosis\Facades\Metabox;
use Themosis\Facades\PostType;

class QA
{
    public static function build()
    {
        /**
         * Register the video post type.
         */
        $qa = PostType::make('qa', 'QAs', 'QA')->set([
            'description' => 'QAs (Emissions)',
            'supports' => ['title', 'thumbnail', 'editor', 'author', 'excerpt', 'comments', 'revisions'],
            'menu_icon' => 'dashicons-images-alt2',
            // 'taxonomies'    => ['post_tag'],
            'public' => true,
        ]);

        Metabox::make(
            'Properties',
            $qa->get('name'),
            ['priority' => 'high', 'context' => 'side']
        )->set(QAProperties::addFields());

        Metabox::make(
            'Details',
            $qa->get('name'),
            ['priority' => 'high', 'context' => 'normal']
        )->set(QADetails::addFields());
    }

    public static function buildPermalink($postId, $permalink)
    {
        // default
        return $permalink;
    }
}