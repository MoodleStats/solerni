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
 * @copyright  2015 Orange
 *     Fork : 2013 Bas Brands, www.basbrands.nl
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

require_login();

if ($enabled && !is_siteadmin() && !isguestuser()) {
    $checkaccount = new check_account_form();

    global $USER;

    $error = '';

    if ($localuser = $checkaccount->get_data()) {
        if ($localuser->username != '' && $localuser->password != '') {
            // Authenticate_user_login() will fail it if it's 'googleoauth2'.
            if (!($user = authenticate_user_login($localuser->username, $localuser->password)) ) {
                if (!empty($CFG->authloginviaemail)) {
                    if ($email = clean_param($localuser->username, PARAM_EMAIL)) {
                        $user = $DB->get_record('user', array('email' => $email, 'deleted' => 0,
                                                 'auth' => 'googleoauth2'));
                    } else {
                        $user = $DB->get_record('user', array('username' => $localuser->username, 'deleted' => 0,
                                                 'auth' => 'googleoauth2'));
                    }
                } else {
                        $user = $DB->get_record('user', array('username' => $localuser->username, 'deleted' => 0,
                                                 'auth' => 'googleoauth2'));
                }

            }

            // User Exists, Check pass.
            if ($user) {
                if ($user->id == $USER->id ) {
                    // Orange 2016.02.15 Get user language before delete.
                    $currentlang = current_language();

                    delete_user($user);

                    // Orange - 2016.05.09 - Delete user on thematics.
                    local_orange_library\utilities\utilities_user::propagate_del_user($user);

                    // Auths, in sequence.
                    $authsequence = get_enabled_auth_plugins();
                    foreach ($authsequence as $authname) {
                        $authplugin = get_auth_plugin($authname);
                        $authplugin->logoutpage_hook();
                    }

                    require_logout();
                    // Orange 2016.02.15 Set user language.
                    force_current_language($currentlang);

                    $PAGE->set_heading(format_string(get_string('deleteaccount', 'local_goodbye')));
                    echo $OUTPUT->header(get_string('deleteaccount', 'local_goodbye'));
                    echo $OUTPUT->notification(get_string('useraccountdeleted', 'local_goodbye'), 'notifysuccess');
                    echo $OUTPUT->footer();
                    exit;
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
    $PAGE->set_heading(format_string(get_string('deleteaccount', 'local_goodbye')));
    echo $OUTPUT->header(get_string('disabled', 'local_goodbye'));
    echo $OUTPUT->notification(get_string('nodeletionmsg', 'local_goodbye'));
}

echo $OUTPUT->footer();



