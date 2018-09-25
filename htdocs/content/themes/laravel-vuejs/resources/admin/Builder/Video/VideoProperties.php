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

        self::$fields[] = Field::checkbox('resolved', [1 => 'Resolved'], ['title' => 'Is Resolved']);

        self::$fields[] = MultiLanguageFeature::createLanguageField();

        return self::$fields;
    }

    public static function addFeatured()
    {
        self::$fields[] = Field::checkbox('featured', [1 => 'Featured'], ['title' => 'Is Feature:']);
    }
}