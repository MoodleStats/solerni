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

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/mod/forumng/mod_forumng.php');

/**
 * Get number of discussions in course
 *
 * @param int $forumid
 * @return array
 */

function block_orange_list_bestforumng_get_num_discussions($courseid) {
    global $DB;

    $forumngs = $DB->get_records_sql("
            SELECT F.id, F.name, F.intro, CM.id as instance, CM.added, CM.course
            FROM {forumng} F
            LEFT OUTER JOIN {course_modules} CM  ON (F.id=CM.instance)
            LEFT OUTER JOIN {modules} M ON (M.id = CM.module)
            WHERE M.name='forumng' AND M.visible=1 AND CM.visible=1 AND CM.course= ?", array($courseid));

    $nbdiscussions = 0;

    foreach ($forumngs as $forumng) {
        $sql = "SELECT count(*) as count
            FROM {forumng_discussions} d
            WHERE d.deleted = 0 AND forumngid = " . $forumng->id;

        $nbdiscussions += $DB->count_records_sql($sql);
    }
    return $nbdiscussions;
}