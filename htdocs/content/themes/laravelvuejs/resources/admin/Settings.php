<?php

use Next\Themosis\Admin\Features\SettingsFeature;

/*
* Create Settings page
*/

$settingsFeature = new SettingsFeature();

$settingsFeature->buildGlobalSettingsPage();

$settingsFeature->buildMenusSettingsPage();

$settingsFeature->buildLinksSettingsPage();

$settingsFeature->buildBreakingNewsSettingsPage();
