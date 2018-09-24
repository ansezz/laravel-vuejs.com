<?php

namespace Theme\Admin\Builder\QA;

use Theme\Admin\Features\MultiLanguageFeature;
use Themosis\Facades\Field;

class QADetails
{
    protected static $fields = [];

    public static function addFields()
    {
        //       self::$fields[] = Field::editor('question', ['title' => 'Question details']);
        self::$fields[] = Field::editor('answer', ['title' => 'Correct Answer']);
        self::$fields[] = Field::text('source', ['title' => 'Source URL']);
        self::$fields[] = MultiLanguageFeature::createLanguageField();

        return self::$fields;
    }
}