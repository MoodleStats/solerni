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
 * @package    orange_library
 * @subpackage enrollment_object
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_orange_library\enrollment;

defined('MOODLE_INTERNAL') || die();

class enrollment_object {

    /**
     *  Get self enrollment instance.
     *
     * @param object $course
     * @return object enrollinstance
     */
    public function get_self_enrolment($course) {

        $instances = enrol_get_instances($course->id, false);
        foreach ($instances as $instanceinfo) {
            if ($instanceinfo->enrol == "self") {
                return $instanceinfo;
            }
        }
    }

    /**
     *  Get self unenrol url.
     *
     * @param object $course
     * @return object unenrol url
     */
    public function get_unenrol_url($course) {

        $instances = enrol_get_instances($course->id, false);
        $plugins   = enrol_get_plugins(true);
        foreach ($instances as $instanceinfo) {
            if ($instanceinfo->enrol == "self") {
                $plugin = $plugins[$instanceinfo->enrol];
                $unenrolurl = $plugin->get_unenrolself_link($instanceinfo);

                return $unenrolurl;
            }
        }
    }

    /**
     *  Get orangeinvitation enrollment instance.
     *
     * @param object $course
     * @return object enrollinstance
     */
    public function get_orangeinvitation_enrolment($course) {

        $instances = enrol_get_instances($course->id, false);
        foreach ($instances as $instanceinfo) {
            if ($instanceinfo->enrol == "orangeinvitation") {
                return $instanceinfo;
            }
        }
        return false;
    }

    /**
     *  Get self enrollment start date.
     *
     * @param object $course
     * @return $timestamp
     */
    public function get_enrolment_startdate($course) {

        $instances = enrol_get_instances($course->id, false);
        $timestamp = strtotime(date('c'));
        foreach ($instances as $instance) {
            if (($instance->enrol == "self" || $instance->enrol == "manual") && $instance->enrolstartdate) {
                $timestamp = $instance->enrolstartdate;
            }
        }

        return $timestamp;
    }

    /**
     *  Get self enrollment end date.
     *
     * @param object $course
     * @return $timestamp
     */
    public function get_enrolment_enddate($course) {

        $instances = enrol_get_instances($course->id, false);
        $timestamp = strtotime(date('c'));
        foreach ($instances as $instance) {
            if (($instance->enrol == "self" || $instance->enrol == "manual") && $instance->enrolenddate) {
                    $timestamp = $instance->enrolenddate;
            }
        }
        return $timestamp;
    }

    /**
     *  Get nb users enrolled using enrolment method.
     *
     * @param object $instance
     * @return $timestamp
     */
    public function count_enrolled_users_by_instance($instance) {
        global $DB;

        return $DB->count_records('user_enrolments', array('enrolid' => $instance->id));
    }

    /**
     *  Get orangenextsession enrollment instance.
     *
     * @param object $course
     * @return object enrollinstance
     */
    public function get_orangenextsession_enrolment($course) {

        $instances = enrol_get_instances($course->id, false);
        foreach ($instances as $instanceinfo) {
            if ($instanceinfo->enrol == "orangenextsession") {
                return $instanceinfo;
            }
        }
        return false;
    }

    /**
     *  Check if user is already enrol for next session.
     *
     * @param object $course
     * @return object enrollinstance
     */
    public function is_enrol_orangenextsession($course) {
        global $DB, $USER;

        $instance = $this->get_orangenextsession_enrolment($course);

        if ($instance && $DB->record_exists('user_enrol_nextsession', array('userid' => $USER->id, 'instanceid' => $instance->id))) {
            return true;
        }

        return false;
    }
}