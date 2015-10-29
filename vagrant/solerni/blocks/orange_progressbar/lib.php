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

/**
 * Filter all activities of the course to get only activities with completion state
 *
 * @return completed nbre of completed activities.
 * @return total nbre of activities (with completion state).
 * @return activitiesfollowed : details of activities followed.
 */
function block_orange_progressbar_filterfollowedactivity($course, $activities) {
    global $DB, $USER;

    $modinfo = get_fast_modinfo($course->id, $USER->id);
    $total = 0;
    $completed = 0;
    $activitiesfollowed = array();
    $pages = 0;
    $pagescompleted = 0;
    foreach ($modinfo->get_cms() as $cmid => $mod) {
        if ($mod->completion) {
            // Get activitie name to display.
            $modulename = get_string('mod_'. $mod->modname, 'block_orange_progressbar');
            if ($modulename == '[['.'mod_'. $mod->modname . ']]') {
                $modulename = get_string('modulename', 'mod_'. $mod->modname);
            }

            $activity = new stdClass();
            $activity->modname = $mod->modname;
            $activity->modnametext = $modulename;
            $activity->name = $mod->name;
            $activity->modid = $mod->id;
            $activity->id = $mod->instance;
            if (isset($activities->progress[$mod->id])) {
                $activity->completionstate = $activities->progress[$mod->id]->completionstate;
            } else {
                $activity->completionstate = false;
            }
            $activity->url = $mod->url;

            // For quiz we need to get more information to display.
            if ($mod->modname == 'quiz') {
                $quiz = $DB->get_record('quiz', array('id' => $mod->instance));
                $activity->quizmaxattempts = $quiz->attempts;
                $activity->quizuserattempts = count(quiz_get_user_attempts($mod->instance, $USER->id, 'finished'));
            }

            // For course pages, only one entry.
            if ($mod->modname == 'page') {
                $pages++;
                // Test on completionstate !=0, takes COMPLETION_COMPLETE,
                // COMPLETION_COMPLETE_PASS and COMPLETION_COMPLETE_FAIL.
                if ($activity->completionstate) {
                    $pagescompleted++;
                }

                if (!isset($activitiesfollowed [$mod->modname][0])) {
                    $activity->pages = $pages;
                    $activity->pagescompleted = $pagescompleted;
                    $activity->name = get_string('course_page_activity', 'block_orange_progressbar');
                    $activitiesfollowed [$mod->modname][0] = $activity;
                } else {
                    $activitiesfollowed [$mod->modname][0]->pages = $pages;
                    $activitiesfollowed [$mod->modname][0]->pagescompleted = $pagescompleted;
                }
            } else {
                $activitiesfollowed [$mod->modname][] = $activity;
            }
            $total++;

            // Test on completionstate !=0, takes COMPLETION_COMPLETE, COMPLETION_COMPLETE_PASS and COMPLETION_COMPLETE_FAIL.
            if ((isset($activities->progress[$mod->id])) && ($activities->progress[$mod->id]->completionstate)) {
                $completed++;
            }
        }
    }

    return array($completed, $total, $activitiesfollowed);
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

function simple_orange_progressbar ($course) {
    global $USER, $CFG, $DB;

    $output = "";
    // Guests do not have any progress. Don't show them the bar.
    if (!isloggedin() or isguestuser()) {
        return $output;
    }

    $completion = new completion_info($course);
    //if ($completion->is_enabled()) {

        $activitymonitored = $completion->get_progress_all('u.id = '. $USER->id);

        // At first access to the course, the list is not set.
        if (!isset($activitymonitored[$USER->id])) {
            $activitymonitored[$USER->id] = null;
        }
        list($completed, $total, $all) = block_orange_progressbar_filterfollowedactivity($course,
                $activitymonitored[$USER->id]);

        if ($total) {
            // Display progress bar.
            $progress = round($completed / $total * 100);

            $output = html_writer::start_tag('div', array('class' => 'progress'));
            $output .= html_writer::start_tag('div', array('class' => 'progress-bar',
                                                          'role' => 'progressbar',
                                                          'aria-valuenow' => $progress,
                                                          'aria-valuemin' => '0',
                                                          'aria-valuemax' => '100',
                                                          'style' => 'width:'.$progress.'%'));
            if ($progress > 25) {
                $output .= $progress . ' %';
            }
            $output .= html_writer::end_tag('div');
            if ($progress <= 25) {
                $output .= $progress . ' %';
            }
            $output .= html_writer::end_tag('div');
            return $output;
        //} 
    } 
    return $output;
}