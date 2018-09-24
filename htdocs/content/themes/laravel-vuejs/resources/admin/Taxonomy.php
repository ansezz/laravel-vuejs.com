<?php

use Theme\Admin\Features\MultiLanguageFeature;
use Themosis\Facades\Taxonomy;

Taxonomy::addFields([
    MultiLanguageFeature::createLocaleField()
], 'category');

MultiLanguageFeature::customizeGetTaxonomies();



