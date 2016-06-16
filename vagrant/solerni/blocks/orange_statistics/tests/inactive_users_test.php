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
        
        //penser truncate table de la nouvelle table
        
        //Création de la nouvelle table mdl_user_drop
        //create table 
        
        //jeu de données
        $lastaccess =new stdClass();
        $lastaccess->id = 1;
        $lastaccess->userid = 1;
        $lastaccess->courseid= 1;
        $lastaccess->timeaccess= 1465827847;
        $lastaccess2 =new stdClass();
        $lastaccess2->id = 2;
        $lastaccess2->userid = 2;
        $lastaccess2->courseid= 2;
        $lastaccess2->timeaccess= 1465827847;
        $lastaccess3 =new stdClass();
        $lastaccess3->id = 3;
        $lastaccess3->userid = 3;
        $lastaccess3->courseid= 1;
        $lastaccess3->timeaccess= 1434205447;
        $lastaccess4 =new stdClass();
        $lastaccess4->id = 4;
        $lastaccess4->userid = 4;
        $lastaccess4->courseid= 2;
        $lastaccess4->timeaccess= 1434205447;
        
        $coursesormat = new stdClass();
        $coursesormat->id = 1;
        $coursesormat->courseid= 1;
        $coursesormat->name= 'courseinactivitydelay';
        $coursesormat->value = 9;
        $coursesormat2 = new stdClass();
        $coursesormat2->id = 2;
        $coursesormat2->courseid= 2;
        $coursesormat2->name= 'courseinactivitydelay';
        $coursesormat2->value = 10;
        
        $DB->insert_record('user_lastaccess', $lastaccess, false);
        $DB->insert_record('user_lastaccess', $lastaccess2, false);
        $DB->insert_record('user_lastaccess', $lastaccess3, false);
        $DB->insert_record('user_lastaccess', $lastaccess4, false);
        
        $DB->insert_record('course_format_options', $coursesormat, false);
        $DB->insert_record('course_format_options', $coursesormat2, false);
        
        $courses = $DB->get_records_sql("SELECT DISTINCT courseid
                                        FROM {user_lastaccess}")
                                        ;
        foreach($courses as $course) {
          print_r($course->courseid) ;
          echo "\n"; 
          $courseinactivitydelay= $DB->get_record_sql("SELECT value FROM {course_format_options} WHERE name = 'courseinactivitydelay' and courseid =?", array($course->courseid));
          print_r($courseinactivitydelay->value);
          echo "\n"; 
          $users = $DB->get_records_sql("SELECT userid, timeaccess FROM {user_lastaccess} where courseid  =?", array($course->courseid));
          foreach ($users as $user) {
              if  ($user->timeaccess+86400*($courseinactivitydelay->value)<time()) {
              print_r($user->timeaccess);
              echo "\n";
              print_r('pasbien');
              $DB->insert_record(user_dropout, $dataobject, $returnid=true, $bulk=false);
              }
          }
         }
    }
}