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

function local_goodbye_extends_navigation(global_navigation $navigation) {
    global $USER;

    if (!isloggedin() || isguestuser()) {
        return '';
    }
    $enabled = get_config('local_goodbye', 'enabled');

    if ($enabled ) {
        // Not limited to auth method 'email' : 'googleoauth2', 'manual' should have too.
        if (is_siteadmin($USER)) {
            // No deleting admins allowed.
            return '';
        }
        $container2 = $navigation->add(get_string('myaccount', 'local_goodbye'));
        $userview2 = $container2->add(get_string('manageaccount', 'local_goodbye'), new moodle_url('/local/goodbye/index.php'));
    }
}

/**
 * Called from send deletion email to user
 */
function local_goodbye_send_email($user) {
    $supportuser = core_user::get_support_user();
    $messagetext = get_config('local_goodbye', 'emailmsg');
    $messagehtml = text_to_html($messagetext, null, false, true);
    $subject = get_config('local_goodbye', 'emailsubject');
    if (! email_to_user($user, $supportuser, $subject, $messagetext, $messagehtml)) {
        mtrace('mail error : mail was not sent to '. $user->email);
        print_error('mailerror', 'local_goodbye');
    }
}

/**
 * Writing user deletion in log file
 */
function local_goodbye_write_log($user) {

    $today = date("Y-m-d H:i:s");
    $msg = $today . " - User deleted : id=" . $user->id .  ", username=" . $user->username . ", email=" . $user->email. ", firstname=" . $user->firstname;
    $msg = $msg . ", lastname=" . $user->lastname . ", timecreated=" . $user->timecreated . ", country=" . $user->country . ", city=" . $user->city;
    $msg = $msg . ", auth=" . $user->auth .", department=" . $user->department . ", address=" . $user->address . ", lang=" . $user->lang . "\n";

    $fp = fopen(get_config('local_goodbye', 'logfilename'), 'a');
    fwrite($fp, $msg);
    fclose($fp);
}
