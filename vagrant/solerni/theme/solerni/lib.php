<?php

/*
 * @author    Shaun Daubney
 * @author    Orange / Solerni
 * @package   theme_solerni
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/*
 * Return associative array ( setting_name => default_value )
 * List and default values for theme colors
 */
function solerni_get_colors_array() {
    
    // Array of solerni color settings ( setting name => default value )
    return $solerni_colors = array(
        'backcolor'         => '#FFFFFF',
        'primary'           => '#4B667C',
        'primaryhover'      => '#334554',
        'secondary'         => '#FF004F',
        'secondaryhover'    => '#D90045',
        'tertiary'          => '#AAC044',
        'tertiaryhover'     => '#92A63A',
        'dark'              => '#000000',
        'light'             => '#FFFFFF',
        'grey1'             => '#F6F6F6',
        'grey2'             => '#EEEEEF',
        'grey3'             => '#999999',
        'grey4'             => '#606060',
        'grey5'             => '#333333'
    );
}

/*
 * Return associative array ( setting_name => default_value )
 * List and default values for social networks
 */
function solerni_get_social_array() {
    
    // Array of solerni social settings ( setting name => default value )
    return $solerni_socials = array(
        'website'           => '',
        'facebook'          => '',
        'twitter'           => '',
        'googleplus'        => '',
        'linkedin'          => '',
        'youtube'           => ''
    );
}

function solerni_process_css($css, $theme) {
    
    $color_settings = solerni_get_colors_array();
    
    foreach ( $color_settings as $key => $value ) {
        
        // Use default if not set
        if (!empty( $theme->settings->$key ) ) {
            $value = $theme->settings->$key;
        }
        // Search and replace
        $tag = "[[setting:$key]]";
        $css = str_replace( $tag, $value, $css );  
    }
    
    return $css;

}

