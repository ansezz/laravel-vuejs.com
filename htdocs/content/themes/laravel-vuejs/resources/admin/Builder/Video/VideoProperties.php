<?php

namespace Theme\Admin\Builder\Video;

use Theme\Admin\Features\MultiLanguageFeature;
use Themosis\Facades\Field;

class VideoProperties
{
    protected static $fields = [];

    public static function addFields()
    {
        self::addFeatured();

        self::$fields[] = MultiLanguageFeature::createLanguageField();

        return self::$fields;
    }

    public static function addFeatured()
    {
        self::$fields[] = Field::checkbox(\Core\Models\Post::FEATURED_KEY, [1 => 'Featured'], ['title' => 'Is Feature:']);
    }
}