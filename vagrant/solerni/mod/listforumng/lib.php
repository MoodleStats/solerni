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
 * @package mod_listforumng
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;


/**
 * Add page instance.
 * @param stdClass $data
 * @param mod_page_mod_form $mform
 * @return int new page instance id
 */
function listforumng_add_instance($data, $mform = null) {
    global $CFG, $DB;
    require_once("$CFG->libdir/resourcelib.php");

    $cmid = $data->coursemodule;

    $data->id = $DB->insert_record('listforumng', $data);

    // We need to use context now, so we need to make sure all needed info is already in db.
    $DB->set_field('course_modules', 'instance', $data->id, array('id' => $cmid));
    $context = context_module::instance($cmid);

    if ($mform and !empty($data->listforumng['itemid'])) {
        $draftitemid = $data->listforumng['itemid'];
        $DB->update_record('listforumng', $data);
    }

    return $data->id;
}

/**
 * Update page instance.
 * @param object $data
 * @param object $mform
 * @return bool true
 */
function listforumng_update_instance($data, $mform) {
    global $CFG, $DB;
    require_once("$CFG->libdir/resourcelib.php");

    $data->id = $data->instance;

    $DB->update_record('listforumng', $data);

    return true;
}

/**
 * Delete page instance.
 * @param int $id
 * @return bool true
 */
function listforumng_delete_instance($id) {
    global $DB;

    if (!$listforumng = $DB->get_record('listforumng', array('id' => $id))) {
        return false;
    }

    // Note: all context files are deleted automatically.
    $DB->delete_records('listforumng', array('id' => $listforumng->id));

    return true;
}

/**
 * Get all forumng in a course
 *
 * @param int $courseid
 * @return array
 */
function forumng_get_all($courseid) {
    global $CFG, $DB, $USER;

    $forumngs = $DB->get_records_sql("
        SELECT F.id, F.name, CM.id as instance, CM.added
        FROM {forumng} F LEFT OUTER JOIN
        {course_modules} CM  ON (F.id=CM.instance) LEFT OUTER JOIN {modules} M ON (M.id = CM.module)
        WHERE M.name='forumng' AND M.visible=1 AND CM.visible=1 AND CM.course= ? ", array($courseid), MUST_EXIST);

    $listforumng = array();

    foreach ($forumngs as $forumng) {
        $forumnginstance = $forumng->instance;

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

        $listforumng[] = array('instance' => $forumng->instance,
                'name' => $forumng->name,
                'createddate' => $forumng->added,
                'nbposts' => $nbposts,
                'usernamelastpost' => $username,
                'datelastpost' => $datelastpost);
    }

    return $listforumng;
}