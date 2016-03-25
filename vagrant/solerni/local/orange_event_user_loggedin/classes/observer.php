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
        global $DB;

        $clause = array('id' => $event->objectid);
        $user = $DB->get_records('user', $clause);

        if (isset($user[$event->objectid])) {
            // In case of Mnet configuration we have to synchronize user profile.
            if ((utilities_network::is_platform_uses_mnet()) && (utilities_network::is_thematic())) {
                self::update_profile_fields($user[$event->objectid]);
            }

            // Detect if it is the first connexion of the user, Then send welcome email.
            if (($user[$event->objectid]->firstaccess == 0) ||
                ($user[$event->objectid]->lastaccess == 0) ||
                ($user[$event->objectid]->lastlogin == 0)) {

                self::send_welcome_message($user[$event->objectid]);

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
     * Send welcome email messages.
     *
     * @param user id $userid
     */
    private static function send_welcome_message($user) {
        global $CFG;
        $site = get_site();
        $profileurl = "$CFG->wwwroot/user/view.php?id=" . $user->id;
        $contact = core_user::get_support_user();
        $siteurl = $CFG->wwwroot;

        if ((utilities_network::is_platform_uses_mnet() && utilities_network::is_home()) ||
            ($CFG->solerni_isprivate)) {
            // Send account email reminder.
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
            $subject = str_replace('{$a->sitename}', format_string($site->fullname), $subject);

            email_to_user($user, $contact, $subject, $messagetext, $messagehtml);
        }

        if ((utilities_network::is_platform_uses_mnet() && utilities_network::is_thematic()) ||
            ($CFG->solerni_isprivate)) {
            // Send welcome message.
            $message = get_string('contentwelcomeemail', 'local_orange_event_user_loggedin');
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

            $subject = get_string('subjectwelcomeemail', 'local_orange_event_user_loggedin');
            $subject = str_replace('{$a->sitename}', format_string($site->fullname), $subject);

            email_to_user($user, $contact, $subject, $messagetext, $messagehtml);
        }
    }

    /**
     * Update user profile fields on thematic.
     *
     * @param user $user
     */
    private static function update_profile_fields($user) {

        // Check that Webservice is activated.
        if (!theme_utilities::is_theme_settings_exists_and_nonempty('webservicestoken')) {
            error_log('Resac WebService not configurated - Cannot update profile');
            return false;
        }

        global $CFG, $DB, $PAGE;
        require_once($CFG->libdir . '/filelib.php'); // Include moodle curl class.

        $token = $PAGE->theme->settings->webservicestoken;
        $homemnet = utilities_network::get_home();
        $serverurl = new \moodle_url($homemnet->url . '/webservice/rest/server.php',
                array('wstoken' => $token,
                    'wsfunction' => 'local_orange_library_get_profile_fields',
                    'moodlewsrestformat' => 'json'));
        $curl = new \curl;
        $profile = json_decode($curl->post(
                htmlspecialchars_decode($serverurl->__toString()),
                array('username' => $user->username)));

        if ($profile && is_object($profile) && $profile->errorcode) {
            error_log('Resac Update Profile Curl Request Returned An Error. Message: '
                    . $profile->message);
            $profile = false;
        }

        if (empty($profile)) {
            return false;
        }

        $localuser = $DB->get_record('user', array('id' => $user->id));
        foreach ($profile as $field) {
            if ($field->type == 'profile') {
                $localuser->{$field->name} = $field->value;
            } else if ($field->type == 'preference') {
                set_user_preference($field->name, $field->value, $user);
            } else {
                error_log('Resac Update Profile, unsupported data type : ' . $field->type);
            }
        }

        require_once($CFG->dirroot.'/user/profile/lib.php');
        profile_save_data($localuser);
        user_update_user($user, false, false);

    }
}
