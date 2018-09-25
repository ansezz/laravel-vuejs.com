<?php

namespace Theme\Admin\Builder\Video;

use Theme\Admin\Features\MultiLanguageFeature;
use Themosis\Facades\Field;

class VideoDetails
{
    protected static $fields = [];

    public static function addFields()
    {
        self::$fields[] = Field::text('video_url', ['title' => 'Video URL']);
        // self::$fields[] = MultiLanguageFeature::createLanguageField();

        return self::$fields;
    }
}