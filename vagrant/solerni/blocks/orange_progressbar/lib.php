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
 * Simple Progress Bar block common configuration and helper functions
 *
 * @subpackage block_orange_progressbar
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function block_orange_progressbar_count_course_monitored_activities($activities) {
    return count($activities);
}

function block_orange_progressbar_filterfollowedactivity($course, $activities) {
    global $DB, $USER;

    $modinfo = get_fast_modinfo($course->id, $USER->id);
    $total = 0;
    $completed = 0;
    $all = array();
    foreach ($modinfo->get_cms() as $cmid => $mod) {
        if ($mod->completion) {
            $activity = new stdClass();
            $activity->modname = $mod->modname;
            $activity->name = $mod->name;
            $activity->modid = $mod->id;
            $activity->id = $mod->instance;
            if (isset($activities->progress[$mod->id])) {
                $activity->completionstate = $activities->progress[$mod->id]->completionstate;
            } else {
                $activity->completionstate = false;
            }
                $activity->url = $mod->url;
                $all [] = $activity;
            $total++;
            if ((isset($activities->progress[$mod->id])) && ($activities->progress[$mod->id]->completionstate)) {
                $completed++;
            }
        }
    }

    return array($completed, $total, $all);
}

/**
 * Checks whether the current page is the My home page.
 *
 * @return bool True when on the My home page.
 */
function block_orange_progressbar_on_my_page() {
    global $SCRIPT;

    return $SCRIPT === '/my/index.php';
}
