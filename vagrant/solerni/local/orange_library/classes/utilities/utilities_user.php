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
use theme_halloween\tools\theme_utilities;
use local_orange_library\utilities\utilities_network;

defined('MOODLE_INTERNAL') || die();

class utilities_user {

    const USERLOGGED                = 0;
    const USERENROLLED              = 1;
    const USERUNENROLLED            = 2;
    const USERUNLOGGED              = 3;
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
        $userparameters = array('maildigest', 'autosubscribe', 'trackforums', 'mailformat', 'timecreated');
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

    static public function get_nbconnectedusers() {
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
    static public function get_nbusers() {
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

    /**
     * Get the last user registered at the service
     *
     * @return object User
     */
    static public function get_lastregistered() {
        global $DB;
        // Timecreated = 0 if user has been deleted.
        $sql = "SELECT *
            FROM {user}
            WHERE timecreated <> 0
            AND confirmed = 1
            AND suspended = 0
            ORDER BY timecreated DESC
            LIMIT 1";

        if ($userobject = $DB->get_record_sql($sql)) {
            return $userobject;
        }
        return null;
    }

    /**
     * Delete user on a Thematic. Call by a webservice from Solerni Home to delete
     * Mnet user on thematics
     * This function MUST NOT be used to delete a user on Solerni Home
     *
     * @return array $result : command status
     */
    static public function del_user_on_thematic($username, $email) {
        global $DB;

        $result = true;

        // The user should be a mnet user .
        $user = $DB->get_record_sql("SELECT *
            FROM {user} u
            WHERE u.username= :username AND u.email = :email AND u.mnethostid > 1",
            array('username' => $username, 'email' => $email), IGNORE_MISSING);

        // If user exist delete it.
        // User will not exist if the user never jump to this thematic.
        if ($user) {
            delete_user($user);
        }

        return $result;
    }

    /**
     * Delete user on remote Thematic.
     *
     * @params host $host
     * @params user $user
     * @return int $status
     */
    static private function del_user_on_remote_thematic($host, $user) {
        global $CFG, $PAGE;

        // Check that Webservice is activated.
        if (!theme_utilities::is_theme_settings_exists_and_nonempty('webservicestoken'.$host->id)) {
            error_log('Resac WebService not configurated - Cannot delete user');
            return $host;
        }

        require_once($CFG->libdir . '/filelib.php'); // Include moodle curl class.
        $token = $PAGE->theme->settings->{"webservicestoken{$host->id}"};
        $serverurl = new \moodle_url($host->url . '/webservice/rest/server.php',
                array('wstoken' => $token,
                    'wsfunction' => 'local_orange_library_del_user_on_thematic',
                    'moodlewsrestformat' => 'json'));
        $curl = new \curl;
        $result = json_decode($curl->post(
                htmlspecialchars_decode($serverurl->__toString()),
                array('username' => $user->username, 'email' => $user->email)));

        if ($result && is_object($result) && $result->errorcode) {
            error_log('Resac Delete User Request Returned An Error. Message: '
                    . $result->message);
            return false;
        }

        return $result;
    }

    /**
     * Propagate a user delete action on remote thematics.
     *
     * @params host $host
     * @return int $status
     */
    static public function propagate_del_user($user) {
        $hosts = utilities_network::get_hosts();

        foreach ($hosts as $host) {
            $result = self::del_user_on_remote_thematic($host, $user);
        }

        return true;
    }
}