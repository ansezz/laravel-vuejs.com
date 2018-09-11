<?php

use Themosis\Facades\Field;

/**
 * Class BoxOptions
 */
class BoxOptions
{
    /**
     * List of fields.
     *
     * @var array
     */
    protected static $fields = [];

    /**
     * Add necessary fields to the list.
     *
     * @return array
     */
    public static function all()
    {
        self::$fields = [
            Field::checkbox(\Core\Models\BaseModel::FEATURED, [1 => 'Feature this post.'], ['title' => '']),
        ];

        self::addLanguage();

        return self::$fields;
    }

    /**
     * Add the language select input only.
     *
     * @return array
     */
    public static function addLanguageOnly()
    {
        self::$fields = [];

        self::addLanguage();

        return self::$fields;
    }

    /**
     * Add the language field if needed.
     *
     * @return void
     */
    protected static function addLanguage()
    {
        self::$fields[] = Field::select(\Core\Models\BaseModel::LOCALE, [['ar' => 'Arabic'], ['fr' => 'French']], ['title' => 'Language']);
    }

}
