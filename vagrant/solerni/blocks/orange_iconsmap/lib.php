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
 * Orange Icons Map
 *
 * @package    block_orange_iconsmap
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use local_orange_library\utilities\utilities_image;
use local_orange_library\utilities\utilities_course;
use local_orange_library\extended_course\extended_course_object;



/**
 * Checks whether the current page is course page.
 *
 * @return bool True when on a course page.
 */
function block_orange_iconsmap_is_on_course_page() {
    Global $COURSE;

    return ($COURSE->id > 1);
}

function block_orange_iconsmap_get_course ($course) {
    Global $CFG;

    $context = context_course::instance($course->id);

    $imgurl = "";
    if ($course instanceof stdClass) {
        require_once($CFG->libdir. '/coursecatlib.php');
        $course = new course_in_list($course);
    }

    $extendedcourse = new extended_course_object();
    $extendedcourse->get_extended_course($course, $context);

    return $extendedcourse;
}

