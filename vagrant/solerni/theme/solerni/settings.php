<?php

/*
 * @author    Shaun Daubney
 * @package   theme_solerni
 * @author    Orange / Solerni
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$settings = null;

defined('MOODLE_INTERNAL') || die;

// Create new admin category Solerni.
$ADMIN->add('themes', new admin_category('theme_solerni', 'Solerni'));

// frontpage settings. New page.
$temp = new admin_settingpage('theme_solerni_frontpage', get_string('frontpagesettings','theme_solerni'));
// frontpage tagline.
$name = 'theme_solerni/frontpagetagline';
$title = get_string( 'frontpagetagline', 'theme_solerni' );
$description = get_string( 'frontpagetaglinedesc', 'theme_solerni');
$default = get_string( 'footertaglinedefault', 'theme_solerni' );
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);
$ADMIN->add('theme_solerni', $temp);

// Colours administration. New page.
$temp = new admin_settingpage('theme_solerni_colors', get_string('colorsettings','theme_solerni'));
$name = 'theme_solerni/colourheading';
$heading = get_string('colourheading', 'theme_solerni');
$information = get_string('colourheadingdesc', 'theme_solerni');
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);
// Get colors keys and values from options class.
$color_settings = \theme_solerni\settings\options::solerni_get_colors_array();
foreach( $color_settings as $key => $value ) {
    $name = 'theme_solerni/' . $key;
    $title = get_string( $key, 'theme_solerni' );
    $description = get_string( $key . 'desc', 'theme_solerni');
    $default = $value;
    $previewconfig = NULL;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
}
$ADMIN->add('theme_solerni', $temp);

// Footer elements. New page.
$temp = new admin_settingpage('theme_solerni_footer', get_string('footersettings','theme_solerni'));
$name = 'theme_solerni/footertextheading';
$heading = get_string('footertextheading', 'theme_solerni');
$information = get_string('footertextheadingdesc', 'theme_solerni');
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);
// Platform langs.
$langs = get_string_manager()->get_list_of_translations();
$footer_texts = \theme_solerni\settings\options::solerni_get_footertext_array();
if ( $langs ) {
    foreach ( $langs as $lang => $langname ) {
        foreach( $footer_texts as $key => $value ) {
            // Footer tagline and text by lang.
            $fieldtype = $value['fieldtype'];
            $name = 'theme_solerni/' . $key . '_' . $lang;
            $title = get_string_manager()->get_string( $key. 'title', 'theme_solerni', null, $lang);
            $description = get_string_manager()->get_string($key . 'desc', 'theme_solerni', null, $lang);
            $default = get_string_manager()->get_string( $key. 'default', 'theme_solerni', null, $lang);
            $setting = new $fieldtype($name, $title, $description, $default);
            $temp->add($setting);
        }
    }
}
// Footer links.
$name = 'theme_solerni/footerlinksheading';
$heading = get_string('footerlinksheading', 'theme_solerni');
$information = get_string('footerlinksheadingdesc', 'theme_solerni');
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);
// Get social network names and url values.
$footerlinks_settings = \theme_solerni\settings\options::solerni_get_footerlinks_array();
// Iterate to create each setting.
foreach( $footerlinks_settings as $key => $value ) {
    $name = 'theme_solerni/' . $key;
    $title = get_string( $key, 'theme_solerni' );
    $description = get_string( $key . 'desc', 'theme_solerni');
    $default = $value;
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);
}
$ADMIN->add('theme_solerni', $temp);

// Socials elements. New page
$temp = new admin_settingpage('theme_solerni_social', get_string('socialsettings','theme_solerni'));
// Social Link Heading.
$name = 'theme_solerni/sociallinksheading';
$heading = get_string('sociallinksheading', 'theme_solerni');
$information = get_string('sociallinksheadingdesc', 'theme_solerni');
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);
// Get social network names and url values.
$social_settings = \theme_solerni\settings\options::solerni_get_sociallinks_array();
// Iterate to create each setting.
foreach( $social_settings as $key => $value ) {
    $name = 'theme_solerni/' . $key;
    $title = get_string( $key, 'theme_solerni' );
    $description = get_string( $key . 'desc', 'theme_solerni');
    $default = $value;
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);
}
$ADMIN->add('theme_solerni', $temp);

// Header links admin. New page.
$temp = new admin_settingpage('theme_solerni_header', get_string('headersettings','theme_solerni'));
$name = 'theme_solerni/headerheading';
$heading = get_string('headerheading', 'theme_solerni');
$information = get_string('headerheadingdesc', 'theme_solerni');
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);
// Get static links and url values.
$links_settings = \theme_solerni\settings\options::solerni_get_staticlinks_array();
// Iterate to create each setting.
foreach( $links_settings as $key => $value ) {
    $name = 'theme_solerni/' . $key;
    $title = get_string( $key, 'theme_solerni' );
    $description = get_string( $key . 'desc', 'theme_solerni');
    $default = $value;
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);
}
$ADMIN->add('theme_solerni', $temp);
