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

/**
 * @package    blocks
 * @subpackage extended_course_object
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


/**
 * Display text
 *
 * @param $text
 * @return string html_writer::tag
 * */
function display_text($text, $classtext) {

    return  html_writer::tag('span', get_string($text, 'local_orange_library'),
                array('class' => $classtext));

}

/**
 * Display text
 *
 * @param $text
 * @return string html_writer::tag
 * */
function display_link($text, $classtext) {

    return  html_writer::tag('link', get_string($text, 'local_orange_library'),
        array('class' => $classtext));

}
/**
 * Display button
 *
 * @param $text
 * @param $url
 * @return string html_writer::tag
 * */
function display_button($text, $url, $classbutton, $course) {
     return html_writer::tag('a', get_string($text, 'local_orange_library'),
        array('class' => $classbutton, 'href' => $url, 'data-mooc-name' => $course->fullname));
}
