<?php

/*
 * @author    Shaun Daubney
 * @package   theme_solerni
 * @author    Orange / Solerni
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    // Colour Heading
    $name = 'theme_solerni/colourheading';
    $heading = get_string('colourheading', 'theme_solerni');
    $information = get_string('colourheadingdesc', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $settings->add($setting);

    // Get colors keys and values
    $color_settings = \theme_solerni\settings\options::solerni_get_colors_array();
    // Iterate to create each setting
    foreach( $color_settings as $key => $value ) {
        // Settings
        $name = 'theme_solerni/' . $key;
        $title = get_string( $key, 'theme_solerni' );
        $description = get_string( $key . 'desc', 'theme_solerni');
        $default = $value;
        $previewconfig = NULL;
        // Admin setting generation
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $settings->add($setting);
    }

    // Footer Text
    $name = 'theme_solerni/footertextheading';
    $heading = get_string('footertextheading', 'theme_solerni');
    $information = get_string('footertextheadingdesc', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $settings->add($setting);

    $langs = get_string_manager()->get_list_of_translations();

    $footer_texts = \theme_solerni\settings\options::solerni_get_footertext_array();
    // Platform langs.
    if ( $langs ) {
        foreach ( $langs as $lang => $langname ) {
            // Iterate to create each setting.
            foreach( $footer_texts as $key => $value ) {
                // Settings.
                $fieldtype = $value['fieldtype'];
                $name = 'theme_solerni/' . $key . '_' . $lang;
                $title = get_string_manager()->get_string( $key. 'title', 'theme_solerni', null, $lang);
                $description = get_string_manager()->get_string($key . 'desc', 'theme_solerni', null, $lang);
                $default = get_string_manager()->get_string($key . 'default', 'theme_solerni', null, $lang);
                // Admin setting generation.
                $setting = new $fieldtype($name, $title, $description, $default);
                $settings->add($setting);
            }
        }
    }

    // Footer links.
    $name = 'theme_solerni/footerlinksheading';
    $heading = get_string('footerlinksheading', 'theme_solerni');
    $information = get_string('footerlinksheadingdesc', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $settings->add($setting);

    // Get social network names and url values.
    $footerlinks_settings = \theme_solerni\settings\options::solerni_get_footerlinks_array();
    // Iterate to create each setting.
    foreach( $footerlinks_settings as $key => $value ) {
        // Settings.
        $name = 'theme_solerni/' . $key;
        $title = get_string( $key, 'theme_solerni' );
        $description = get_string( $key . 'desc', 'theme_solerni');
        $default = $value;
        // Admin setting generation.
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $settings->add($setting);
    }

    // Social Link Heading.
    $name = 'theme_solerni/sociallinksheading';
    $heading = get_string('sociallinksheading', 'theme_solerni');
    $information = get_string('sociallinksheadingdesc', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $settings->add($setting);

    // Get social network names and url values.
    $social_settings = \theme_solerni\settings\options::solerni_get_sociallinks_array();
    // Iterate to create each setting.
    foreach( $social_settings as $key => $value ) {
        // Settings.
        $name = 'theme_solerni/' . $key;
        $title = get_string( $key, 'theme_solerni' );
        $description = get_string( $key . 'desc', 'theme_solerni');
        $default = $value;
        // Admin setting generation.
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $settings->add($setting);
    }

    // Static Links Heading.
    $name = 'theme_solerni/themelinksheading';
    $heading = get_string('themelinksheading', 'theme_solerni');
    $information = get_string('themelinksheadingdesc', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $settings->add($setting);

    // Get static links and url values.
    $links_settings = \theme_solerni\settings\options::solerni_get_staticlinks_array();
    // Iterate to create each setting.
    foreach( $links_settings as $key => $value ) {
        // Settings.
        $name = 'theme_solerni/' . $key;
        $title = get_string( $key, 'theme_solerni' );
        $description = get_string( $key . 'desc', 'theme_solerni');
        $default = $value;
        // Admin setting generation.
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $settings->add($setting);
    }

}
