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
 * @subpackage orangenextsession
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once($CFG->dirroot.'/enrol/orangenextsession/orangenextsession.php');
require_once($CFG->dirroot.'/user/profile/lib.php');

$courseid   = required_param('courseid', PARAM_INT);
$instanceid = optional_param('id', 0, PARAM_INT);

$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$context = context_course::instance($course->id, MUST_EXIST);

require_login($course);
require_capability('enrol/orangenextsession:config', $context);

require_once($CFG->libdir . '/csvlib.class.php');

$fields = array('username'  => 'username',
                'email'     => 'email',
                'firstname' => 'firstname',
                'lastname'  => 'lastname'
                );


$filename = clean_filename(get_string('users'));

$csvexport = new csv_export_writer();
$csvexport->set_filename($filename);
$csvexport->add_data($fields);

$nextsessionlist = new orangenextsession();
$users = $nextsessionlist->get_nextsession_list($instanceid);

foreach ($users as $user) {
    $row = array();
    if (!$user = $DB->get_record('user', array('id' => $user->userid))) {
            continue;
    }
    profile_load_data($user);
    $userprofiledata = array();
    foreach ($fields as $field => $unused) {
        // Custom user profile textarea fields come in an array
        // The first element is the text and the second is the format.
        // We only take the text.
        if (is_array($user->$field)) {
            $userprofiledata[] = reset($user->$field);
        } else {
            $userprofiledata[] = $user->$field;
        }
    }
    $csvexport->add_data($userprofiledata);
}
$csvexport->download_file();
die;

