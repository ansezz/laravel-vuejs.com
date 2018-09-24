<?php

namespace Theme\Admin\Builder;


use Theme\Admin\Builder\Post\Page;
use Theme\Admin\Builder\Post\Post;
use Theme\Admin\Builder\QA\QA;
use Themosis\Facades\Config;

class PostTypeBuilder
{
    public static function get()
    {
        return Config::get('laravelvuejs.post_types');
    }

    public static function build($postType)
    {
        switch ($postType) {
            case "post":
                Post::build();
                break;
            case "qa":
                QA::build();
                break;
            case "page":
                Page::build();
                break;
        }
    }
}