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
 * Orange_customers front controller
 *
 * @package    block
 * @subpackage course_extended
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot.'/blocks/course_extended/course_extended_form.php');
require_once($CFG->dirroot.'/blocks/course_extended/locallib.php');

global $DB, $OUTPUT, $PAGE;

// Check for all required variables.
$courseid = required_param('courseid', PARAM_INT);
$blockid = required_param('blockid', PARAM_INT);
$blockcourseextended = 'block_course_extended';
$urlview = '/blocks/course_extended/view.php';

// Next look for optional variables.
$id = optional_param('id', 0, PARAM_INT);

if (!$cm = get_coursemodule_from_id($blockcourseextended, $id)) {
    print_error('invalidcoursemodule');
}
$page = $DB->get_record($blockcourseextended, array('id' => $cm->instance), '*', MUST_EXIST);


$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);

// Require_course_login($course, true, $cm);.
$context = context_module::instance($cm->id);
// ...$page = $PAGE->get_renderer('mod_page');.
courseextended_page_check_view_permissions($page, $context, $cm);

// ...$context = context_module::instance($cm->id);.
require_capability('mod/descriptionpage:view', $context);

// ...Access control.
// ...require_login($course);
// ...require_capability('moodle/site:config', context_system::instance());.

// ...$context = context_system::instance();.

// New object or update ?

$PAGE->set_url($urlview, array('id' => $courseid));
$PAGE->set_pagelayout('standard');
$PAGE->set_heading(get_string('blocktitle', $blockcourseextended));
$PAGE->set_context($context);
$courseextended = new course_extended_form();

$settingsnode = $PAGE->settingsnav->add(get_string('course_extended_settings', $blockcourseextended));
$editurl = new moodle_url($urlview, array('id' => $id, 'courseid' => $courseid, 'blockid' => $blockid));
$editnode = $settingsnode->add(get_string('editpage', $blockcourseextended), $editurl);
$editnode->make_active();

$formdata = array('id' => $id);
$courseextended->set_data($formdata);

$toform['blockid'] = $blockid;
$toform['courseid'] = $courseid;
$courseextended->set_data($toform);
$optionsfilemanager = array(
    'maxfiles' => 1,
    'maxbytes' => $CFG->maxbytes,
    'subdirs' => 0,
    'accepted_types' => 'web_image'
);
$fromformcancelled = $courseextended->is_cancelled();
$fromformdata = $courseextended->get_data();
if ($fromformcancelled) {
    // Cancelled forms redirect to the course main page.
    $courseurl = new moodle_url($urlview, array('id' => $id, 'courseid' => $courseid, 'blockid' => $blockid));
    redirect($courseurl);

} else if ($fromformdata) {
    // We need to add code to appropriately act on and store the submitted data.
    // But for now we will just redirect back to the course main page.
    $courseurl = new moodle_url($urlview, array('id' => $id, 'courseid' => $courseid, 'blockid' => $blockid));
    $draftitemid = file_get_submitted_draft_itemid('picture');

    file_save_draft_area_files($draftitemid, $context->id, $blockcourseextended, 'picture', $data->id, $optionsfilemanager );

    redirect($courseurl);

} else {
    // Form didn't validate or this is the first display.
    $site = get_site();
    echo $OUTPUT->header();
    $courseextended->display();
    echo $OUTPUT->footer();
}
