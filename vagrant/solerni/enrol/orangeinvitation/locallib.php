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
//
// The GNU General Public License
// can be see at <http://www.gnu.org/licenses/>.

defined('MOODLE_INTERNAL') || die();

define ('ACTION_FINDOUTMORE'              , 0);
define ('ACTION_ENROLTOCOURSE'            , 1);
define ('ACTION_ENROLNEXTSESSION'         , 2);

use local_orange_library\utilities\utilities_course;
use local_orange_library\extended_course\extended_course_object;

class invitation_manager {

    /*
     * The invitation enrol instance of a course
     */
    private $enrolinstance = null;

    /*
     * The course id
     */
    private $courseid = null;

    /**
     *
     * @param type $courseid 
     */
    public function __construct($courseid, $instancemustexist = true) {
        $this->courseid = $courseid;
        $this->enrolinstance = $this->get_invitation_instance($courseid, $instancemustexist);
    }

    /**
     * Return the invitation instance for a specific course
     * Note: as using $PAGE variable, this functio can only be called in a Moodle script page
     * @global object $PAGE
     * @param int $courseid
     * @param boolean $mustexist when set, an exception is thrown if no instance is found
     * @return type 
     */
    public function get_invitation_instance($courseid, $mustexist = false) {
        global $PAGE, $CFG, $DB;

        if (($courseid == $this->courseid) and !empty($this->enrolinstance)) {
            return $this->enrolinstance;
        }

        // Find enrolment instance.
        $instance = null;
        require_once("$CFG->dirroot/enrol/locallib.php");
        $course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
        $manager = new course_enrolment_manager($PAGE, $course);
        foreach ($manager->get_enrolment_instances() as $tempinstance) {
            if ($tempinstance->enrol == 'orangeinvitation') {
                if ($instance === null) {
                    $instance = $tempinstance;
                }
            }
        }

        if ($mustexist and empty($instance)) {
            throw new moodle_exception('noinvitationinstanceset', 'enrol_orangeinvitation');
        }

        return $instance;

    }

}
/**
 * This function manage the redirection to a course if the access has been  
 * done using the enrolment URL to the course => a cookie is set in this case
 * @param cookie or token/courseid/enrol
 * @return array
 */
function check_course_redirection ($cookie=null, $enrolinvitationtoken=null, $courseid=null, $action=null) {
    global $DB, $USER;

   
    if ($cookie != null) {
        // Decrypt cookie content token-courseId.
        $cookiecontent = explode("-", rc4decrypt($cookie));
        $enrolinvitationtoken = $cookiecontent[0];
        $courseid = $cookiecontent[1];
        if (isset($cookiecontent[2])) {
            $action = $cookiecontent[2];
        } else {
            $action = 0;
        }
    }

    $message = "";

    // Retrieve the token info.
    $invitation = $DB->get_record('enrol_orangeinvitation', array('token' => $enrolinvitationtoken));
    // If token is valid, enrol the user into the course.
    if (empty($invitation) or empty($invitation->courseid) or ($invitation->courseid != $courseid)) {
        $message = get_string('expiredtoken', 'enrol_orangeinvitation');
    }

    $courseutilities = new utilities_course();
    $course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
    $findoutmoreurl = $courseutilities->get_description_page_url($course);

    $context = context_course::instance($courseid, MUST_EXIST);
    
    // Get.
    $invitationmanager = new invitation_manager($courseid);
    $instance = $invitationmanager->get_invitation_instance($courseid);
    if ($instance->status == 1) {
        // The URL Link is not activated.
        $message = get_string('linknotactivated', 'enrol_orangeinvitation');
    }

    // Do we have to enrol the user.
    if ($action == ACTION_FINDOUTMORE) {
        $courseurl = $findoutmoreurl;
    } else if ($action == ACTION_ENROLTOCOURSE) {
        // This is only possible if the self enrolment method exist and is activated.
        $instances = enrol_get_instances ($courseid, true);
        if (count($instances) == 0) {
            // Error, the user can't enrol.
            $message = get_string('selfenrolnotavailable', 'enrol_orangeinvitation');
        } else {
            $instances = array_filter ($instances, function ($element) {
                return $element->enrol == "self";
            });
            if (count($instances) == 1) {
                $selfenrol = new enrol_self_plugin();
                $instanceself = array_pop($instances);
                // Test that the user is not already enrolled; Already done in can_self_enrol but
                // wrong error message.
                if ($DB->get_record('user_enrolments', array('userid' => $USER->id, 'enrolid' => $instanceself->id))) {
                    // If we need to display a specific message.
                } else {
                    $enrolstatus = $selfenrol->can_self_enrol($instanceself);
                    if (true === $enrolstatus) {
                        $selfenrol->enrol_self($instanceself);
                    } else {
                        $message = $enrolstatus;
                    }
                }
            } else {
                $message = get_string('selfenrolnotavailable', 'enrol_orangeinvitation');
            }
        }

        if ($message == "") {
            $courseurl = new moodle_url('/course/view.php', array('id' => $courseid));
        } else {
            $courseurl = new moodle_url('/');
        }

    } else if ($action == ACTION_ENROLNEXTSESSION) {
        // This is only possible if the wait list enrolment method exist and is activated.
        $instances = enrol_get_instances ($courseid, true);
        if (count($instances) == 0) {
            // Error, the user can't enrol.
            $message = get_string('nextsessionnotavailable', 'enrol_orangeinvitation');
        } else {
            $instancewaitlist = array_filter ($instances, function ($element) {
                return $element->enrol == "orangenextsession";
            });
            if (count($instancewaitlist) == 1) {
                // The registration status of the course should be MOOCCOMPLETED
                $extendedcourse = new extended_course_object();
                $extendedcourse->get_extended_course($course, $context);

                if ($extendedcourse->registrationstatus == utilities_course::MOOCCOMPLETE) {
                    $waitlistenrol = new enrol_orangenextsession_plugin();
                    $instancewaitlist = array_pop($instancewaitlist);
                    $enrolstatus = $waitlistenrol->enrol_orangenextsession($instancewaitlist);
                    if (true === $enrolstatus) {

                    } else {
                        $message = $enrolstatus;
                    }
                    $courseurl = $findoutmoreurl;
                } else {
                    $message = get_string('nextsessionnotavailable', 'enrol_orangeinvitation');
                }
            } else {
                $message = get_string('nextsessionnotavailable', 'enrol_orangeinvitation');
            }
        }
    }

    if (!isset($courseurl)) {
        $courseurl = new moodle_url('/');
    }

    setcookie ( 'MoodleEnrolToken', '', time() - 3600, '/');
    redirect($courseurl, $message);

}
