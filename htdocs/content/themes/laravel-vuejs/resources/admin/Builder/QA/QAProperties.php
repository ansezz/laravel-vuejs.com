<?php

namespace Theme\Admin\Builder\QA;

use Themosis\Facades\Field;

class QAProperties
{
    protected static $fields = [];

    public static function addFields()
    {
        self::addFeatured();

        self::$fields[] = Field::checkbox('resolved', [1 => 'Resolved'], ['title' => 'Is Resolved']);

        return self::$fields;
    }

    public static function addFeatured()
    {
        self::$fields[] = Field::checkbox('featured', [1 => 'Featured'], ['title' => 'Is Feature:']);
    }
}