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
 * orange library MNET cron task.
 *
 * @package    orange_library
 * @subpackage utilities
 * @copyright  2016 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class inactive_users  {
    

    public static function retreive_inactive_users() {
        global $DB;
        $course_id = $DB->get_recordset_sql("SELECT DISTINCT courseid
                                        FROM {user_lastaccess}"
                                        );
        print_objet($course_id);
    }
}
        //foreach ($course_id as $idcourse) {
            //$courseinactivitydelay= get_recordset_sql("SELECT value FROM {course_format_options WHERE name = ?" , array($) }"
        //}
          //  $users = $DB->get_recordset_sql("SELECT *
                                           // FROM {user_lastaccess} WHERE courseid = ?" , array($idcourse);
         //   foreach ($users)
                      //  $user->timeaccess