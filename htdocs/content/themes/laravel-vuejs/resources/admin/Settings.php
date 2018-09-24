<?php

/*
* Create Settings page
*/

$settingsFeature = new \Theme\Admin\Features\SettingsFeature();

$settingsFeature->buildGlobalSettingsPage();

$settingsFeature->buildMenusSettingsPage();

$settingsFeature->buildLinksSettingsPage();
