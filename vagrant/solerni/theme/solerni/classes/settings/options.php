<?php

/*
 * @author    Orange / Solerni
 * @package   theme_solerni
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_solerni\settings;

class options {
    
    /*
    * Return associative array ( setting_name => default_value )
    * List and default values for theme colors
    */
    static function solerni_get_colors_array() {
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
    static function solerni_get_social_array() {

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
    
    /*
    * Return associative array ( setting_name => default_value )
    * List and default values for theme IHM loose links 
    */
   static function solerni_get_links_array() {

       // Array of solerni social settings ( setting name => default value )
       return $solerni_socials = array(
           'about'     => '',
           'catalogue' => ''
       );
   }
    
}