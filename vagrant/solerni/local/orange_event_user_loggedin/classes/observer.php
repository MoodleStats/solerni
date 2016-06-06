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
 * @package    local_orange_event_user_loggedin
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

use local_orange_library\utilities\utilities_network;
use local_orange_library\utilities\utilities_user;
use theme_halloween\tools\theme_utilities;
require_once($CFG->dirroot.'/user/lib.php');

/**
 * Event observer for block orange_ruels.
 */
class local_orange_event_user_loggedin_observer {

    /**
     * Triggered via user_loggedin event.
     *
     * @param \core\event\user_loggedin $event
     */

    public static function user_loggedin(\core\event\user_loggedin $event) {
        global $CFG, $DB;

        $clause = array('id' => $event->objectid);
        $user = $DB->get_records('user', $clause);

        if (isset($user[$event->objectid])) {
            // In case of Mnet configuration we have to synchronize user profile.
            // Nothing to do for local account.
            if ((utilities_network::is_platform_uses_mnet())
                    && (utilities_network::is_thematic()
                    && theme_utilities::is_theme_settings_exists_and_nonempty('webservicestoken'))
                    && $user[$event->objectid]->mnethostid != 1 ) {
                utilities_user::update_profile_fields($user[$event->objectid], false);
            }

            // Detect if it is the first connexion of the user, Then send welcome email.
            if (($user[$event->objectid]->firstaccess == 0) ||
                ($user[$event->objectid]->lastaccess == 0) ||
                ($user[$event->objectid]->lastlogin == 0)) {

                // Send the welcome message.
                if ($CFG->solerni_isprivate) {
                    self::send_welcome_message_private($user[$event->objectid]);
                } else if (utilities_network::is_platform_uses_mnet() && utilities_network::is_home()) {
                    self::send_welcome_message_public($user[$event->objectid]);
                }

                // Redirection to a course page in case of MoodleEnrolToken cookie.
                // This cookie is set when the user subscribe to the platform and to a course at the same time.
                if (!empty($_COOKIE['MoodleEnrolToken'])) {
                    check_course_redirection ($_COOKIE['MoodleEnrolToken']);
                }
            }
        }
        return true;
    }

    /**
     * Send welcome email messages for public platform.
     *
     * @param user id $userid
     */
    private static function send_welcome_message_public($user) {
        global $CFG;
        $site = get_site();
        $profileurl = "$CFG->wwwroot/user/view.php?id=" . $user->id;
        $contact = core_user::get_support_user();
        $siteurl = $CFG->wwwroot;

        // Send account email reminder and welcome message.
        $message = get_string('contentuseraccountemail', 'local_orange_event_user_loggedin');
        $key = array('{$a->fullname}', '{$a->email}', '{$a->sitename}', '{$a->siteurl}', '{$a->profileurl}');
        $value = array(fullname($user), $user->email, format_string($site->fullname),
            $siteurl, $profileurl);
        $message = str_replace($key, $value, $message);
        if (strpos($message, '<') === false) {
            // Plain text only.
            $messagetext = $message;
            $messagehtml = text_to_html($messagetext, null, false, true);
        } else {
            // This is most probably the tag/newline soup known as FORMAT_MOODLE.
            $messagehtml = $message;
            $messagetext = html_to_text($messagehtml);
        }

        $subject = get_string('subjectuseraccountemail', 'local_orange_event_user_loggedin');
        $subject = str_replace('{$a->customername}', ucfirst($CFG->solerni_customer_name), $subject);

        email_to_user($user, $contact, $subject, $messagetext, $messagehtml);
    }

    /**
     * Send welcome email messages for private platform.
     *
     * @param user id $userid
     */
    private static function send_welcome_message_private($user) {
        global $CFG;
        $site = get_site();
        $profileurl = "$CFG->wwwroot/user/view.php?id=" . $user->id;
        $contact = core_user::get_support_user();
        $siteurl = $CFG->wwwroot;

        // Send account email reminder and welcome message.
        $message = get_string('contentuseraccountemailprivate', 'local_orange_event_user_loggedin');
        $key = array('{$a->fullname}', '{$a->email}', '{$a->sitename}', '{$a->siteurl}', '{$a->profileurl}');
        $value = array(fullname($user), $user->email, format_string($site->fullname),
            $siteurl, $profileurl);
        $message = str_replace($key, $value, $message);
        if (strpos($message, '<') === false) {
            // Plain text only.
            $messagetext = $message;
            $messagehtml = text_to_html($messagetext, null, false, true);
        } else {
            // This is most probably the tag/newline soup known as FORMAT_MOODLE.
            $messagehtml = $message;
            $messagetext = html_to_text($messagehtml);
        }

        $subject = get_string('subjectuseraccountemailprivate', 'local_orange_event_user_loggedin');
        $subject = str_replace('{$a->customername}', ucfirst($CFG->solerni_customer_name), $subject);

        email_to_user($user, $contact, $subject, $messagetext, $messagehtml);
    }
}