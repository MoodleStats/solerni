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


// Performance hacks - we preload user contexts together with accounts.
$ccselect = ', ' . context_helper::get_preload_record_columns_sql('ctx');
print_object($ccselect);
$ccjoin = "LEFT JOIN {context} ctx ON (ctx.instanceid = u.id AND ctx.contextlevel = :contextlevel)";
$params['contextlevel'] = CONTEXT_USER;
$select .= $ccselect;
$joins[] = $ccjoin;


// Limit list to users with some role only.
if ($roleid) {
    // We want to query both the current context and parent contexts.
    list($relatedctxsql, $relatedctxparams) = $DB->get_in_or_equal($context->get_parent_context_ids(true), SQL_PARAMS_NAMED, 'relatedctx');

    $wheres[] = "u.id IN (SELECT userid FROM {role_assignments} WHERE roleid = :roleid AND contextid $relatedctxsql)";
    $params = array_merge($params, array('roleid' => $roleid), $relatedctxparams);
}

$from = implode("\n", $joins);
if ($wheres) {
    $where = "WHERE " . implode(" AND ", $wheres);
} else {
    $where = "";
}

$totalcount = $DB->count_records_sql("SELECT COUNT(u.id) $from $where", $params);

if (!empty($search)) {
    $fullname = $DB->sql_fullname('u.firstname', 'u.lastname');
    $wheres[] = "(". $DB->sql_like($fullname, ':search1', false, false) .
                " OR ". $DB->sql_like('email', ':search2', false, false) .
                " OR ". $DB->sql_like('idnumber', ':search3', false, false) .") ";
    $params['search1'] = "%$search%";
    $params['search2'] = "%$search%";
    $params['search3'] = "%$search%";
}

list($twhere, $tparams) = $table->get_sql_where();
if ($twhere) {
    $wheres[] = $twhere;
    $params = array_merge($params, $tparams);
}

$from = implode("\n", $joins);
if ($wheres) {
    $where = "WHERE " . implode(" AND ", $wheres);
} else {
    $where = "";
}

if ($table->get_sql_sort()) {
    $sort = ' ORDER BY '.$table->get_sql_sort();
} else {
    $sort = '';
}

$matchcount = $DB->count_records_sql("SELECT COUNT(u.id) $from $where", $params);

$table->initialbars(true);
$table->pagesize($perpage, $matchcount);

// List of users at the current visible page - paging makes it relatively short.
print_r("$select $from $where $sort");
//$userlist = $DB->get_recordset_sql("$select $from $where $sort", $params, $table->get_page_start(), $table->get_page_size());
print_objet($userlist);

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
