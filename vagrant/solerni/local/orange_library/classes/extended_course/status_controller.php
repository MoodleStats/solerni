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

use local_orange_library\utilities\utilities_course;
use local_orange_library\utilities\utilities_user;

/**
 *  Set and display the button describing the status of a course.
 *
 * @param object $extendedcourse
 * @return NONE
 */
function set_course_status($course, $context, &$extendedcourse) {

    $registrationstatus = set_registration_status($extendedcourse);
    $coursestatus = get_course_status($extendedcourse, $course);

    if ($coursestatus == utilities_course::MOOCCLOSED) {

        $extendedcourse = controller_mooc_ended_registration_closed($context, $course, $extendedcourse);

    } else {
        $extendedcourse = controller($coursestatus, $registrationstatus, $context, $course, $extendedcourse);

    }
    return $coursestatus;
}

/**
 * controller for setting extended course button and status
 *
 * @param none
 * @return call to another function
 * */
function controller($coursestatus, $registrationstatus, $context, $course, $extendedcourse) {
    switch ($registrationstatus) {

        case utilities_course::MOOCREGISTRATIONOPEN:
            if ($coursestatus == utilities_course::MOOCRUNNING) {
                $extendedcourse = controller_mooc_running_registration_available($context, $course, $extendedcourse);
            } else {
                $extendedcourse = controller_mooc_incoming_registration_available($context, $course, $extendedcourse);
            }
             break;

        case utilities_course::MOOCREGISTRATIONNOTOPEN:
            if ($coursestatus == utilities_course::MOOCRUNNING) {
                $extendedcourse = controller_mooc_running_registration_not_started($context, $course, $extendedcourse);
            } else {
                $extendedcourse = controller_mooc_incoming_registration_not_started($context, $course, $extendedcourse);
            }
            break;

        case (utilities_course::MOOCREGISTRATIONSTOPPED):
            if ($coursestatus == utilities_course::MOOCRUNNING) {
                 $extendedcourse = controller_mooc_running_registration_not_available($context, $course, $extendedcourse);
            } else {
                $extendedcourse = controller_mooc_incoming_registration_not_available($context, $course, $extendedcourse);
            }
            break;

        case (utilities_course::MOOCREGISTRATIONCOMPLETE):
            if ($coursestatus == utilities_course::MOOCRUNNING) {
                 $extendedcourse = controller_mooc_running_registration_not_available($context, $course, $extendedcourse);
            } else {
                $extendedcourse = controller_mooc_incoming_registration_not_available($context, $course, $extendedcourse);
            }
            break;
    }
    return $extendedcourse;
}

/**
 * settings for mooc in coming and registration not started
 *
 * @param $context
 * @param $course
 * @param &$extendedcourse
 * @return $extendedcourse
 * */
function controller_mooc_incoming_registration_not_started($context, $course, &$extendedcourse) {
    $userstatus = utilities_user::get_user_status($context);

    if ($userstatus == utilities_user::USERENROLLED) {

        incoming_unsubscribe($course, $extendedcourse);

    } else {

        $extendedcourse->statuslink = "#";
        $extendedcourse->statustext = get_string('status_default', 'local_orange_library');
        $extendedcourse->displaybutton = display_button('subscribe_to_mooc', '#', "btn btn-default disabled", $course);
    }

    return $extendedcourse;
}

/**
 * settings for mooc running and registration not started
 *
 * @param $context
 * @param $course
 * @param &$extendedcourse
 * @return $extendedcourse
 * */
function controller_mooc_running_registration_not_started($context, $course, &$extendedcourse) {
    $userstatus = utilities_user::get_user_status($context);

    if ($userstatus == utilities_user::USERENROLLED) {

        running_unsubscribe($course, $extendedcourse);

    } else {

        $extendedcourse->statuslink = "#";
        $extendedcourse->statustext = get_string('status_running', 'local_orange_library');
        $extendedcourse->displaybutton = display_button('subscribe_to_mooc', '#', "btn btn-default disabled", $course);
    }

    return $extendedcourse;
}

/**
 * settings for mooc in coming and registration available
 *
 * @param $context
 * @param $course
 * @param &$extendedcourse
 * @return $extendedcourse
 * */
function controller_mooc_incoming_registration_available($context, $course, &$extendedcourse) {
    $userstatus = utilities_user::get_user_status($context);

    if ($userstatus == utilities_user::USERENROLLED) {

        incoming_unsubscribe($course, $extendedcourse);

    } else {

        $extendedcourse->statuslink = "#";
        $extendedcourse->statustext = get_string('status_default', 'local_orange_library');
        $extendedcourse->displaybutton = display_button('subscribe_to_mooc', $extendedcourse->enrolurl,
                "btn btn-engage tag-course-subscription", $course);

    }

    return $extendedcourse;
}

/**
 * settings for mooc in coming and registration not available
 *
 * @param $context
 * @param $course
 * @param &$extendedcourse
 * @return $extendedcourse
 * */
function controller_mooc_incoming_registration_not_available($context, $course, &$extendedcourse) {
    $userstatus = utilities_user::get_user_status($context);

    if ($userstatus == utilities_user::USERENROLLED) {

            incoming_unsubscribe($course, $extendedcourse);

    } else {

        if ($userstatus == utilities_user::USERLOGGED) {

            new_session($course, $extendedcourse);
            $extendedcourse->statustext = get_string('registration_closed', 'local_orange_library');

        } else {

            $extendedcourse->statuslink = "#";
            $extendedcourse->statustext = get_string('registration_closed', 'local_orange_library');
            $extendedcourse->displaybutton = display_button('subscribe_to_mooc', '#', "btn btn-default disabled", $course);
        }
    }

    return $extendedcourse;
}

/**
 * settings for mooc running and registration available
 *
 * @param $context
 * @param $course
 * @param &$extendedcourse
 * @return $extendedcourse
 * */
function controller_mooc_running_registration_available($context, $course, &$extendedcourse) {
    $userstatus = utilities_user::get_user_status($context);

    if ($userstatus == utilities_user::USERENROLLED) {

        running_unsubscribe($course, $extendedcourse);
        $extendedcourse->statuslink = $extendedcourse->unenrolurl;

    } else {

        $extendedcourse->statuslink = "#";
        $extendedcourse->statustext = get_string('status_running', 'local_orange_library');
        $extendedcourse->displaybutton = display_button('subscribe_to_mooc', $extendedcourse->enrolurl,
                "btn btn-engage tag-course-subscription", $course);

    }

    return $extendedcourse;
}

/**
 * settings for mooc running and registration not availabled
 *
 * @param $context
 * @param $course
 * @param &$extendedcourse
 * @return $extendedcourse
 * */
function controller_mooc_running_registration_not_available($context, $course, &$extendedcourse) {
    $userstatus = utilities_user::get_user_status($context);

    if ($userstatus == utilities_user::USERENROLLED) {

        course_running_button_enabled($course, $extendedcourse);
        $extendedcourse->displaybutton = display_button('access_to_mooc', $extendedcourse->moocurl, "btn btn-success", $course);

    } else {

        if ($userstatus == utilities_user::USERLOGGED) {

            new_session($course, $extendedcourse);

        } else {

            $extendedcourse->statuslink = "#";
            $extendedcourse->displaybutton = display_button('subscribe_to_mooc', '#', "btn btn-default disabled", $course);

        }

        $extendedcourse->statustext = get_string('registration_closed', 'local_orange_library');
    }

    return $extendedcourse;
}

/**
 * settings for mooc end and registration closed
 *
 * @param $context
 * @param $course
 * @param &$extendedcourse
 * @return $extendedcourse
 * */
function controller_mooc_ended_registration_closed($context, $course, &$extendedcourse) {
    $userstatus = \local_orange_library\utilities\utilities_user::get_user_status($context);

    if ($userstatus == \local_orange_library\utilities\utilities_user::USERENROLLED) {

        $extendedcourse->statuslink = "#";
        $extendedcourse->statustext = get_string('status_closed', 'local_orange_library');
        $extendedcourse->displaybutton = display_button('acces_to_archive', $extendedcourse->moocurl, "btn btn-success", $course);

    } else {

        if ($userstatus == \local_orange_library\utilities\utilities_user::USERLOGGED) {

            new_session($course, $extendedcourse);
            $extendedcourse->statustext = get_string('status_closed', 'local_orange_library');

        } else {

            $extendedcourse->statuslink = "#";
            $extendedcourse->statustext = get_string('status_closed', 'local_orange_library');
            $extendedcourse->displaybutton = display_button('subscribe_to_mooc', '#', "btn btn-default disabled", $course);
        }
    }

    return $extendedcourse;
}

/**
 * settings for mooc in coming and user unsubscription allowed
 *
 * @param $context
 * @param $course
 * @param &$extendedcourse
 * @return $extendedcourse
 * */
function incoming_unsubscribe($course, &$extendedcourse) {
    global $PAGE;
    $pagetype = $PAGE->pagetype;
    if ($pagetype == 'moocs-mymoocs') {
        $extendedcourse->statuslink = $extendedcourse->unenrolurl;
        $extendedcourse->statuslinktext = get_string('unsubscribe', 'local_orange_library');

    } else {
        $extendedcourse->statuslink = '#';
        $extendedcourse->statuslinktext = '';

    }
    $extendedcourse->displaybutton = display_button('subscribe_to_mooc', '#', "btn btn-default disabled", $course);
}

/**
 * settings for mooc running and user unsubscription allowed
 *
 * @param $context
 * @param $course
 * @param &$extendedcourse
 * @return $extendedcourse
 * */
function running_unsubscribe($course, &$extendedcourse) {
    global $PAGE;
    $pagetype = $PAGE->pagetype;
    if ($pagetype == 'moocs-mymoocs') {

        $extendedcourse->statuslink = $extendedcourse->unenrolurl;
        $extendedcourse->statuslinktext = get_string('unsubscribe', 'local_orange_library');

    } else {
        $extendedcourse->statuslink = "#";
        $extendedcourse->statuslinktext = '';

    }
    $extendedcourse->displaybutton = display_button('access_to_mooc', $extendedcourse->moocurl, "btn btn-success", $course);
}

/**
 * settings for mooc new session
 *
 * @param $context
 * @param $course
 * @param &$extendedcourse
 * @return $extendedcourse
 * */
function new_session($course, &$extendedcourse) {
    global $PAGE;
    $pagetype = $PAGE->pagetype;

    if ($pagetype == 'mod-descriptionpage-view') {
        $extendedcourse->statuslink = $extendedcourse->newsessionurl;
        $extendedcourse->statuslinktext = get_string('new_session', 'local_orange_library');

    } else {
        $extendedcourse->statuslink = "#";
        $extendedcourse->statuslinktext = '';

    }
    $extendedcourse->displaybutton = display_button('subscribe_to_mooc', '#', "btn btn-default disabled", $course);
}

/**
 * settings subscription closed
 *
 * @param $context
 * @param $course
 * @param &$extendedcourse
 * @return $extendedcourse
 * */
function subscription_closed($course, &$extendedcourse) {
    $extendedcourse->statuslink = "#";
    $extendedcourse->displaybutton = display_button('subscribe_to_mooc', '#', "btn btn-default disabled", $course);
}

/**
 * settings for mooc running and button enabled
 *
 * @param $context
 * @param $course
 * @param &$extendedcourse
 * @return $extendedcourse
 * */
function course_running_button_enabled($course, &$extendedcourse) {
    global $PAGE;
    
    $pagetype = $PAGE->pagetype;
    
    $extendedcourse->statuslink = $extendedcourse->unenrolurl;
    $extendedcourse->statuslinktext = get_string('unsubscribe', 'local_orange_library');

    $extendedcourse->statustext = get_string('status_running', 'local_orange_library');
    $extendedcourse->displaybutton = display_button('access_to_mooc', $extendedcourse->moocurl, "btn btn-success", $course);
}
