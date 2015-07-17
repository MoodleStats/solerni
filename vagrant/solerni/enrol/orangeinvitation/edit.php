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
 * Adds new instance of enrol_orangeinvitation to specified course
 * or edits current instance.
 *
 * @package    enrol
 * @subpackage orangeinvitation
 * @copyright  Orange 2015 based on Jerome Mouneyrac invitation plugin{@link http://www.moodleitandme.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once('edit_form.php');

$courseid   = required_param('courseid', PARAM_INT);
$instanceid = optional_param('id', 0, PARAM_INT); // Instanceid.

$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$context = context_course::instance($course->id);

require_login($course);
require_capability('enrol/orangeinvitation:config', $context);

$PAGE->set_url('/enrol/orangeinvitation/edit.php', array('courseid' => $course->id, 'id' => $instanceid));
$PAGE->set_pagelayout('admin');

$return = new moodle_url('/enrol/instances.php', array('id' => $course->id));
if (!enrol_is_enabled('orangeinvitation')) {
    redirect($return);
}

$plugin = enrol_get_plugin('orangeinvitation');

if ($instanceid) {
    $instance = $DB->get_record('enrol', array('courseid' => $course->id, 'enrol' => 'orangeinvitation', 'id' => $instanceid),
        '*', MUST_EXIST);
} else {
    require_capability('moodle/course:enrolconfig', $context);
    // No instance yet, we have to add new instance.
    navigation_node::override_active_url(new moodle_url('/enrol/instances.php', array('id' => $course->id)));
    $instance = new stdClass();
    $instance->id       = null;
    $instance->courseid = $course->id;
}

if (!isset($instance->customtext1) || ($instance->customtext1 == "")) {
    // We generate the invitation link for this course.
    $existinginvitation = $DB->get_record('enrol_orangeinvitation', array('courseid' => $course->id));

    if (empty($existinginvitation) or empty($existinginvitation->token)) {
        // Create unique token for invitation.
        $token = md5(uniqid(rand(), 1));
        $existingtoken = $DB->get_record('enrol_orangeinvitation', array('token' => $token));
        while (!empty($existingtoken)) {
            $token = md5(uniqid(rand(), 1));
            $existingtoken = $DB->get_record('enrol_orangeinvitation', array('token' => $token));
        }
        // Save token information in config (token value, course id).
        $invitation = new stdClass();
        $invitation->courseid = $course->id;
        $invitation->creatorid = $USER->id;
        $invitation->token = $token;

        $DB->insert_record('enrol_orangeinvitation', $invitation);
    } else {
        $token = $existinginvitation->token;
    }

    $inviturl = new moodle_url('/enrol/orangeinvitation/enrol.php',
        array('enrolinvitationtoken' => $token, 'id' => $course->id));
    $instance->customtext1 = $inviturl->out(false);
}

$instance->customtext1static = $instance->customtext1;
$instance->customtext2static = $instance->customtext1."&id2=1";
$mform = new enrol_orangeinvitation_edit_form(null, array($instance, $plugin, $context));

if ($mform->is_cancelled()) {
    redirect($return);

} else if ($data = $mform->get_data()) {
    if ($instance->id) {
        $instance->status           = $data->status;
        $instance->name           = $data->name;
        // URL for invitation only.
        $instance->customtext1    = $data->customtext1;
        $instance->timemodified   = time();
        $DB->update_record('enrol', $instance);

    } else {
        $fields = array('status' => $data->status,
                        'name' => $data->name,
                        'customtext1' => $data->customtext1);
        $plugin->add_instance($course, $fields);
    }

    redirect($return);
}

$PAGE->set_heading($course->fullname);
$PAGE->set_title(get_string('pluginname', 'enrol_orangeinvitation'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'enrol_orangeinvitation'));
$mform->display();
echo $OUTPUT->footer();
