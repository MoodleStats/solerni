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
 * @package    local
 * @subpackage orange_mail
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(__FILE__) . '/classes/mail_test.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->libdir . '/sessionlib.php');

$action = optional_param('action', 'rules_form', PARAM_ALPHAEXT);

// Access control.
require_login();
require_capability('local/orange_mail:config', context_system::instance());

$context = context_system::instance();
$url = new moodle_url('/admin/settings.php', array('section' => 'orange_mail_settings'));
$PAGE->set_url($url);
$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');

$currentlang = current_language();

$sendtextemail = false;     // Send test emails in Text format.
$sendhtmlemail = true;      // Send test emails in HTML format.

// Get last course.
$course = $DB->get_record_sql('SELECT * FROM {course} ORDER BY id DESC LIMIT 1');
$instances = enrol_get_instances ($course->id, true);
$instances = array_filter ($instances, function ($element) {
    return $element->enrol == "self";
});
if (count($instances) != 0) {
    $instanceself = array_pop($instances);
}

$langs = get_string_manager()->get_list_of_translations();
foreach ($langs as $lang => $value) {
    force_current_language($lang);
    if ($sendhtmlemail) {
        //mail_test::reset_password_and_mail($USER);   // M1.
        //mail_test::user_account_mail_public($USER);  // M2 public.
        //mail_test::user_account_mail_private($USER); // M2 private.
        // mail_test::send_password_change_confirmation_email($USER); // M4.
        //mail_test::send_confirmation_email($USER); // M5.
        if (isset($instanceself)) {
            //mail_test::email_welcome_message($instanceself, $USER); // M6.
            //mail_test::email_information_message($instanceself, $USER);  // M7.
            mail_test::forum_delete_post($USER);
        }
        //mail_test::send_email_deletion($USER);  // M8.
        /*
        mail_test::setnew_password_and_mail($USER); // M14.
        mail_test::emailupdatemessage($USER);
         * 
         */
    }

    if ($sendtextemail) {
        //mail_test::reset_password_and_mail($USER, true);   // M1.
        //mail_test::user_account_mail_public($USER, true);  // M2 public.
        //mail_test::user_account_mail_private($USER, true); // M2 private.
        //mail_test::send_password_change_confirmation_email($USER, true); // M4.
        //mail_test::send_confirmation_email($USER, true); // M5.
        if (isset($instanceself)) {
            //mail_test::email_welcome_message($instanceself, $USER, true); // M6.
            //mail_test::email_information_message($instanceself, $USER, true);  // M7.
        }
        mail_test::send_email_deletion($USER, true); // M8.
        /*
        mail_test::setnew_password_and_mail($USER, true); // M14.
        mail_test::emailupdatemessage($USER, true);
         * 
         */
    }
}
force_current_language($currentlang);

$message = get_string('mailteststatus', 'local_orange_mail');
redirect($url, $message);
