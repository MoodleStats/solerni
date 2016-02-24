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
 * Statistics block overview page
 *
 * @package    block_orange_Statistics
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
use local_orange_library\utilities\utilities_course;
use local_orange_library\extended_course\extended_course_object;
use context_course;

global $DB;

$courseid = optional_param('courseid', SITEID, PARAM_INT);
if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error("No such course id");
}

$context = context_course::instance($courseid, MUST_EXIST);

$extendedcourse = new extended_course_object();
$extendedcourse->get_extended_course($course, $context);

$inactivitydelay=$extendedcourse->inactivitydelay;
echo $inactivitydelay;
// print_r($PAGE->context);

//$context = $PAGE->context;
//$coursecontext = $context->get_course_context();

        //if ($coursecontext) { // No course context for system / user profile.
         //   $courseid = $coursecontext->instanceid;
       // }

// $user = $DB->get_record_sql('SELECT * FROM {user} WHERE id = 1');

// $user->lastcourseaccess    = array(); // During last session.
// $user->currentcourseaccess = array();

    

    // $user->currentcourseaccess = array(); // During current session.
    // if ($lastaccesses = $DB->get_records('user_lastaccess', array('userid' => $user->id))) {
     //   foreach ($lastaccesses as $lastaccess) {
    //        $user->lastcourseaccess[$lastaccess->courseid] = $lastaccess->timeaccess;
     //   }
    // }
    
    
// $sql = 'SELECT u.firstname as Firstname, u.lastname as Lastname FROM {user} u
// WHERE u.currentlogin>= 1454662160
// FROM {course} as c
// JOIN {enrol} as en ON en.courseid = c.course.id
// JOIN {user_enrolments} as ue ON ue.enrolid = en.id
// JOIN {user} as u ON ue.userid = u.id
// where u.course.id='.$COURSE->id;

// $lisusernoactive = $DB->get_record_sql($sql);


//print_r($sql);
