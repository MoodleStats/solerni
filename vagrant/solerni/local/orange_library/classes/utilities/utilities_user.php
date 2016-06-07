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
require_once($CFG->dirroot.'/user/lib.php');
require_once($CFG->dirroot.'/mnet/lib.php');

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

    static public function is_user_mnet($user) {
        return ($user->mnethostid > 1);
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
    static public function get_user_profile_fields($username, $hosturl, $fullmode) {
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

            // Do we have the full user data to synchronize - in case of profile update.
            if ($fullmode) {
                $remoteclient = new \mnet_peer();
                $remoteclient->set_wwwroot($hosturl);

                $userfilterdata = mnet_strip_user($user, mnet_fields_to_send($remoteclient));
                foreach ($userfilterdata as $key => $value) {
                    $userdata[] = array ('type' => 'profile', 'name' => $key, 'value' => $value);
                }

                // We also need to get user avatar.
                if (array_key_exists('picture', $userfilterdata) && !empty($user->picture)) {
                    $fs = get_file_storage();
                    $usercontext = \context_user::instance($user->id, MUST_EXIST);
                    if ($usericonfile = $fs->get_file($usercontext->id, 'user', 'icon', 0, '/', 'f1.png')) {
                        $userdata[] = array('type' => 'avatar', 'name' => 'timemodified',
                            'value' => $usericonfile->get_timemodified());
                        $userdata[] = array('type' => 'avatar', 'name' => 'mimetype',
                            'value' => $usericonfile->get_mimetype());
                        $userdata[] = array('type' => 'avatar', 'name' => 'content',
                            'value' => base64_encode($usericonfile->get_content()));
                    } else if ($usericonfile = $fs->get_file($usercontext->id, 'user', 'icon', 0, '/', 'f1.jpg')) {
                        $userdata[] = array('type' => 'avatar', 'name' => 'timemodified',
                            'value' => $usericonfile->get_timemodified());
                        $userdata[] = array('type' => 'avatar', 'name' => 'mimetype',
                            'value' => $usericonfile->get_mimetype());
                        $userdata[] = array('type' => 'avatar', 'name' => 'content',
                            'value' => base64_encode($usericonfile->get_content()));
                    }
                } else {
                    $userdata[] = array('type' => 'avatar', 'name' => 'delete', 'value' => '');
                }
            } else {
                // Forum preferences stored in user record.
                $userparameters = array('maildigest', 'autosubscribe', 'trackforums', 'mailformat', 'timecreated');
                foreach ($userparameters as $userparameter) {
                    $userdata[] = array ('type' => 'profile', 'name' => $userparameter, 'value' => $user->{$userparameter});
                }
            }
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
     */
    static public function propagate_del_user($user) {
        $hosts = utilities_network::get_hosts();

        foreach ($hosts as $host) {
            $result = self::del_user_on_remote_thematic($host, $user);
        }

        return true;
    }

    /**
     * update user profil on a remote Thematic.
     *
     * @params host $host
     * @params user $user
     * @return $result
     */
    static public function update_user_on_remote_thematic($host, $user) {
        global $CFG, $PAGE;

        // Check that Webservice is activated.
        if (!theme_utilities::is_theme_settings_exists_and_nonempty('webservicestoken'.$host->id)) {
            error_log('Resac WebService not configurated - Cannot update user');
            return $host;
        }

        require_once($CFG->libdir . '/filelib.php'); // Include moodle curl class.
        $token = $PAGE->theme->settings->{"webservicestoken{$host->id}"};
        $serverurl = new \moodle_url($host->url . '/webservice/rest/server.php',
                array('wstoken' => $token,
                    'wsfunction' => 'local_orange_library_update_user_on_thematic',
                    'moodlewsrestformat' => 'json'));
        $curl = new \curl;
        $result = json_decode($curl->post(
                htmlspecialchars_decode($serverurl->__toString()),
                array('username' => $user->username, 'email' => $user->email)));

        if ($result && is_object($result) && $result->errorcode) {
            error_log('Resac Update User Request Returned An Error. Message: '
                    . $result->message);
            return false;
        }

        return $result;
    }

    /**
     * Propagate a user update action on remote thematics.
     *
     * @params host $host
     */
    static public function propagate_update_user($user) {
        $hosts = utilities_network::get_hosts();

        foreach ($hosts as $host) {
            $result = self::update_user_on_remote_thematic($host, $user);
        }

        return true;
    }

    /**
     * Update user on a Thematic. Call by a webservice from Solerni Home to force
     * Mnet user profil sync on thematics
     * This function MUST NOT be used to delete a user on Solerni Home
     *
     * @return array $result : command status
     */
    static public function update_user_on_thematic($username, $email) {
        global $DB;

        $result = true;

        // The user should be a mnet user .
        $user = $DB->get_record_sql("SELECT *
            FROM {user} u
            WHERE u.username= :username AND u.email = :email AND u.mnethostid > 1",
            array('username' => $username, 'email' => $email), IGNORE_MISSING);

        // If user exist then ask for a profile update.
        // User will not exist if the user never jump to this thematic.
        if ($user) {
            self::update_profile_fields($user, true);
        }

        return $result;
    }

    /**
     * Update user profile fields on thematic.
     *
     * @param user $user
     */
    public static function update_profile_fields($user, $mode = false) {
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
                array('username' => $user->username, 'host' => $CFG->wwwroot, 'mode' => $mode)));

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
            } else if ($field->type == 'avatar') {
                $usercontext = \context_user::instance($localuser->id, MUST_EXIST);
                    error_log($field->name . " context=".$usercontext->id);
                if ($field->name == 'content') {
                    require_once $CFG->libdir . '/gdlib.php';
                            $imagefilename = $CFG->tempdir . '/mnet-usericon-' . $localuser->id;
                            $imagecontents = base64_decode($field->value);
                            file_put_contents($imagefilename, $imagecontents);
                            if ($newrev = process_new_icon($usercontext, 'user', 'icon', 0, $imagefilename)) {
                                $localuser->picture = $newrev;
                            }
                            unlink($imagefilename);
                } else if ($field->name == 'delete') {
                    $fs = get_file_storage();
                    $fs->delete_area_files($usercontext->id, 'user', 'icon'); // Drop all images in area.
                }
            } else {
                error_log('Resac Update Profile, unsupported data type : ' . $field->type);
            }
        }

        require_once($CFG->dirroot.'/user/profile/lib.php');
        profile_save_data($localuser);
        user_update_user($localuser, false, false);
    }
}