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



class inactive_users_testcase extends advanced_testcase { 
    
    public static function test_retreive_inactive_users() {
        global $DB;
        
        $lastaccess =new stdClass();
        $lastaccess->id = 1;
        $lastaccess->userid = 1;
        $lastaccess->courseid= 1;
        $lastaccess2 =new stdClass();
        $lastaccess2->id = 2;
        $lastaccess2->userid = 2;
        $lastaccess2->courseid= 2;
        $DB->insert_record('user_lastaccess', $lastaccess, false);
        $DB->insert_record('user_lastaccess', $lastaccess2, false);
        $course = $DB->get_records_sql("SELECT DISTINCT courseid
                                        FROM {user_lastaccess}")
                                        ;
        //var_dump($course);
        //$idsite = $DB->get_record_sql('SELECT piwik_siteid FROM {piwik_site} WHERE courseid = ?', array($event->courseid));
        print_object($course);
    }
}