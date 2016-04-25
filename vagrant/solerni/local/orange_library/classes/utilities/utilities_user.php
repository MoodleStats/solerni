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
 * @package     local
 * @subpackage  orange_library
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_orange_library\utilities;

defined('MOODLE_INTERNAL') || die();

class utilities_user {

    const USERLOGGED                = 0;
    const USERENROLLED              = 1;
    const USERUNENROLLED            = 2;
    const USERUNLOGGED            = 3;
    const PRIVATEPF                 = 4;

    static public function is_user_site_admin($user) {
        foreach (get_admins() as $adminuser) {
            if ($user->id === $adminuser->id ) {
                return true;
            }
        }
    }

    static public function is_user_course_admin($user, $course) {
        // Check user right inside the course.
    }

    /**
     * Check for user new mail. Return the number of unread mail (int) or false.
     * Use local_mail plugin.
     *
     * @param class $user
     * @return int || boolean
     */
    static public function user_have_new_mail($user) {
        if (class_exists('local_mail_message')) {
            $count = \local_mail_message::count_menu($user->id);
            if (property_exists($count, 'inbox')) {
                return $count->inbox;
            }
        }

        return false;
    }


    /**
     * Return the status of the user
     * Status could be : USERENROLLED
     *                          USERLOGGED
     *                          USERENROLLED
     *
     * @param none
     * @return $userstatus
     */
    static public function get_user_status($context) {

        $userstatus = self::USERUNENROLLED;

        if (is_enrolled($context)) {
            $userstatus = self::USERENROLLED;
        } else if (isloggedin()) {
            $userstatus = self::USERLOGGED;
        } else {
            $userstatus = self::USERUNLOGGED;
        }
        return $userstatus;
    }

    /**
     * Get the user profile fields based on a username.
     *
     * @param user name $username
     * @return array $userdata
     */
    static public function get_user_profile_fields($username) {
        global $CFG, $DB;

        $userdata = array();

        // Profile fields to synchronized.
        if ($user = $DB->get_record('user', array('username' => $username))) {
            if ($fields = $DB->get_records('user_info_field')) {
                foreach ($fields as $field) {
                    require_once($CFG->dirroot.'/user/profile/lib.php');
                    require_once($CFG->dirroot.'/user/profile/field/'.$field->datatype.'/field.class.php');
                    $newfield = 'profile_field_'.$field->datatype;
                    $formfield = new $newfield($field->id, $user->id);
                    $userdata[] = array ('type' => 'profile', 'name' => 'profile_field_'.$field->shortname,
                        'value' => $formfield->data);
                }
            }
        }

        // Forum preferences stored in user record.
        $userparameters = array('maildigest', 'autosubscribe', 'trackforums', 'mailformat');
        foreach ($userparameters as $userparameter) {
            $userdata[] = array ('type' => 'profile', 'name' => $userparameter, 'value' => $user->{$userparameter});
        }

        // Preferences to synchronized.
        $preferences = array('badgeprivacysetting');
        foreach ($preferences as $preference) {
            $userdata[] = array ('type' => 'preference', 'name' => $preference,
                'value' => get_user_preferences($preference, 1, $user));
        }

        return $userdata;
    }

    /**
     * Get edit user profile link for thematic.
     *
     * @return url $url
     */
    static public function get_edituserprofile_url() {
        $home = utilities_network::get_home();

        $url = $home->url . "/user/edit.php?returnto=profile";
        return $url;
    }

    /**
     * Get the number of users connected at the service
     *
     * @return int
     */

    public function get_nbconnectedusers() {
        global $CFG, $DB;

        $timetoshowusers = 300; // Seconds default.
        if (isset($CFG->block_online_users_timetosee)) {
            $timetoshowusers = $CFG->block_online_users_timetosee * 60;
        }
        $now = time();
        $timefrom = 100 * floor(($now - $timetoshowusers) / 100); // Round to nearest 100 seconds for better query cache.

        $params['now'] = $now;
        $params['timefrom'] = $timefrom;

        $csql = "SELECT COUNT(u.id) as nb
            FROM {user} u
            WHERE u.lastaccess > :timefrom
            AND u.lastaccess <= :now
            AND u.deleted = 0";

        if ($usercount = $DB->get_record_sql($csql, $params)) {
            return $usercount->nb;
        }

        return 0;
    }

    /**
     * Get the numbers of users enrolled in the service
     *
     * @return int
     */
    public function get_nbusers() {
        global $DB;
        // Timecreated = 0 if user has been deleted.
        $sql = "SELECT count(*) as count
            FROM {user}
            WHERE timecreated <> 0
            AND confirmed = 1
            AND suspended = 0";

        if ($nbusers = $DB->get_record_sql($sql)) {
            return $nbusers->count;
        }
        return 0;
    }
}