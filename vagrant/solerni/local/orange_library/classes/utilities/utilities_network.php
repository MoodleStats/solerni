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
 * @package    orange_library
 * @subpackage utilities
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_orange_library\utilities;
use theme_halloween\tools\theme_utilities;

defined('MOODLE_INTERNAL') || die();

class utilities_network {

    /**
     * Check is the Moodle instance is the home server of the Moodle Network.
     *
     * @return boolean
     */
    static public function is_home() {
        return theme_utilities::is_theme_settings_exists_and_nonempty('mnet_home');
    }

    /**
     * Check is the Moodle instance is a thematic server of the Moodle Network.
     *
     * @return boolean
     */
    static public function is_thematic() {
        return !self::is_home();
    }

    /**
     * get the list of thematic's server URLs of the Moodle Network.
     *
     * @return false or array with Thematics server URL/name
     */
    static public function get_thematics() {
        if (self::is_home()) {
            return self::get_hosts();
        }

        return false;
    }

    /**
     * get the home server URL of the Moodle Network.
     *
     * @return false or array with Home server URL/name
     */
    static public function get_home() {

        if (self::is_thematic()) {
            $hosts = self::get_hosts();
            return array_pop($hosts); // MNETHOME is the first host
        }

        return false;
    }

    /**
     * get the Mnet Hosts URL of the Moodle Network.
     *
     * @return false or array with Hosts server URL/name
     */
    static public function get_hosts() {
        global $CFG, $USER, $DB;

        // Guest user not supported.
        if (isguestuser()) {
            return false;
        }

        if (!is_enabled_auth('mnet')) {
            // Auth MNet show be enabled.
            return false;
        }

        // Get the hosts and whether we are doing SSO with them.
        $sql = "
        SELECT DISTINCT
        h.id,
        h.name,
        h.wwwroot,
        a.name as application,
        a.display_name
        FROM
        {mnet_host} h,
        {mnet_application} a,
        {mnet_host2service} h2s_IDP,
        {mnet_service} s_IDP,
        {mnet_host2service} h2s_SP,
        {mnet_service} s_SP
        WHERE
        h.id <> ? AND
        h.id <> ? AND
        h.id = h2s_IDP.hostid AND
        h.deleted = 0 AND
        h.applicationid = a.id AND
        h2s_IDP.serviceid = s_IDP.id AND
        s_IDP.name = 'sso_idp' AND
        h2s_IDP.publish = '1' AND
        h.id = h2s_SP.hostid AND
        h2s_SP.serviceid = s_SP.id AND
        s_SP.name = 'sso_idp' AND
        h2s_SP.publish = '1'
        ORDER BY
        a.display_name,
        h.name";

        $hosts = $DB->get_records_sql($sql, array($CFG->mnet_localhost_id, $CFG->mnet_all_hosts_id));
        $thematics = array();

        if ($hosts) {
            foreach ($hosts as $host) {
                $thematic = new \stdClass();

                // MNet Shortcut.
                // Only for logged in users.
                // User should not have a regular account on the host
                // Login as is not permiited to jump to other server.
                // According to start_jump_session, remote users can't on-jump.
                // User should have the capability moodle/site:mnetlogintoremote.
                if (($host->id == $USER->mnethostid) ||
                    (!isloggedin()) ||
                    (\core\session\manager::is_loggedinas()) ||
                    (is_mnet_remote_user($USER)) ||
                    (!has_capability('moodle/site:mnetlogintoremote', \context_system::instance(), null, false))
                   ) {
                    $thematic->url = $host->wwwroot;
                    $thematic->name = $host->name;
                    $thematic->id = $host->id;
                } else {
                    $thematic->url = "{$CFG->wwwroot}/auth/mnet/jump.php?hostid={$host->id}";
                    $thematic->name = $host->name;
                    $thematic->id = $host->id;
                }
                $thematics[] = $thematic;
            }
        }

        return $thematics;
    }
}
