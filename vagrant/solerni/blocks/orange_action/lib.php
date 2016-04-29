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
 * Orange Action block
 *
 * @package    block_orange_action
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/*
 * @todo: write unit tests for this lib
 */

use local_orange_library\utilities\utilities_course;
use local_orange_library\utilities\utilities_user;
use local_orange_library\extended_course\extended_course_object;
use local_orange_library\utilities\utilities_image;


/**
 * Checks whether the current page is the My home page or the my edition page.
 *
 * @todo: make this test part of a library (factor for blocks on my page).
 *
 * @return bool True when on the My home page or the admin template edition (indexsys).
 */
function block_orange_action_on_my_page() {
    global $SCRIPT;

    return $SCRIPT == ('/my/index.php' || '/my/indexsys.php');
}

/**
 * Checks whether the current page is course page.
 *
 * @return bool True when on a course page.
 */
function block_orange_action_on_course_page() {
    global $COURSE;

    return ($COURSE->id > 1);
}

/**
 * Checks whether the current page is forum index page.
 *
 * @return bool True when on a forum index page.
 */
function block_orange_action_on_forum_index_page() {

    return false;
}

/**
 * Checks whether the current page is course dashboard.
 *
 * @return bool True when on a course dashboard.
 */
function block_orange_action_on_course_dashboard_page() {

    return false;
}

/**
 *
 * Check conditions and get course information and content from course id.
 *
 * @global  object  $CFG
 * @global  object  $DB
 * @param   int     $courseid
 *
 * @return mixed string or bool
 */
function block_orange_action_get_course($courseid) {
    global $CFG, $DB, $PAGE;

    if (!$course = $DB->get_record('course', array('id' => $courseid))) {
        error_log('Invalid course id: ' . $courseid . ' Cannot get content for block_orange_action.');
        return false;
    }

    require_once($CFG->libdir. '/coursecatlib.php');
    $context = context_course::instance($course->id);
    $course = new course_in_list($course);

    $imgurl = "";
    foreach ($course->get_course_overviewfiles() as $file) {
        if ($file->is_valid_image()) {
           $imgurl = utilities_image::get_moodle_url_from_stored_file($file);
        }
    }

    // Get Solerni extended informations for the course.
    $extendedcourse = new extended_course_object();
    $extendedcourse->get_extended_course($course, $context);

    if ($extendedcourse->coursestatus === utilities_course::MOOCCLOSED) {
        return false;
    }

    // Get the course last page of the enroled user and replace extended_course button.
    if (isloggedin() && utilities_user::get_user_status($context) == utilities_user::USERENROLLED) {
        require_once($CFG->dirroot.'/local/orange_library/classes/extended_course/button_renderer.php');
        $extendedcourse->displaybutton = block_orange_action_displaybutton($course);
    }

    return $PAGE->get_renderer('block_orange_action')->display_course_on_my_page($course, $extendedcourse, $imgurl);
}

/**
 * return a list of courses
 *
 * @return array()
 */
function block_orange_action_get_courses_list() {

    $utilitiescourse = new utilities_course();
    $courses = $utilitiescourse->get_courses_recommended();

    $choices = array();
    $choices[0] = get_string("selectcourse", 'block_orange_action');
    foreach ($courses as $course) {
        $choices[$course->id] = $course->fullname;
    }

    return $choices;
}

/**
 * Return a list of events.
 *
 * @global object $DB
 * @return array()
 */
function block_orange_action_get_events_list() {
    global $DB;

    $events = $DB->get_records_sql('SELECT id, name FROM {event} ' .
                'WHERE eventtype="site" AND visible=1 AND timestart > ' . time());
    $choices = array();
    $choices[0] = get_string("selectevent", 'block_orange_action');
    foreach ($events as $event) {
        $choices[$event->id] = $event->name;
    }

    return $choices;
}

/**
 *
 * Check conditions and get event information and content from event id.
 *
 * @global  object  $DB
 * @global  object  $CFG
 * @global  object  $PAGE
 * @param   int     $eventid
 * @return  mixed   string or bool
 */
function block_orange_action_get_event($eventid) {
    global $DB, $CFG, $PAGE;

    $query = "SELECT * FROM {event} WHERE id = ? AND timestart >= ? LIMIT 1";

     if (!$event = $DB->get_records_sql($query, array( $eventid, time()))) {
        error_log('Invalid event id: ' . $eventid . ' Cannot get content for block_orange_action.');
        return false;
     }

    $event = array_shift($event);
    $hrefparams['view'] = 'day';
    $eventurl = calendar_get_link_href(new moodle_url(CALENDAR_URL . 'view.php', $hrefparams),
            0, 0, 0, $event->timestart);
    // Image par défaut
    $imgurl = $CFG->dirroot.'/blocks/orange_action/pix/default.jpg';

    return $PAGE->get_renderer('block_orange_action')->display_event_on_my_page($event, $imgurl, $eventurl);
}

/*
 * Generate HTML string for the block action
 */
function block_orange_action_displaybutton($course) {

    $data = utilities_course::get_mooc_learn_menu($course->id);
    $output = html_writer::tag('p', $data->title, array('class' => 'sequence-title pull-left'));
    $output .= html_writer::tag('a',  get_string("gotosequence", 'block_orange_action'),
        array('class' => 'btn btn-default pull-left',
            'href' => $data->url,
            'data-mooc-name' => $course->fullname,
            'title' => $data->title));

    return $output;

}
