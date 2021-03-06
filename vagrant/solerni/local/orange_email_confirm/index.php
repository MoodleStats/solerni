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
 * Version details
 *
 * @package    local_orange_email_confirm
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->libdir.'/moodlelib.php');
require_once($CFG->dirroot . '/local/orange_mail/classes/mail_override.php');

global $DB, $PAGE;
$PAGE->set_context(context_system::instance());

$useremail = required_param('mail', PARAM_EMAIL);

$clause = array('email' => $useremail);

$user = $DB->get_record('user', $clause);

if (empty($user->confirmed)) {       // This account was never confirmed.
    mail_override::send_confirmation_email($user);
}
redirect(new moodle_url('/login/index.php'));

