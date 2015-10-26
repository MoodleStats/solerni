<?php
// This file is part of The Orange Halloween Moodle Theme
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    theme_halloween
 * @copyright  2014 Bas Brands
 * @copyright  Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use theme_halloween\settings\options;

defined('MOODLE_INTERNAL') || die;

$settings = null;

// Create new admin category Solerni.
$ADMIN->add('themes', new admin_category('theme_halloween', 'Halloween'));

/*
 * Colors: Settings
 */
$temp = new admin_settingpage('theme_halloween_colors', get_string('colorsettings', 'theme_halloween'));
$name = 'theme_halloween/colourheading';
$heading = get_string('colourheading', 'theme_halloween');
$information = get_string('colourheadingdesc', 'theme_halloween');
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);

// Get colors keys and values from options class.
foreach (options::get_colors_list() as $key => $value) {
    $name = 'theme_halloween/' . $key;
    $title = get_string($key, 'theme_halloween');
    $description = get_string( $key . 'desc', 'theme_halloween');
    $default = $value;
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
}
$ADMIN->add('theme_halloween', $temp);

/*
 * Follow Us: Settings
 */
$temp = new admin_settingpage('theme_halloween_social', get_string('followussettings', 'theme_halloween'));
$name = 'theme_halloween/followusheading';
$heading = get_string('followusheading', 'theme_halloween');
$information = get_string('followusheadingdesc', 'theme_halloween');
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);

foreach (options::halloween_get_followus_urllist() as $key => $value) {
    $name = 'theme_halloween/' . $key;
    $title = get_string($key, 'theme_halloween');
    $description = '';
    $default = $value;
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
}
$ADMIN->add('theme_halloween', $temp);

/*
 * Footer Branding Area: Settings
 */
$temp = new admin_settingpage('theme_halloween_footerbrand', get_string('footerbrandsettings', 'theme_halloween'));
$name = 'theme_halloween/footerbrandheading';
$heading = get_string('footerbrandheading', 'theme_halloween');
$information = htmlentities(get_string('footerbrandheadingdesc', 'theme_halloween'));
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);

foreach (options::halloween_get_footerbrand_content() as $key => $value) {
    $name = 'theme_halloween/' . $key;
    $title = get_string($key, 'theme_halloween');
    $description = '';
    $default = $value;
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
}
$ADMIN->add('theme_halloween', $temp);

/*
 * Footer lists: Settings
 */
$temp = new admin_settingpage('theme_halloween_footerlists', get_string('footerlistssettings', 'theme_halloween'));
$name = 'theme_halloween/footerlistsheading';
$heading = get_string('footerlistsheading', 'theme_halloween');
$information = get_string('footerlistsheadingdesc', 'theme_halloween');
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);

// First Column.
$name = 'theme_halloween/footerlistscolumn1heading';
$heading = get_string('footerlistscolumn1heading', 'theme_halloween');
$information = htmlentities(get_string('footerlistscolumn1headingdesc', 'theme_halloween'));
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);

foreach (options::halloween_get_footerlists_column1_items() as $key => $value) {
    $name = 'theme_halloween/' . $key;
    $title = get_string( $key, 'theme_halloween' );
    $description = '';
    $default = $value;
    if (false === strpos($key, 'link')) {
        $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    } else {
        $setting = new admin_setting_configtext($name, $title, $description, $default);
    }
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
}

// Second Column.
$name = 'theme_halloween/footerlistscolumn2heading';
$heading = get_string('footerlistscolumn2heading', 'theme_halloween');
$information = htmlentities(get_string('footerlistscolumn2headingdesc', 'theme_halloween'));
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);

foreach (options::halloween_get_footerlists_column2_items() as $key => $value) {
    $name = 'theme_halloween/' . $key;
    $title = get_string( $key, 'theme_halloween' );
    $description = '';
    $default = $value;
    if (false === strpos($key, 'link')) {
        $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    } else {
        $setting = new admin_setting_configtext($name, $title, $description, $default);
    }
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
}
$ADMIN->add('theme_halloween', $temp);
