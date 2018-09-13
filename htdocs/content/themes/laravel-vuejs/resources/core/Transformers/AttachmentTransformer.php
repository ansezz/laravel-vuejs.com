<?php

namespace Core\Transformers;

use Core\Models\Attachment;

class AttachmentTransformer
{

    public static function item(Attachment $attachment)
    {
        return [
            'title' => $attachment->title,
            'url' => $attachment->url,
            'type' => $attachment->type,
            'alt' => $attachment->alt,
            'description' => $attachment->description
        ];
    }
}