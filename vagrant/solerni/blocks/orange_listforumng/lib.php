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
 * Get all forumng in a course
 *
 * @param int $courseid
 * @return array
 */
function block_orange_listforumng_get_all($courseid) {
    global $CFG, $DB, $USER;

    if ($courseid != 1) {
        $forumngs = $DB->get_records_sql("
            SELECT F.id, F.name, F.intro, CM.id as instance, CM.added, CM.course
            FROM {forumng} F LEFT OUTER JOIN
            {course_modules} CM  ON (F.id=CM.instance) LEFT OUTER JOIN {modules} M ON (M.id = CM.module)
            WHERE M.name='forumng' AND M.visible=1 AND CM.visible=1 AND CM.course= ?  ORDER BY CM.course", array($courseid));
    } else {
        $forumngs = $DB->get_records_sql("
            SELECT F.id, F.name, F.intro, CM.id as instance, CM.added, CM.course
            FROM {forumng} F LEFT OUTER JOIN
            {course_modules} CM  ON (F.id=CM.instance) LEFT OUTER JOIN {modules} M ON (M.id = CM.module)
            WHERE M.name='forumng' AND M.visible=1 AND CM.visible=1 ORDER BY CM.course", array());
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

        if (!isset($listforumng[$forumng->course])) {
            $listforumng[$forumng->course] = array();
        }

        $listforumng[$forumng->course][] = array('id' => $forumng->id,
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
function block_orange_listforumng_get_bylistforumngid($listforumngid) {
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
 * Checks whether the current page is the My home page.
 *
 * @return bool True when on the My home page.
 */
function block_orange_listforumng_on_my_page() {
    global $SCRIPT;

    return $SCRIPT === '/my/index.php';
}
