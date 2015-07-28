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
 * @package    theme_cerulean
 * @copyright  2014 Bas Brands
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use theme_cerulean\settings\options;

$settings = null;
$ceruleanoptions = new options();

defined('MOODLE_INTERNAL') || die;

// Create new admin category Solerni.
$ADMIN->add('themes', new admin_category('theme_cerulean', 'Cerulean'));

/*
 *  Page
 *  Frontpage Settings
 */
$temp = new admin_settingpage('theme_cerulean_frontpage', get_string('frontpagesettings','theme_cerulean'));
// frontpage header tagline.
$name = 'theme_cerulean/frontpagetagline';
$title = get_string('frontpagetagline', 'theme_cerulean');
$description = get_string('frontpagetaglinedesc', 'theme_cerulean');
$default = get_string('footertaglinedefault', 'theme_cerulean');
$setting = new admin_setting_configtext($name, $title, $description, $default);
$temp->add($setting);
// frontpage header presentation.
$name = 'theme_cerulean/frontpagepresentation';
$title = get_string('frontpagepresentation', 'theme_cerulean');
$description = get_string('frontpagepresentationdesc', 'theme_cerulean');
$default = get_string('frontpagepresentationdefault', 'theme_cerulean');
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$temp->add($setting);
// frontpage background header image.
$name = 'theme_cerulean/frontpageheaderimage';
$title = get_string('frontpageheaderimage', 'theme_cerulean');
$description = get_string('frontpageheaderimagedesc', 'theme_cerulean');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'frontpageheaderimage');
$setting->set_updatedcallback('theme_reset_all_caches'); // regenerate CSS.
$temp->add($setting);
$ADMIN->add('theme_cerulean', $temp);
// frontpage title above the catalog.
$name = 'theme_cerulean/catalogtitle';
$title = get_string('catalogtitle', 'theme_cerulean');
$description = get_string('catalogtitledesc', 'theme_cerulean');
$default = get_string('catalogtitledefault', 'theme_cerulean');
$setting = new admin_setting_configtext($name, $title, $description, $default);
$temp->add($setting);

// Colours administration. New page.
$temp = new admin_settingpage('theme_cerulean_colors', get_string('colorsettings','theme_cerulean'));
$name = 'theme_cerulean/colourheading';
$heading = get_string('colourheading', 'theme_cerulean');
$information = get_string('colourheadingdesc', 'theme_cerulean');
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);
// Get colors keys and values from options class.
foreach( $ceruleanoptions::cerulean_get_colors_array() as $key => $value ) {
    $name = 'theme_cerulean/' . $key;
    $title = get_string( $key, 'theme_cerulean' );
    $description = get_string( $key . 'desc', 'theme_cerulean');
    $default = $value;
    $previewconfig = NULL;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches'); // regenerate CSS.
    $temp->add($setting);
}
$ADMIN->add('theme_cerulean', $temp);

// Footer elements. New page.
$temp = new admin_settingpage('theme_cerulean_footer', get_string('footersettings','theme_cerulean'));
$name = 'theme_cerulean/footertextheading';
$heading = get_string('footertextheading', 'theme_cerulean');
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
                'theme_cerulean/footertextlangheading' . $lang,
                '',
                get_string('footertextlangheading', 'theme_cerulean') . $langname
            )
        );
        // Footer tagline and text by lang.
        foreach( $ceruleanoptions::cerulean_get_footertext_array() as $key => $value ) {
            $fieldtype = $value['fieldtype'];
            $name = 'theme_cerulean/' . $key . '_' . $lang;
            $title = get_string_manager()->get_string( $key. 'title', 'theme_cerulean', null, $lang);
            $description = get_string_manager()->get_string($key . 'desc', 'theme_cerulean', null, $lang);
            $default = get_string_manager()->get_string( $key. 'default', 'theme_cerulean', null, $lang);
            $setting = new $fieldtype($name, $title, $description, $default);
            $temp->add($setting);
        }
    }
}
// Footer links.
$name = 'theme_cerulean/footerlinksheading';
$heading = get_string('footerlinksheading', 'theme_cerulean');
$information = get_string('footerlinksheadingdesc', 'theme_cerulean');
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);
// Get social network names and url values.
// Iterate to create each setting.
foreach( $ceruleanoptions::cerulean_get_footerlinks_array() as $key => $value ) {
    $name = 'theme_cerulean/' . $key;
    $title = get_string( $key, 'theme_cerulean' );
    $description = get_string( $key . 'desc', 'theme_cerulean');
    $default = $value;
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);
}
$ADMIN->add('theme_cerulean', $temp);

// Socials elements. New page
$temp = new admin_settingpage('theme_cerulean_social', get_string('socialsettings','theme_cerulean'));
// Social Link Heading.
$name = 'theme_cerulean/sociallinksheading';
$heading = get_string('sociallinksheading', 'theme_cerulean');
$information = get_string('sociallinksheadingdesc', 'theme_cerulean');
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);
// Get social network names and url values.
// Iterate to create each setting.
foreach( $ceruleanoptions::cerulean_get_sociallinks_array() as $key => $value ) {
    $name = 'theme_cerulean/' . $key;
    $title = get_string( $key, 'theme_cerulean' );
    $description = get_string( $key . 'desc', 'theme_cerulean');
    $default = $value;
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);
}
$ADMIN->add('theme_cerulean', $temp);

// Header links admin. New page.
$temp = new admin_settingpage('theme_cerulean_header', get_string('headersettings','theme_cerulean'));
$name = 'theme_cerulean/headerheading';
$heading = get_string('headerheading', 'theme_cerulean');
$information = get_string('headerheadingdesc', 'theme_cerulean');
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);
// Get static links and url values.
// Iterate to create each setting.
foreach( $ceruleanoptions::cerulean_get_staticlinks_array() as $key => $value ) {
    $name = 'theme_cerulean/' . $key;
    $title = get_string( $key, 'theme_cerulean' );
    $description = get_string( $key . 'desc', 'theme_cerulean');
    $default = $value;
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);
}
$ADMIN->add('theme_cerulean', $temp);

/*
if ($ADMIN->fulltree) {

    // Logo file setting.
    $name = 'theme_cerulean/logo';
    $title = get_string('logo', 'theme_cerulean');
    $description = get_string('logodesc', 'theme_cerulean');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Custom CSS file.
    $name = 'theme_cerulean/customcss';
    $title = get_string('customcss', 'theme_cerulean');
    $description = get_string('customcssdesc', 'theme_cerulean');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

}
*/