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
     *  Get self enrollment instance.
     *
     * @param moodle_url $imgurl
     * @param object $course
     * @param object $context
     * @return string $text
     */
    public function get_enrolment_startdate($course) {

        $instances = enrol_get_instances($course->id, false);
        $timestamp = strtotime(date('c'));
        foreach ($instances as $instance) {
            if ($instance->enrolstartdate) {
                $timestamp = strtotime($instance->enrolstartdate);
            }
        }

        return $timestamp;
    }

    /**
     *  Get self enrollment instance.
     *
     * @param moodle_url $imgurl
     * @param object $course
     * @param object $context
     * @return string $text
     */
    public function get_enrolment_enddate($course) {

        $instances = enrol_get_instances($course->id, false);
        $timestamp = strtotime(date('c'));
        foreach ($instances as $instance) {
            if (($instance->enrol == "self" || $instance->enrol == "manual")&&$instance->enrolenddate) {
                    $timestamp = $instance->enrolenddate;
            }
        }
        return $timestamp;
    }
}
