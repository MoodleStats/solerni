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

/* Include required files */
require_once($CFG->dirroot.'/mod/forumng/mod_forumng_post.php');
require_once($CFG->dirroot.'/mod/forumng/mod_forumng_discussion.php');
require_once($CFG->dirroot.'/mod/forumng/mod_forumng.php');

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

    foreach ($data->subpart as $key => $value) {
        $value = trim($value);
        if (isset($value) && $value <> '') {
            $subpart = new stdClass();
            $subpart->name = $value;
            $subpart->parent = $data->id;
            $subpart->course = $data->course;

            $DB->insert_record("listforumng", $subpart);
        }
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

    // Update, delete or insert answers.
    foreach ($data->subpart as $key => $value) {
        $value = trim($value);
        $subpart = new stdClass();
        $subpart->name = $value;
        $subpart->parent = $data->id;
        $subpart->course = $data->course;

        if (isset($data->subpartid[$key]) && !empty($data->subpartid[$key])) {
            // Existing choice record.
            $subpart->id = $data->subpartid[$key];
            if (isset($value) && $value <> '') {
                $DB->update_record("listforumng", $subpart);
            } else { // Empty old option - needs to be deleted.
                $DB->delete_records("listforumng", array("id" => $subpart->id));
            }
        } else {
            if (isset($value) && $value <> '') {
                $DB->insert_record("listforumng", $subpart);
            }
        }
    }

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

    if ($courseid != 1) {
        $forumngs = $DB->get_records_sql("
            SELECT F.id, F.name, F.intro, CM.id as instance, CM.added, CM.course
            FROM {forumng} F LEFT OUTER JOIN
            {course_modules} CM  ON (F.id=CM.instance) LEFT OUTER JOIN {modules} M ON (M.id = CM.module)
            WHERE M.name='forumng' AND M.visible=1 AND CM.visible=1 AND CM.course= ? ", array($courseid));
    } else {
        $forumngs = $DB->get_records_sql("
            SELECT F.id, F.name, F.intro, CM.id as instance, CM.added, CM.course
            FROM {forumng} F LEFT OUTER JOIN
            {course_modules} CM  ON (F.id=CM.instance) LEFT OUTER JOIN {modules} M ON (M.id = CM.module)
            WHERE M.name='forumng' AND M.visible=1 AND CM.visible=1", array());
    }

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

        $listforumng[] = array('id' => $forumng->id,
                'instance' => $forumng->instance,
                'name' => $forumng->name,
                'courseid' => $forumng->course,
                'intro' => $forumng->intro,
                'createddate' => $forumng->added,
                'nbposts' => $nbposts,
                'usernamelastpost' => $username,
                'datelastpost' => $datelastpost);
    }

    return $listforumng;
}

/**
 * Get forumng details by idforumng
 *
 * @param array $listforumngid
 * @return array
 */
function forumng_get_bylistforumngid($listforumngid) {
    global $CFG, $DB, $USER;

    if (empty($listforumngid)) {
        return array();
    }

    $forumngs = $DB->get_records_sql("
           SELECT F.id, F.name, F.intro, CM.id as instance, CM.added, CM.course
           FROM {forumng} F LEFT OUTER JOIN
           {course_modules} CM  ON (F.id=CM.instance) LEFT OUTER JOIN {modules} M ON (M.id = CM.module)
           WHERE M.name='forumng' AND M.visible=1 AND CM.visible=1 AND F.id IN  (". implode(", ", $listforumngid) . ") ");

    $listforumng = array();

    foreach ($forumngs as $forumng) {
        $forumnginstance = $forumng->instance;

        // Recuperation de toutes les discussions d'un forum.
        $forum = mod_forumng::get_from_id($forumng->id, mod_forumng::CLONE_DIRECT, true);

        $listdiscus = $forum->get_discussion_list();

        // Parcours des discussions pour trouver le nbre de post.
        // Puis la date et l'user qui a posté le dernier.
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

        $listforumng[] = array('id' => $forumng->id,
        'instance' => $forumng->instance,
        'name' => $forumng->name,
        'courseid' => $forumng->course,
        'intro' => $forumng->intro,
        'createddate' => $forumng->added,
        'nbposts' => $nbposts,
        'usernamelastpost' => $username,
        'datelastpost' => $datelastpost);
    }

    return $listforumng;
}

/**
 * Get all forumng in a course
 *
 * @param int $courseid
 * @return array
 */
function forumng_get_subpart($listforumngid) {
    global $CFG, $DB, $USER;

    $listsubpart = array();

    // Main list forumng.
    $mainpart = $DB->get_record('listforumng', array('id' => $listforumngid));
    $mainpart->listforumid = $DB->get_fieldset_select('listforumng_forumng', 'forumngid', 'listforumngid = ?', array($listforumngid) );
    $listsubpart[] = $mainpart;

    $subparts = $DB->get_records('listforumng', array('parent' => $listforumngid));
    foreach ($subparts as $subpart) {
        $subpart->listforumid = $DB->get_fieldset_select('listforumng_forumng', 'forumngid', 'listforumngid = ?', array($subpart->id));

        $listsubpart[] = $subpart;
    }

    return $listsubpart;

}

/**
 * Given an object containing all the necessary data,
 * (defined by the form) this function
 * will create or update a new instance and return true if it was created or updated
 *
 * @param stdClass $customer
 * @return boolean
 */
function lisforumng_add_affect($affect) {
    global $CFG, $DB;

    $forumngidaffected = array();
    foreach ($affect as $key => $value) {
        if (strpos($key, "forumng-") === 0 && $value === "1") {
            $forumngidaffected[] = intval(substr($key, stripos($key, "-") + 1));
        }
    }

    if ($affect->subpartid == 0) {
        $affect->subpartid = $affect->instance;
    }
    $DB->execute('DELETE FROM {listforumng_forumng} WHERE listforumngid = ' . $affect->subpartid );

    foreach ($forumngidaffected as $forumngid) {
        $DB->execute('INSERT INTO {listforumng_forumng} (listforumngid, forumngid) VALUES (' . $affect->subpartid . ', ' . $forumngid . ')');
    }
    return true;
}


function lisforumng_get_affectation($subpartid) {
    global $CFG, $DB;

    $affect = array();
    $listforuminsubpart = $DB->get_records('listforumng_forumng', array('listforumngid' => $subpartid));
    foreach ($listforuminsubpart as $foruminsubpart) {
        $affect['forumng-' . $foruminsubpart->forumngid] = 1;
    }
    $affect['forumng-4'] = 0;

    return $affect;
}
