<?php

namespace Theme\Admin\Builder\Post;


use Theme\Admin\Features\MultiLanguageFeature;

class PageProperties
{
    protected static $fields = [];

    public static function addFields()
    {
        self::$fields[] = MultiLanguageFeature::createLocaleField();

        return self::$fields;
    }
}