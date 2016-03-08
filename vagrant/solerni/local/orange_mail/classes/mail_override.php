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
 * @package    orange_mail
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once(dirname(__FILE__) . '/Emogrifier.php');

/**
 * All functions in this class are copy of Moodle code or Plugins code.
 * These copies are here because the change of Moodle has not been accepted
 */
class mail_override {

    /**
     *  COPY FROM MOODLELIB.PHP
     *  Sends a password change confirmation email.
     *
     * @param stdClass $user A {@link $USER} object
     * @param stdClass $resetrecord An object tracking metadata regarding password reset request
     * @return bool Returns true if mail was sent OK and false if there was an error.
     */
    public static function send_password_change_confirmation_email($user, $resetrecord) {
        global $CFG;

        $site = get_site();
        $supportuser = core_user::get_support_user();
        $pwresetmins = isset($CFG->pwresettime) ? floor($CFG->pwresettime / MINSECS) : 30;

        $data = new stdClass();
        $data->firstname = $user->firstname;
        $data->lastname  = $user->lastname;
        $data->username  = $user->username;
        $data->sitename  = format_string($site->fullname);
        $data->link      = $CFG->httpswwwroot .'/login/forgot_password.php?token='. $resetrecord->token;
        $data->admin     = generate_email_signoff();
        $data->resetminutes = $pwresetmins;

        $messagehtml = get_string('emailresetconfirmation', '', $data);
        $message = html_to_text($messagehtml);
        $subject = get_string('emailresetconfirmationsubject', '', format_string($site->fullname));

        // Directly email rather than using the messaging system to ensure its not routed to a popup or jabber.
        return email_to_user($user, $supportuser, $subject, $message, $messagehtml);

    }

    /**
     * COPY FROM MOODLELIB.PHP
     * Send email to specified user with confirmation text and activation link.
     *
     * @param stdClass $user A {@link $USER} object
     * @return bool Returns true if mail was sent OK and false if there was an error.
     */
    public static function send_confirmation_email($user) {
        global $CFG;

        $site = get_site();
        $supportuser = core_user::get_support_user();

        $data = new stdClass();
        $data->firstname = fullname($user);
        $data->sitename  = format_string($site->fullname);
        $data->admin     = generate_email_signoff();

        $subject = get_string('emailconfirmationsubject', '', format_string($site->fullname));

        $username = urlencode($user->username);
        $username = str_replace('.', '%2E', $username); // Prevent problems with trailing dots.
        $data->link  = $CFG->wwwroot .'/login/confirm.php?data='. $user->secret .'/'. $username;
        $messagehtml = get_string('emailconfirmation', '', $data);
        $message = html_to_text(get_string('emailconfirmation', '', $data));

        $user->mailformat = 1;  // Always send HTML version as well.

        // Directly email rather than using the messaging system to ensure its not routed to a popup or jabber.
        return email_to_user($user, $supportuser, $subject, $message, $messagehtml);
    }

    /**
     * COPY FROM MOODLELIB.PHP
     * Resets specified user's password and send the new password to the user via email.
     *
     * @param stdClass $user A {@link $USER} object
     * @return bool Returns true if mail was sent OK and false if there was an error.
     */
    public static function reset_password_and_mail($user) {
        global $CFG;

        $site  = get_site();
        $supportuser = core_user::get_support_user();

        $userauth = get_auth_plugin($user->auth);
        if (!$userauth->can_reset_password() or !is_enabled_auth($user->auth)) {
            trigger_error("Attempt to reset user password for user $user->username with Auth $user->auth.");
            return false;
        }

        $newpassword = generate_password();

        if (!$userauth->user_update_password($user, $newpassword)) {
            print_error("cannotsetpassword");
        }

        $a = new stdClass();
        $a->firstname   = $user->firstname;
        $a->lastname    = $user->lastname;
        $a->sitename    = format_string($site->fullname);
        $a->username    = $user->username;
        $a->newpassword = $newpassword;
        $a->link        = $CFG->httpswwwroot .'/login/change_password.php';
        $a->signoff     = generate_email_signoff();

        $messagehtml = get_string('newpasswordtext', '', $a);
        $message = html_to_text($messagehtml);

        $subject  = format_string($site->fullname) .': '. get_string('changedpassword');

        unset_user_preference('create_password', $user); // Prevent cron from generating the password.

        // Directly email rather than using the messaging system to ensure its not routed to a popup or jabber.
        return email_to_user($user, $supportuser, $subject, $message, $messagehtml);
    }

    /**
     * COPY FROM MOODLELIB.PHP
     * Sets specified user's password and send the new password to the user via email.
     *
     * @param stdClass $user A {@link $USER} object
     * @param bool $fasthash If true, use a low cost factor when generating the hash for speed.
     * @return bool|string Returns "true" if mail was sent OK and "false" if there was an error
     */
    public static function setnew_password_and_mail($user, $fasthash = false) {
        global $CFG;

        // We try to send the mail in language the user understands,
        // unfortunately the filter_string() does not support alternative langs yet
        // so multilang will not work properly for site->fullname.
        $lang = empty($user->lang) ? $CFG->lang : $user->lang;

        $site  = get_site();

        $supportuser = core_user::get_support_user();

        $newpassword = generate_password();

        update_internal_user_password($user, $newpassword, $fasthash);

        $a = new stdClass();
        $a->firstname   = fullname($user, true);
        $a->sitename    = format_string($site->fullname);
        $a->username    = $user->username;
        $a->newpassword = $newpassword;
        $a->link        = $CFG->wwwroot .'/login/';
        $a->signoff     = generate_email_signoff();

        $messagehtml = (string)new lang_string('newusernewpasswordtext', '', $a, $lang);
        $message = html_to_text($messagehtml);

        if ($messagehtml) {
            $user->mailformat = 1;
        }

        $subject = format_string($site->fullname) .': '. (string)new lang_string('newusernewpasswordsubj', '', $a, $lang);

        // Directly email rather than using the messaging system to ensure its not routed to a popup or jabber.
        return email_to_user($user, $supportuser, $subject, $message, $messagehtml);

    }

}