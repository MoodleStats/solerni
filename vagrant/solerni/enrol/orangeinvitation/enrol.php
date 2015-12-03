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
require($CFG->dirroot . '/enrol/self/lib.php');
require($CFG->dirroot . '/enrol/orangenextsession/lib.php');

// Get parameter before login redirection and set cookie.
// The cookie is needed to support the platform inscription process with email validation.
$enrolinvitationtoken = required_param('enrolinvitationtoken', PARAM_ALPHANUM);
// Course id.
$id = required_param('id', PARAM_INT);
// Enrol : true/false.
$enrol = optional_param('id2', null, PARAM_INT);
if ($enrol == null) {
    setcookie ( 'MoodleEnrolToken', rc4encrypt($enrolinvitationtoken.'-'.$id), time() + 3600, '/');
} else {
    setcookie ( 'MoodleEnrolToken', rc4encrypt($enrolinvitationtoken.'-'.$id.'-'.$enrol), time() + 3600, '/');
}

require_login();

// Check if param token exist.
if (!empty($enrolinvitationtoken)) {

    $id = required_param('id', PARAM_INT);

    // Check if we have to redirect the user to the course presentation page or to enrol him to the course.
    check_course_redirection  (null, $enrolinvitationtoken, $id, $enrol);
}