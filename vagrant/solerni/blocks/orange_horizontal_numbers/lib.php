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

/**
 * Get the number of users connected at the service
 *
 * @return int
 */

function block_orange_horizontal_numbers_get_nbconnectedusers() {
    global $CFG, $DB;

    $timetoshowusers = 300; // Seconds default.
    if (isset($CFG->block_online_users_timetosee)) {
        $timetoshowusers = $CFG->block_online_users_timetosee * 60;
    }
    $now = time();
    $timefrom = 100 * floor(($now - $timetoshowusers) / 100); // Round to nearest 100 seconds for better query cache.

    $params['now'] = $now;
    $params['timefrom'] = $timefrom;

    $csql = "SELECT COUNT(u.id) as nb
        FROM {user} u
        WHERE u.lastaccess > :timefrom
        AND u.lastaccess <= :now
        AND u.deleted = 0";

    if ($usercount = $DB->get_record_sql($csql, $params)) {
        return $usercount->nb;
    }

    return 0;
}


/**
 * Get the numbers of posts in the service
 *
 * @return int
 */

function block_orange_horizontal_numbers_get_nbposts() {
    global $DB;

    $csql = 'SELECT count(p.id) as count
            FROM {forumng_posts} p
            JOIN {forumng_discussions} d ON d.id = p.discussionid
            WHERE p.deleted=0
            AND d.deleted=0';

    if ($nbposts = $DB->get_record_sql($csql)) {
        return $nbposts->count;
    }

    return 0;
}


/**
 * Get the numbers of users enrolled in the service
 *
 * @return int
 */

function block_orange_horizontal_numbers_get_nbusers() {
    global $DB;
    // Timecreated = 0 if user has been deleted.
    $sql = "SELECT count(*) as count
        FROM {user}
        WHERE timecreated <> 0
        AND confirmed = 1
        AND suspended = 0";

    if ($nbusers = $DB->get_record_sql($sql)) {
        return $nbusers->count;
    }
    return 0;
}


/**
 * Get the last user registered at the service
 *
 * @return object User
 */

function block_orange_horizontal_numbers_get_lastregistered() {
    global $DB;
    // Timecreated = 0 if user has been deleted.
    $sql = "SELECT *
        FROM {user}
        WHERE timecreated <> 0
        AND confirmed = 1
        AND suspended = 0
        ORDER BY timecreated DESC
        LIMIT 1";

    if ($userobject = $DB->get_record_sql($sql)) {
        return $userobject;
    }
    return null;
}