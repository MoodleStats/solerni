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

    return $css;
}

