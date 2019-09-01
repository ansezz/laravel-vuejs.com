<?php


namespace LaravelVueJs\Services;


use LaravelVueJs\Models\Category;
use LaravelVueJs\Models\Media;
use LaravelVueJs\Models\Post;
use LaravelVueJs\Models\Tag;

class FeedService
{

    public static function getPostFeed()
    {
        return Post::latest('id')->limit(200)->get();
    }

    public static function getCategoryFeed()
    {
        return Category::latest('id')->limit(200)->get();
    }

    public static function getTagFeed()
    {
        return Tag::latest('id')->limit(200)->get();
    }

    public static function getMediaFeed()
    {
        return Media::latest('id')->limit(200)->get();
    }

    public static function getMainFeed()
    {
        return Post::latest('id')->limit(200)->get();
    }

}
