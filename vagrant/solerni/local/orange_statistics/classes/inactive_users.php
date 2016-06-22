<?php
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

namespace local_orange_statistics;
defined('MOODLE_INTERNAL') || die();


class inactive_users  {

    public static function retrieve_inactive_users() {
        global $DB;
        $dataobject = new \stdClass();
        $currentdate = new \DateTime(gmdate('Y-m-d H:i:s', time()));
        $tablename = 'mdl_user_dropout';
        if ($DB->get_manager()->table_exists('user_dropout')) {
            $DB->execute('TRUNCATE TABLE '.$tablename);
        }
        $courses = $DB->get_records_sql("SELECT DISTINCT courseid FROM {user_lastaccess}");

        foreach ($courses as $course) {
            $courseinactivitydelay = $DB->get_record_sql("SELECT value FROM {course_format_options} WHERE name = 'courseinactivitydelay' and courseid =?", array($course->courseid));
            if (!$courseinactivitydelay) {
                $courseinactivitydelay = new \stdClass();
                $courseinactivitydelay->value = 7;
            }
            $users = $DB->get_records_sql("SELECT userid, timeaccess FROM {user_lastaccess} where courseid  =?", array($course->courseid));
            foreach ($users as $user) {
                $timecalc = $user->timeaccess + 86400 * ($courseinactivitydelay->value);
                $potentialdate = new \DateTime(gmdate('Y-m-d H:i:s', $timecalc));
                $interval = $potentialdate->diff($currentdate);
                if (($interval->invert) == 0) {
                    $dataobject->userid = $user->userid;
                    $dataobject->courseid = $course->courseid;
                    $dataobject->days = $interval->days;
                    $DB->insert_record('user_dropout', $dataobject, $returnid = true, $bulk = false);
                }
            }
        }
    }
}