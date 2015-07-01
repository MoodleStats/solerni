<?php

/*
 * @author    Shaun Daubney
 * @package   theme_solerni
 * @author    Orange / Solerni
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/*
 * @todo : reogarnize content, use array of values to reduce duplicated code
 */

use theme_solerni\settings\options;

$settings = null;
$solernioptions = new options();

defined('MOODLE_INTERNAL') || die;

// Create new admin category Solerni.
$ADMIN->add('themes', new admin_category('theme_solerni', 'Solerni'));

/*
 *  Page
 *  Frontpage Settings
 */
$temp = new admin_settingpage('theme_solerni_frontpage', get_string('frontpagesettings','theme_solerni'));
// frontpage header tagline.
$name = 'theme_solerni/frontpagetagline';
$title = get_string('frontpagetagline', 'theme_solerni');
$description = get_string('frontpagetaglinedesc', 'theme_solerni');
$default = get_string('footertaglinedefault', 'theme_solerni');
$setting = new admin_setting_configtext($name, $title, $description, $default);
$temp->add($setting);
// frontpage header presentation.
$name = 'theme_solerni/frontpagepresentation';
$title = get_string('frontpagepresentation', 'theme_solerni');
$description = get_string('frontpagepresentationdesc', 'theme_solerni');
$default = get_string('frontpagepresentationdefault', 'theme_solerni');
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$temp->add($setting);
// frontpage background header image.
$name = 'theme_solerni/frontpageheaderimage';
$title = get_string('frontpageheaderimage', 'theme_solerni');
$description = get_string('frontpageheaderimagedesc', 'theme_solerni');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'frontpageheaderimage');
$setting->set_updatedcallback('theme_reset_all_caches'); // regenerate CSS.
$temp->add($setting);
$ADMIN->add('theme_solerni', $temp);
// frontpage title above the catalog.
$name = 'theme_solerni/catalogtitle';
$title = get_string('catalogtitle', 'theme_solerni');
$description = get_string('catalogtitledesc', 'theme_solerni');
$default = get_string('catalogtitledefault', 'theme_solerni');
$setting = new admin_setting_configtext($name, $title, $description, $default);
$temp->add($setting);

// Colours administration. New page.
$temp = new admin_settingpage('theme_solerni_colors', get_string('colorsettings','theme_solerni'));
$name = 'theme_solerni/colourheading';
$heading = get_string('colourheading', 'theme_solerni');
$information = get_string('colourheadingdesc', 'theme_solerni');
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);
// Get colors keys and values from options class.
foreach( $solernioptions::solerni_get_colors_array() as $key => $value ) {
    $name = 'theme_solerni/' . $key;
    $title = get_string( $key, 'theme_solerni' );
    $description = get_string( $key . 'desc', 'theme_solerni');
    $default = $value;
    $previewconfig = NULL;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches'); // regenerate CSS.
    $temp->add($setting);
}
$ADMIN->add('theme_solerni', $temp);

// Footer elements. New page.
$temp = new admin_settingpage('theme_solerni_footer', get_string('footersettings','theme_solerni'));
$name = 'theme_solerni/footertextheading';
$heading = get_string('footertextheading', 'theme_solerni');
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
                'theme_solerni/footertextlangheading' . $lang,
                '',
                get_string('footertextlangheading', 'theme_solerni') . $langname
            )
        );
        // Footer tagline and text by lang.
        foreach( $solernioptions::solerni_get_footertext_array() as $key => $value ) {
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
// Iterate to create each setting.
foreach( $solernioptions::solerni_get_footerlinks_array() as $key => $value ) {
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
// Iterate to create each setting.
foreach( $solernioptions::solerni_get_sociallinks_array() as $key => $value ) {
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
// Iterate to create each setting.
foreach( $solernioptions::solerni_get_staticlinks_array() as $key => $value ) {
    $name = 'theme_solerni/' . $key;
    $title = get_string( $key, 'theme_solerni' );
    $description = get_string( $key . 'desc', 'theme_solerni');
    $default = $value;
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);
}
$ADMIN->add('theme_solerni', $temp);
