<?php

use Theme\Admin\SettingsFeature;

/*
* Create Settings page
*/

$settingsFeature = new SettingsFeature();

$settingsFeature->buildGlobalSettingsPage();

$settingsFeature->buildMenusSettingsPage();

$settingsFeature->buildLinksSettingsPage();
