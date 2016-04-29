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
 * @return $extendedcourse->registrationstatus
 */
function set_registration_status($extendedcourse) {

    if (utilities_object::is_before($extendedcourse->enrolstartdate)) {

        mooc_registration_not_open($extendedcourse);
    } else if ($extendedcourse->enrolledusersself >= $extendedcourse->maxregisteredusers &&
            $extendedcourse->maxregisteredusers != 0) {

        mooc_registration_open_complete($extendedcourse);
    } else if (utilities_object::is_after($extendedcourse->enrolenddate)) {

        mooc_registration_stopped($extendedcourse);
    } else {
        mooc_registration_open($extendedcourse);
    }
    return $extendedcourse->registrationstatus;
}

/**
 * Set the registration status, registration status text and status text when registration is open..
 *
 * @param object $extendedcourse
 * @return NONE
 */
function mooc_registration_open(&$extendedcourse) {
    $extendedcourse->registrationstatus = \local_orange_library\utilities\utilities_course::MOOCREGISTRATIONOPEN;
    $extendedcourse->registrationstatustext = get_string('registration_open', 'local_orange_library');
    $extendedcourse->statustext = $extendedcourse->registrationstatustext;
}

/**
 * Set the registration status, registration status text and status text when registration is not open.
 *
 * @param object $extendedcourse
 * @return NONE
 */
function mooc_registration_not_open(&$extendedcourse) {
    $extendedcourse->registrationstatus = \local_orange_library\utilities\utilities_course::MOOCREGISTRATIONNOTOPEN;
    $extendedcourse->registrationstatustext = get_string('registration_not_open', 'local_orange_library');
    $extendedcourse->statustext = $extendedcourse->registrationstatustext;
}

/**
 * Set the registration status, registration status text and status text when registration is complete.
 *
 * @param object $extendedcourse
 * @return NONE
 */
function mooc_registration_open_complete(&$extendedcourse) {
    $extendedcourse->registrationstatus = \local_orange_library\utilities\utilities_course::MOOCREGISTRATIONCOMPLETE;
    $extendedcourse->registrationstatustext = get_string('mooc_complete', 'local_orange_library');
    $extendedcourse->statustext = $extendedcourse->registrationstatustext;
}

/**
 * Set the registration status, registration status text and status text when registration is stopped.
 *
 * @param object $extendedcourse
 * @return NONE
 */
function mooc_registration_stopped(&$extendedcourse) {
    $extendedcourse->registrationstatus = \local_orange_library\utilities\utilities_course::MOOCREGISTRATIONSTOPPED;
    $extendedcourse->registrationstatustext = get_string('registration_closed', 'local_orange_library');
    $extendedcourse->statustext = $extendedcourse->registrationstatustext;
}
