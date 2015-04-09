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

/**
 * Event observer for block orange_ruels.
 */
class local_orange_event_user_loggedin_observer {

    /**
     * Triggered via user_loggedin event.
     *
     * @param \core\event\user_loggedin $event
     */

    public static function user_loggedin(\core\event\user_loggedin  $event) {
        global $CFG, $DB;

        $clause = array('id' => $event->objectid);
        $user = $DB->get_records('user', $clause);

        if (($user[$event->objectid]->firstaccess == 0) ||
            ($user[$event->objectid]->lastaccess == 0) ||
            ($user[$event->objectid]->lastlogin == 0)) {

            $site = get_site();
            $profileurl = "$CFG->wwwroot/user/view.php?id=" . $user[$event->objectid]->id;
            $contact = core_user::get_support_user();
            $siteurl = $CFG->wwwroot;

            // Send account email reminder.
            $message = get_string('contentuseraccountemail', 'local_orange_event_user_loggedin');
            $key = array('{$a->fullname}', '{$a->email}', '{$a->sitename}', '{$a->siteurl}', '{$a->profileurl}');
            $value = array(fullname($user[$event->objectid]), $user[$event->objectid]->email, format_string($site->fullname),
                $siteurl, $profileurl);
            $message = str_replace($key, $value, $message);
            if (strpos($message, '<') === false) {
                // Plain text only.
                $messagetext = $message;
                $messagehtml = text_to_html($messagetext, null, false, true);
            } else {
                // This is most probably the tag/newline soup known as FORMAT_MOODLE.
                $messagehtml = format_text($message, FORMAT_MOODLE, array('para' => false, 'newlines' => true, 'filter' => true));
                $messagetext = html_to_text($messagehtml);
            }

            $subject = get_string('subjectuseraccountemail', 'local_orange_event_user_loggedin');
            $subject = str_replace('{$a->sitename}', format_string($site->fullname), $subject);

            email_to_user($user[$event->objectid], $contact, $subject, $messagetext, $messagehtml);

            // Send welcome message.
            $message = get_string('contentwelcomeemail', 'local_orange_event_user_loggedin');
            $key = array('{$a->fullname}', '{$a->email}', '{$a->sitename}', '{$a->siteurl}', '{$a->profileurl}');
            $value = array(fullname($user[$event->objectid]), $user[$event->objectid]->email, format_string($site->fullname),
                $siteurl, $profileurl);
            $message = str_replace($key, $value, $message);
            if (strpos($message, '<') === false) {
                // Plain text only.
                $messagetext = $message;
                $messagehtml = text_to_html($messagetext, null, false, true);
            } else {
                // This is most probably the tag/newline soup known as FORMAT_MOODLE.
                $messagehtml = format_text($message, FORMAT_MOODLE, array('para' => false, 'newlines' => true, 'filter' => true));
                $messagetext = html_to_text($messagehtml);
            }

            $subject = get_string('subjectwelcomeemail', 'local_orange_event_user_loggedin');
            $subject = str_replace('{$a->sitename}', format_string($site->fullname), $subject);

            email_to_user($user[$event->objectid], $contact, $subject, $messagetext, $messagehtml);
        }

        return true;
    }
}