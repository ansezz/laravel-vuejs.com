<?php

use Theme\Admin\Features\MultiLanguageFeature;
use Theme\Admin\Builder\PostTypeBuilder;


/*
 * Post customization
 */

foreach (PostTypeBuilder::get() as $postType) {
    PostTypeBuilder::build($postType);
}


MultiLanguageFeature::customizeGetPostPermalink();
MultiLanguageFeature::customizeGetPosts();

