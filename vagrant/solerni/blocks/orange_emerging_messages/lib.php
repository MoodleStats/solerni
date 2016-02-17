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

function block_orange_emerging_messages_get_user_posts($courseid, $userid, $npdisplayed) {
    global $CFG, $DB, $USER;

    $forumngobj = new forumng_object();

    $course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
    $courses = array();
    $courses[] = $course;

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
    global $CFG, $DB, $USER;

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
    global $CFG, $DB, $USER;

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
 * @param $limitlengthword  The lenght of the last word must be greater or equal to $limitlengthword
 * @return string
 */
function cut_message($msg, $limitchar = 150, $limitlengthword = 3) {
    global $DB;

    $msg = str_replace("<p>", " ", $msg);
    $msg = str_replace("</p>", "", $msg);
    $msg = str_replace("<br>", " ", $msg);
    $msg = str_replace("  ", " ", $msg);
    $msg = trim($msg);

    // Delete Image in message.
    while (stripos($msg, "<img src") !== false) {
        $posbegining = stripos($msg, "<img src");
        $posend = stripos($msg, ">", $posbegining);
        $msg = substr($msg, 0, $posbegining) . "[IMAGE]" . substr($msg, $posend + 1);
    }

    $atext = explode(" ", $msg);
    $newmsg = "";
    $lenghtstring = 0;
    $i = 0;
    $indacceptable = 0;
    while ( $i < count($atext) && $lenghtstring < $limitchar) {
        $lenghtstring += strlen($atext[$i]) + 1;
        if (strlen($atext[$i]) >= $limitlengthword && $lenghtstring < $limitchar) {
            $indacceptable = $i;
        }
        $i++;
    }

    if ($indacceptable != 0) {
        return implode(" ", array_slice($atext, 0, $indacceptable)) . " <u>" . $atext[$indacceptable] . "...</u>";
    } else {
        if (strlen($msg) <= $limitchar) {
            return implode(" ", array_slice($atext, 0, count($atext) - 1)) . " <u>" . $atext[count($atext) - 1] . "...</u>";
        } else {
            if (count($atext) > 1) {
                return implode(" ", array_slice($atext, 0, $i - 2)) . " <u>" . $atext[$i - 2] . "...</u>";
            } else {
                return " <u>...</u>";  // One word and too long.
            }
        }
    }

}
