<?php

/*
 * @author    Shaun Daubney
 * @author    Orange / Solerni
 * @package   theme_solerni
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/*
 * Function executed at theme init
 */
function theme_solerni_page_init(moodle_page $page) {
    /* current JQuery version for 2.7 is jQuery 1.1 which is IE8 */
    $page->requires->jquery();
}

/*
 * Replace each occurence of color settings in css 
 * by the value from admin settings
 * 
 * @param $css string
 * 
 * @return $css
 * 
 */
function solerni_process_css($css, $theme) {
    
    $color_settings = \theme_solerni\settings\options::solerni_get_colors_array();
    
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

