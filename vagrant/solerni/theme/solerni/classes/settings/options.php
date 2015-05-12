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
    public static function solerni_get_colors_array() {
        // Array of solerni color settings ( setting name => default value ).
        return array(
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
    public static function solerni_get_sociallinks_array() {

        // Array of solerni social settings ( setting name => default value ).
        return array(
            'blog'              => '',
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
    public static function solerni_get_staticlinks_array() {

        // Array of solerni social settings ( setting name => default value ).
        return array(
            'about'     => '',
            'catalogue' => ''
        );
    }

    /*
    * Return associative array ( setting_name => default_value )
    * List and default values for footer text
     */
    public static function solerni_get_footertext_array() {

        // Array of solerni social settings ( setting name => default value ).
        return array(
            'footertagline'           => array(
                                            'fieldtype' => 'admin_setting_configtext',
                                            'defaultvalue' => '' ),
            'footerexplaination'      => array(
                                            'fieldtype' => 'admin_setting_configtextarea',
                                            'defaultvalue' => '' )
        );
    }

    /*
    * Return associative array ( setting_name => default_value )
    * List and default values for footer links
     */
    public static function solerni_get_footerlinks_array() {

        // Array of solerni footer links settings ( setting name => default value ).
        return array(
            'aboutsolerni'      => '',
            'partners'          => '',
            'legal'             => '',
            'cgu'               => '',
            'faq'               => '',
            'contactus'         => '',
        );
    }

}
