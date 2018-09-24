<?php

namespace Theme\Admin\Builder\Post;

use Theme\Admin\Features\MultiLanguageFeature;
use Themosis\Facades\Field;

class PostProperties
{
    protected static $fields = [];

    public static function addFields()
    {

        self::$fields[] = MultiLanguageFeature::createLocaleField();


        self::addFeatured();


        return self::$fields;
    }

    public static function addFeatured()
    {
        self::$fields[] = Field::checkbox('featured', [1 => 'Featured'], ['title' => 'Feature this post']);
    }
}