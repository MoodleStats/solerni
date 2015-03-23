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
 * Goodbye
 *
 * This module has been created to provide users the option to delete their account
 *
 * @package    local
 * @subpackage local_goodbye
 * @copyright  2013 Bas Brands, www.basbrands.nl
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');
require_once($CFG->dirroot . '/local/goodbye/check_account_form.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/goodbye/index.php');
$PAGE->set_title(format_string(get_string('deleteaccount', 'local_goodbye')));
$PAGE->set_heading(format_string(get_string('userpass', 'local_goodbye')));

$enabled = get_config('local_goodbye', 'enabled');

if ($enabled) {
    $checkaccount = new check_account_form();

    global $USER;

    $error = '';

    if ($localuser = $checkaccount->get_data()) {
        if ($localuser->username != '' && $localuser->password != '') {
            // User Exists, Check pass.
            if ($user = authenticate_user_login($localuser->username, $localuser->password) ) {
                if ($user->id == $USER->id ) {
                    // Add trace for legal purpose.
                    local_goodbye_write_log($user);
                    // Send an email to user.
                    if (get_config('local_goodbye', 'enabledemail')) {
                        local_goodbye_send_email($user);
                    }
                    delete_user($user);
                    redirect(new moodle_url('/'));
                } else {
                    $error = get_string('anotheraccount', 'local_goodbye');
                }
            } else {
                $error = get_string('loginerror', 'local_goodbye');
            }
        }
    }

    echo $OUTPUT->header(get_string('deleteaccount', 'local_goodbye'));
    $checkaccount->display();
    echo $error;
} else {
    echo $OUTPUT->header(get_string('disabled', 'local_goodbye'));
}

echo $OUTPUT->footer();



