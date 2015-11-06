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
 * Progress Bar block overview page
 *
 * @package    block_orange_progressbar
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Include required files.
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot.'/blocks/orange_progressbar/lib.php');

// Gather form data.
$id       = required_param('progressbarid', PARAM_INT);
$courseid = required_param('courseid', PARAM_INT);

// Determine course and context.
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$context = context_course::instance($courseid);

// Get specific block config and context.
$progressblock = $DB->get_record('block_instances', array('id' => $id), '*', MUST_EXIST);
$progressconfig = unserialize(base64_decode($progressblock->configdata));
$progressblockcontext = context_block::instance($id);

// Set up page parameters.
$PAGE->set_course($course);
$PAGE->requires->css('/blocks/orange_progressbar/styles.css');
$PAGE->set_url('/blocks/progress/overview.php', array('progressbarid' => $id, 'courseid' => $courseid));
$PAGE->set_context($context);
$title = get_string('overview', 'block_orange_progressbar');
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->navbar->add($title);
$PAGE->set_pagelayout('standard');

// Check user is logged in and capable of grading.
require_login($course, false);
require_capability('block/orange_progressbar:overview', $progressblockcontext);

// Start page output.
echo $OUTPUT->header();
echo $OUTPUT->heading($title, 2);
echo $OUTPUT->container_start('block_orange_progressbar');

$renderer = $PAGE->get_renderer('block_orange_progressbar');

$completion = new completion_info($COURSE);
if ($completion->is_enabled()) {

    $activitymonitored = $completion->get_progress_all('u.id = '. $USER->id);
    list($completed, $total, $all) = block_orange_progressbar_filterfollowedactivity($COURSE, $activitymonitored[$USER->id]);

    if ($total) {
        // Display progress bar.
        $content = $renderer->display_progress($total, $completed, $all);

    } else {
        $content = $renderer->display_noactivity_monitored();
    }
} else {
    $content = $renderer->display_completion_notenabled();
}
echo $content;

echo $OUTPUT->container_end();
echo $OUTPUT->footer();