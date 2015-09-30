<?php
// This file is part of Moodle - http://moodle.org/
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
 * Theme More version file.
 *
 * @package    theme_halloween
 * @copyright  2014 Bas Brands
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use theme_halloween\settings\options;

$settings = null;
$themeoptions = new options();

defined('MOODLE_INTERNAL') || die;

// Create new admin category Solerni.
$ADMIN->add('themes', new admin_category('theme_halloween', 'Halloween'));

/*
 *
 * Colors Page Settings
 *
 */

$temp = new admin_settingpage('theme_halloween_colors', get_string('colorsettings','theme_halloween'));
$name = 'theme_halloween/colourheading';
$heading = get_string('colourheading', 'theme_halloween');
$information = get_string('colourheadingdesc', 'theme_halloween');
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);
// Get colors keys and values from options class.
foreach( $themeoptions::get_colors_array() as $key => $value ) {
    $name = 'theme_halloween/' . $key;
    $title = get_string( $key, 'theme_halloween' );
    $description = get_string( $key . 'desc', 'theme_halloween');
    $default = $value;
    $previewconfig = NULL;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches'); // regenerate CSS.
    $temp->add($setting);
}
$ADMIN->add('theme_halloween', $temp);

/*
 *
 * Footer Page Settings
 *
 */

$temp = new admin_settingpage('theme_halloween_footer', get_string('footersettings','theme_halloween'));
$name = 'theme_halloween/footertextheading';
$heading = get_string('footertextheading', 'theme_halloween');
$information = '';
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);
// Platform langs. Iterate for tagline and presentation texte.
$langs = get_string_manager()->get_list_of_translations();
if ( $langs ) {
    foreach ( $langs as $lang => $langname ) {
        // Echo title for each language.
        $temp->add(
            new admin_setting_heading(
                'theme_halloween/footertextlangheading' . $lang,
                '',
                get_string('footertextlangheading', 'theme_halloween') . $langname
            )
        );
        // Footer tagline and text by lang.
        foreach( $themeoptions::halloween_get_footertext_array() as $key => $value ) {
            $fieldtype = $value['fieldtype'];
            $name = 'theme_halloween/' . $key . '_' . $lang;
            $title = get_string_manager()->get_string( $key. 'title', 'theme_halloween', null, $lang);
            $description = get_string_manager()->get_string($key . 'desc', 'theme_halloween', null, $lang);
            $default = get_string_manager()->get_string( $key. 'default', 'theme_halloween', null, $lang);
            $setting = new $fieldtype($name, $title, $description, $default);
            $temp->add($setting);
        }
    }
}
// Footer links.
$name = 'theme_halloween/footerlinksheading';
$heading = get_string('footerlinksheading', 'theme_halloween');
$information = get_string('footerlinksheadingdesc', 'theme_halloween');
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);
// Get social network names and url values.
// Iterate to create each setting.
foreach( $themeoptions::halloween_get_footerlinks_array() as $key => $value ) {
    $name = 'theme_halloween/' . $key;
    $title = get_string( $key, 'theme_halloween' );
    $description = get_string( $key . 'desc', 'theme_halloween');
    $default = $value;
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);
}
$ADMIN->add('theme_halloween', $temp);

/*
 *
 * Social Page Settings
 *
 */
$temp = new admin_settingpage('theme_halloween_social', get_string('socialsettings','theme_halloween'));
// Social Link Heading.
$name = 'theme_halloween/sociallinksheading';
$heading = get_string('sociallinksheading', 'theme_halloween');
$information = get_string('sociallinksheadingdesc', 'theme_halloween');
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);
// Get social network names and url values.
// Iterate to create each setting.
foreach( $themeoptions::halloween_get_sociallinks_array() as $key => $value ) {
    $name = 'theme_halloween/' . $key;
    $title = get_string( $key, 'theme_halloween' );
    $description = get_string( $key . 'desc', 'theme_halloween');
    $default = $value;
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);
}
$ADMIN->add('theme_halloween', $temp);
