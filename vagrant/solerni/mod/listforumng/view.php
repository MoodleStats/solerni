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
 * Page module version information
 *
 * @package mod_listforumng
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once($CFG->dirroot.'/mod/forumng/mod_forumng_post.php');
require_once($CFG->dirroot.'/mod/forumng/mod_forumng_discussion.php');
require_once($CFG->dirroot.'/mod/forumng/mod_forumng.php');
require_once($CFG->libdir.'/completionlib.php');

$id = optional_param('id', 0, PARAM_INT); // Course Module ID.
$p = optional_param('p', 0, PARAM_INT);  // Page instance ID.
$inpopup = optional_param('inpopup', 0, PARAM_BOOL);

if ($p) {
    if (!$listforumng = $DB->get_record('listforumng', array('id' => $p))) {
        print_error('invalidaccessparameter');
    }
    $cm = get_coursemodule_from_instance('listforumng', $listforumng->id, $listforumng->course, false, MUST_EXIST);

} else {
    if (!$cm = get_coursemodule_from_id('listforumng', $id)) {
        print_error('invalidcoursemodule');
    }
    $listforumng = $DB->get_record('listforumng', array('id' => $cm->instance), '*', MUST_EXIST);
}

$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);

require_course_login($course, true, $cm);
$context = context_module::instance($cm->id);
require_capability('mod/listforumng:view', $context);

$PAGE->set_url('/mod/listforumng/view.php', array('id' => $cm->id));

echo $OUTPUT->header();

echo $OUTPUT->heading(format_string($listforumng->name), 2);

// Build table of forums.
$table = new html_table;

$table->head = array(get_string('headtablename', 'listforumng'));
$table->head[] = get_string('headtablenbposts', 'listforumng');
$table->head[] = get_string('headtablelastpost', 'listforumng');

$table->data = array();

$forumngs = $DB->get_records_sql("
    SELECT F.id, F.name, CM.id as instance, CM.added
    FROM mdl_forumng F LEFT OUTER JOIN
    mdl_course_modules CM  ON (F.id=CM.instance) LEFT OUTER JOIN mdl_modules M ON (M.id = CM.module)
    WHERE M.name='forumng' AND M.visible=1 AND CM.visible=1 AND CM.course= ? ", array($cm->course), MUST_EXIST);

foreach ($forumngs as $forumng) {

    $forumnginstance = $forumng->instance;
    $forumngcreated = '<span class="listforumng-date">le ' . userdate($forumng->added) . '</span>';
    $forumname = "<a href=" . $CFG->wwwroot. "/mod/forumng/view.php?&id=" . $forumnginstance . ">" .  $forumng->name . "</a>";

    // Recuperation de toutes les discussions d'un forum.
    $forum = mod_forumng::get_from_id($forumng->id, mod_forumng::CLONE_DIRECT, true);

    $listdiscus = $forum->get_discussion_list();

    // Parcours des discussions pour trouver le nbre de post.
    // puis la date et l'user qui a posté le dernier.
    $nbposts = 0;
    $datelastpost = "";
    $username = "";

    $lastpostdate = array();
    foreach ($listdiscus->get_normal_discussions() as $discus) {
        $nbposts += $discus->get_num_posts();
        $lastpostid = $discus->get_last_post_id();
        $lastpost = mod_forumng_post::get_from_id($lastpostid, mod_forumng::CLONE_DIRECT);
        $lastpostdate[$lastpost->get_modified()] = $lastpost->get_user();
    }

    if (!empty($lastpostdate)) {
        $datelastpost = userdate(max(array_keys($lastpostdate)));
        $username = fullname($lastpostdate[max(array_keys($lastpostdate))]);
    }

    $row = array();

    $row[] = $forumname. "<br>". $forumngcreated;
    $row[] = $nbposts;
    $row[] = $username. "<br>". $datelastpost;

    $table->data[] = $row;

}

print html_writer::table($table);

echo $OUTPUT->footer();