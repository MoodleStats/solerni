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
 * This page analyse the link and redirect to the course
 *
 * @package    enrol
 * @subpackage orangeinvitation
 * @copyright  Orange 2015 based on Jerome Mouneyrac invitation plugin{@link http://www.moodleitandme.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require('../../config.php');
require($CFG->dirroot . '/enrol/orangeinvitation/locallib.php');

require_login();

// Check if param token exist.
$enrolinvitationtoken = required_param('enrolinvitationtoken', PARAM_ALPHANUM);

if (!empty($enrolinvitationtoken)) {

    $id = required_param('id', PARAM_INT);
    $message = "";

    // Retrieve the token info.
    $invitation = $DB->get_record('enrol_orangeinvitation', array('token' => $enrolinvitationtoken));

    // If token is valid, enrol the user into the course.
    if (empty($invitation) or empty($invitation->courseid) or ($invitation->courseid != $id)) {
        $message = get_string('expiredtoken', 'enrol_orangeinvitation');
    }

    // Get.
    $invitationmanager = new invitation_manager($id);
    $instance = $invitationmanager->get_invitation_instance($id);
    if ($instance->status == 1) {
        // The URL Link is not activated.
        $message = get_string('linknotactivated', 'enrol_orangeinvitation');
    }

    if ($message == "") {
        $courseurl = new moodle_url('/course/view.php', array('id' => $id));
    } else {
        $courseurl = new moodle_url('/');
    }
    redirect($courseurl, $message);
}