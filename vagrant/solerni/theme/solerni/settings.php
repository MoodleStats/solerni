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
    
    // Social Icons Heading
    $name = 'theme_solerni/socialiconsheading';
    $heading = get_string('socialiconsheading', 'theme_solerni');
    $information = get_string('socialiconsheadingdesc', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $settings->add($setting);
    
        // Get social network names and url values
        $social_settings = \theme_solerni\settings\options::solerni_get_social_array();
        // Iterate to create each setting
        foreach( $social_settings as $key => $value ) {
            // Settings
            $name = 'theme_solerni/' . $key;
            $title = get_string( $key, 'theme_solerni' );
            $description = get_string( $key . 'desc', 'theme_solerni');
            $default = $value;
            // Admin setting generation
            $setting = new admin_setting_configtext($name, $title, $description, $default);
            $settings->add($setting);
        }
    
    // Static Links Heading
    $name = 'theme_solerni/themelinksheading';
    $heading = get_string('themelinksheading', 'theme_solerni');
    $information = get_string('themelinksheadingdesc', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $settings->add($setting);

        // Get social network names and url values
        $links_settings = \theme_solerni\settings\options::solerni_get_links_array();
        // Iterate to create each setting
        foreach( $links_settings as $key => $value ) {
            // Settings
            $name = 'theme_solerni/' . $key;
            $title = get_string( $key, 'theme_solerni' );
            $description = get_string( $key . 'desc', 'theme_solerni');
            $default = $value;
            // Admin setting generation
            $setting = new admin_setting_configtext($name, $title, $description, $default);
            $settings->add($setting);
        }
    
}