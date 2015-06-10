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
 * @subpackage utilities
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_orange_library\utilities;
defined('MOODLE_INTERNAL') || die();

class utilities_object {

    public function duration_to_time($duration) {
        $secondsinaminute = 60;
        $secondsinanhour = 60 * $secondsinaminute;
        $secondsinaday = 24 * $secondsinanhour;
        $secondsinaweek = 7 * $secondsinaday;

        $weeks = floor($duration / $secondsinaweek);
        // Extract days.
        $dayseconds = $duration % $secondsinaweek;
        $days = floor($dayseconds / $secondsinaday);

        // Extract hours.
        $hourseconds = $duration % $secondsinaday;
        $hours = floor($hourseconds / $secondsinanhour);

        // Extract minutes.
        $minuteseconds = $duration % $secondsinanhour;
        $minutes = floor($minuteseconds / $secondsinaminute);

        // Extract the remaining seconds.
        $remainingseconds = $duration % $secondsinaminute;
        $seconds = ceil($remainingseconds);

        $text = "";

        if ($weeks > 0) {
            $text = $weeks." ".get_string('week', 'block_orange_course_extended'). " ".$text;
        } else if ($days > 0) {
            $text = $days." ".get_string('day', 'block_orange_course_extended'). " ".$text;
        }
        if ($hours > 0) {
            $text = $hours." ".get_string('hour', 'block_orange_course_extended'). " ".$text;
        }
        if ($minutes > 0) {
            $text = $minutes." ".get_string('minute', 'block_orange_course_extended'). " ".$text;
        }
        if ($seconds > 0) {
            $text = $seconds." ".get_string('second', 'block_orange_course_extended'). " ".$text;
        }
        return $text;
    }

    /**
     * Get the number of users enrelloedin the course
     *
     * @param object $course
     * @return int $nbenrolledusers
     */
    public function get_nb_users_enrolled_in_course ($course) {
        global $DB;
        $courseid = $course->id;
        $sqlrequest = "SELECT DISTINCT u.id AS userid, c.id AS courseid
        FROM mdl_user u
        JOIN mdl_user_enrolments ue ON ue.userid = u.id
        JOIN mdl_enrol e ON e.id = ue.enrolid
        JOIN mdl_role_assignments ra ON ra.userid = u.id
        JOIN mdl_context ct ON ct.id = ra.contextid AND ct.contextlevel = 50
        JOIN mdl_course c ON c.id = ct.instanceid AND e.courseid = ". $courseid."
        JOIN mdl_role r ON r.id = ra.roleid AND r.shortname = 'student'
        WHERE e.status = 0 AND u.suspended = 0 AND u.deleted = 0
        AND (ue.timeend = 0 OR ue.timeend > NOW()) AND ue.status = 0";
        $enrolledusers = $DB->get_records_sql($sqlrequest);
        $nbenrolledusers = count ($enrolledusers);
        return $nbenrolledusers;
    }


    /**
     *  Get the category ID of a course.
     *
     * @return int $categoryid
     */
    public function get_categoryid() {
        global $PAGE, $DB;
         $context = $PAGE->context;
        $coursecontext = $context->get_course_context();
        $categoryid = null;
        if ($coursecontext) { // No course context for system / user profile
            $courseid = $coursecontext->instanceid;
            $course = $DB->get_record('course', array('id' => $courseid), 'id, category');
            if ($course) { // Should always exist, but just in case ...
                $categoryid = $course->category;
            }
        }
        return $categoryid;
    }

    /**
     * Set the extended course values from config.
     *
     * @param object $context
     * @return object $this->extendedcourse
     */
    public function get_categoryid_by_courseid($courseid) {
        global $DB;
        $categoryid = NULL;
        $course = $DB->get_record('course', array('id' => $courseid), 'id, category');
        if ($course) { // Should always exist, but just in case ...
            $categoryid = $course->category;
        }
        return $categoryid;
    }



}


