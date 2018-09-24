<?php

namespace Theme\Admin\Builder;


use Theme\Admin\Builder\Post\Post;
use Theme\Admin\Builder\Program\Program;

class PermalinkBuilder
{
    const ROUTE_POST = '%s/%s/%s/%s-%d';
    const ROUTE_PROGRAM = 'program/%s ';

    public static function build($postId, $permalink)
    {
        $postType = get_post_type();

        switch ($postType) {
            case 'post':
                return Post::buildPermalink($postId, $permalink);
            case 'program':
                return Program::buildPermalink($postId, $permalink);
            default:
                return '';
        }
    }
}