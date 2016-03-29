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
 * orange_paragraph_list block
 *
 * @package    orange_paragraph_list
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use local_orange_library\utilities\utilities_image;
use local_orange_library\utilities\utilities_course;
use local_orange_library\extended_course\extended_course_object;


/**
 * Checks whether the current page is the My home page.
 *
 * @return bool True when on the My home page.
 */
function block_orange_paragraph_list_on_my_page() {
    Global $SCRIPT;

    return $SCRIPT === '/my/index.php';
}

/**
 * Checks whether the current page is course page.
 *
 * @return bool True when on a course page.
 */
function block_orange_paragraph_list_on_course_page() {
    Global $COURSE;

    return ($COURSE->id > 1);
}

/**
 * Checks whether the current page is forum index page.
 *
 * @return bool True when on a forum index page.
 */
function block_orange_paragraph_list_on_forum_index_page() {

    return false;
}

/**
 * Checks whether the current page is course dashboard.
 *
 * @return bool True when on a course dashboard.
 */
function block_orange_paragraph_list_on_course_dashboard_page() {

    return false;
}

function block_orange_paragraph_list_get_course ($course) {
    Global $CFG;

    $context = context_course::instance($course->id);

    $imgurl = "";
    if ($course instanceof stdClass) {
        require_once($CFG->libdir. '/coursecatlib.php');
        $course = new course_in_list($course);
    }
    foreach ($course->get_course_overviewfiles() as $file) {
        $isimage = $file->is_valid_image();
        if ($isimage) {
            $imgurl = file_encode_url("$CFG->wwwroot/pluginfile.php",
                '/'. $file->get_contextid(). '/'. $file->get_component(). '/'.
                $file->get_filearea(). $file->get_filepath(). $file->get_filename(), !$isimage);
        }
    }

    $extendedcourse = new extended_course_object();
    $extendedcourse->get_extended_course($course, $context);

    return array($extendedcourse, $imgurl);
}

function block_orange_paragraph_list_get_courses_list() {

    $utilitiescourse = new utilities_course();
    $courses = $utilitiescourse->get_courses_recommended();

    $choices = array();
    $choices[0] = get_string("selectcourse", 'block_orange_paragraph_list');
    foreach ($courses as $course) {
        $choices[$course->id] = $course->fullname;
    }

    return $choices;
}

function block_orange_paragraph_list_get_events_list() {
    global $DB;

    $events = $DB->get_records_sql('SELECT id, name FROM {event} ' .
                'WHERE eventtype="site" AND visible=1 AND timestart > ' . time());
    $choices = array();
    $choices[0] = get_string("selectevent", 'block_orange_paragraph_list');
    foreach ($events as $event) {
        $choices[$event->id] = $event->name;
    }

    return $choices;
}
