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


use local_orange_library\utilities\utilities_object;
use local_orange_library\utilities\utilities_course;





    /**
     * Get the closed status from a course.
     *
     * @param object $extendedcourse
     * @return boolean
     */
    function is_closed($extendedcourse) {

        $return = false;
        if ($extendedcourse->enddate == 0) {
            $return = false;
        } elseif (utilities_object::is_after($extendedcourse->enddate)) {
            $return = true;
        }
        return $return;

    }


    /**
     * Return the status of the course
     * Status could be : MOOCRUNNING
     *                          MOOCCLOSED
     *                          MOOCNOTSTARTED
     *
     * @param $extendedcourse
     * @return int $extendedcourse->coursestatus
     */

    function get_course_status(&$extendedcourse, $course) {

        if (is_closed($extendedcourse)) {
            mooc_course_closed($extendedcourse);
        } else if (utilities_object::is_before($course->startdate)) {
            mooc_course_not_started($extendedcourse);
        } else {
            mooc_course_running($extendedcourse);
        }
        return $extendedcourse->coursestatus;
    }

        /**
     * Get the registration not complete status from a course.
     *
     * @param object $extendedcourse
     * @return MOOCNOTCOMPLETE
     */
    function mooc_course_running(&$extendedcourse) {
  //              echo 'mooc_course_running ';
        $extendedcourse->coursestatus = utilities_course::MOOCRUNNING;
        $extendedcourse->coursestatustext = get_string('status_running', 'local_orange_library');
        $extendedcourse->statustext = $extendedcourse->coursestatustext;
        return $extendedcourse;
    }

        /**
     * Get the registration not complete status from a course.
     *
     * @param object $extendedcourse
     * @return MOOCNOTCOMPLETE
     */
    function mooc_course_closed(&$extendedcourse) {
  //                      echo 'mooc_course_closed ';

        $extendedcourse->coursestatustext = get_string('status_closed', 'local_orange_library');
        $extendedcourse->coursestatus = utilities_course::MOOCCLOSED;
         $extendedcourse->statustext = $extendedcourse->coursestatustext;
         return $extendedcourse;
    }

     /**
    * Get the registration not complete status from a course.
    *
    * @param object $extendedcourse
    * @return MOOCNOTCOMPLETE
    */
    function mooc_course_not_started(&$extendedcourse) {
  //                      echo 'mooc_course_not_started ';
        $extendedcourse->coursestatustext = get_string('status_default', 'local_orange_library');
        $extendedcourse->coursestatus = utilities_course::MOOCNOTSTARTED;
        $extendedcourse->statustext = $extendedcourse->coursestatustext;
        return $extendedcourse;
    }

