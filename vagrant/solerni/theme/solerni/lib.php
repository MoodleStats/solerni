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
 * @author    Shaun Daubney
 * @author    Orange / Solerni
 * @package   theme_solerni
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/*
 * Function executed at theme init
 * Insert jQuery library
 */
function theme_solerni_page_init(moodle_page $page) {
    /* current JQuery version for 2.7 is jQuery 1.11 which is IE8 compatible */
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

    global $OUTPUT;

    // Get colors.
    $colorsettings = \theme_solerni\settings\options::solerni_get_colors_array();
    foreach ($colorsettings as $key => $value) {
        // Use default if not set.
        if (!empty( $theme->settings->$key ) ) {
            $value = $theme->settings->$key;
        }
        // Search and replace.
        $tag = "[[setting:$key]]";
        $css = str_replace( $tag, $value, $css );
    }

    // replace header background image.
    if ( $theme->setting_file_url('frontpageheaderimage', 'frontpageheaderimage') ) {
        $backgroundheaderimage = $theme->setting_file_url('frontpageheaderimage', 'frontpageheaderimage');
    } else {
        $backgroundheaderimage = $OUTPUT->pix_url('images-default/frontpage', 'theme_solerni');
    }

    $css = str_replace( '[[setting:frontpageheaderimage]]', $backgroundheaderimage, $css );

    return $css;
}

/*
 * Mandatory callback from pluginfile.php
 * Deals with local specific
 * $args[] = itemid
 * $args[] = path
 * $args[] = filename
 */
function theme_solerni_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $CFG, $DB;

    // Not sure about that, I'm not context-fluent. Our module use SYSTEM.
    if ($context->contextlevel != CONTEXT_SYSTEM) {
        return false;
    }

    // We only use one file areas.
    if ($filearea != 'frontpageheaderimage' ) {
        return false;
    }

    $theme = theme_config::load('solerni');
    return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);

}
