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
        /**
     * Return the registration status of the course
     * Status could be : MOOCNOTCOMPLETE
     *                          MOOCCOMPLETE
     *                          MOOCREGISTRATIONSTOPPED
     *
     * @param $extendedcourse
     * @return int
     */
    function set_registration_status($extendedcourse) {

        if (utilities_object::is_before($extendedcourse->enrolstartdate)) {
            //echo 'mooc_registration_not_open';
            mooc_registration_not_open($extendedcourse);
        } else if ($extendedcourse->enrolledusers >= $extendedcourse->maxregisteredusers) {
//            echo 'mooc_registration_open_complete';
            mooc_registration_open_complete($extendedcourse);
        } else if (utilities_object::is_after($extendedcourse->enrolenddate)) {
            //echo 'mooc_registration_stopped';
            mooc_registration_stopped($extendedcourse);
        } else {
            //echo 'mooc_registration_open';
            mooc_registration_open($extendedcourse);
        }
        return $extendedcourse->registrationstatus;
    }

        /**
     * Get the registration not complete status from a course.
     *
     * @param object $extendedcourse
     * @return MOOCNOTCOMPLETE
     */
    function mooc_registration_open(&$extendedcourse) {
        //echo 'mooc_registration_open ';
        $extendedcourse->registrationstatus = \local_orange_library\utilities\utilities_course::MOOCREGISTRATIONOPEN;
        $extendedcourse->registrationstatustext = get_string('registration_open', 'local_orange_library');
        $extendedcourse->statustext = $extendedcourse->registrationstatustext;
    }

    /**
     * Get the registration not complete status from a course.
     *
     * @param object $extendedcourse
     * @return MOOCNOTCOMPLETE
     */
    function mooc_registration_not_open(&$extendedcourse) {
        //echo 'mooc_registration_not_open ';
        $extendedcourse->registrationstatus = \local_orange_library\utilities\utilities_course::MOOCREGISTRATIONNOTOPEN;
        $extendedcourse->registrationstatustext = get_string('registration_not_open', 'local_orange_library');
        $extendedcourse->statustext = $extendedcourse->registrationstatustext;
    }

    /**
     * Get the registration complete status from a course.
     *
     * @param object $extendedcourse
     * @return MOOCCOMPLETE
     */
    function mooc_registration_open_complete(&$extendedcourse) {
//        echo 'mooc_registration_open_complete ';
        $extendedcourse->registrationstatus = \local_orange_library\utilities\utilities_course::MOOCREGISTRATIONCOMPLETE;
        $extendedcourse->registrationstatustext = get_string('mooc_complete', 'local_orange_library');
        $extendedcourse->statustext = $extendedcourse->registrationstatustext;
    }

    /**
     * Get the registration stopped status from a course.
     *
     * @param object $extendedcourse
     * @return MOOCREGISTRATIONSTOPPED
     */
    function mooc_registration_stopped(&$extendedcourse) {
        //echo 'mooc_registration_stopped ';
        $extendedcourse->registrationstatus = \local_orange_library\utilities\utilities_course::MOOCREGISTRATIONSTOPPED;
        $extendedcourse->registrationstatustext = get_string('registration_closed', 'local_orange_library');
        $extendedcourse->statustext = $extendedcourse->registrationstatustext;
    }


