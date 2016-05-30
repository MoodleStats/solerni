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
 * Helper functions for orange_course_home block
 *
 * @package    block_orange_course_home
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use local_orange_library\utilities\utilities_course;

/**
 * Return sorted list of  courses
 *
 * @param int maxcourses to retreive.
 * @return array list of sorted courses and count of courses.
 */
function block_orange_course_home_get_courses($maxcourses = 3) {
    if (empty($maxcourses)) {
        return array(array(), 0);
    }
    $utilitiescourse = new utilities_course();

    // We ask for one course more to detect if we have the Catalog button to display.
    $courses = $utilitiescourse->get_courses_catalogue(new stdclass(), array('limit' => ($maxcourses + 1)));
    $displaycatalogbutton = (count($courses) > $maxcourses);
    $courses = array_slice($courses, 0, $maxcourses, true);

    return array($courses, $displaycatalogbutton);
}