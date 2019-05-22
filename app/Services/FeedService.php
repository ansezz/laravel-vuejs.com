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
        return Post::all();
    }

    public static function getCategoryFeed()
    {
        return Category::all();
    }

    public static function getTagFeed()
    {
        return Tag::all();
    }

    public static function getMediaFeed()
    {
        return Media::all();
    }
}