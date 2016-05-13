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
 * Get the $nbdisplayed last posts for the user userid in the course $courseid
 *
 * @param int $courseid
 * @param int $userid
 * @param int $nbdisplayed
 * @return array
 */

defined('MOODLE_INTERNAL') || die();

use local_orange_library\utilities\utilities_object;

function block_orange_emerging_messages_get_user_posts($courseid, $userid, $npdisplayed) {
    global $DB;

    $forumngobj = new forumng_object();

    $courses = $DB->get_records('course', array('id' => $courseid));

    return $forumngobj->get_posts_by_user($userid, $courses, false, false, 0, $npdisplayed);
}


/**
 * Get the $nbdisplayed last discussions  in the course $courseid
 *
 * @param int $courseid
 * @param int $nbdisplayed
 * @return array
 */

function block_orange_emerging_messages_get_last_discussions($courseid, $npdisplayed) {

    $forumngobj = new forumng_object();

    return $forumngobj->get_recent_discussions($courseid, 0, $npdisplayed);
}

/**
 * Get the $nbdisplayed best messages  in the course $courseid
 *
 * @param int $courseid
 * @param int $nbdisplayed
 * @return array
 */

function block_orange_emerging_messages_get_best_messages($courseid, $npdisplayed) {

    $forumngobj = new forumng_object();

    return $forumngobj->get_best_post($courseid, 0, $npdisplayed);
}


/**
 * Checks whether the current page is the My home page.
 *
 * @return bool True when on the My home page.
 */
function block_orange_emerging_messages_on_my_page() {
    global $SCRIPT;

    return $SCRIPT === '/my/index.php';
}


/**
 * cut text after N characters, the last character don't must be
 * @param $msg
 * @param $limitchar nb char maximum
 * @return string
 */
function cut_message($msg, $limitchar = 150) {

    // Delete Image in message and replace by [IMAGE].
    $msg = preg_replace('/<img src(.*?)>/is', '[IMAGE]', $msg);

    // No strip_tags in the function trim_text to keep the 'strongs' characters.
    // Add ellipses even text not cut and underligne last word and ellipse.
    return utilities_object::trim_text(strip_tags($msg, '<b><i><strong><em>'), $limitchar, true, false, true, true);

}