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
     * Function to determine if the platform should use (ie not private, not guest) and is
     * correctly configured to use mnet.
     * @return bool
     */
    public static function is_platform_uses_mnet() {
        global $CFG;
        $mnethosts = utilities_network::get_hosts();
        switch(true) {
            case (isset($CFG->solerni_isprivate) && $CFG->solerni_isprivate):
            case isguestuser():
            case !is_enabled_auth('mnet'):
            case empty($mnethosts):
                return false;
        }

        return true;
    }

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
     * @return false or host object (URL/name/IDs)
     */
    static public function get_home() {
        global $CFG, $SITE;
        if (self::is_thematic()) {
            $hosts = self::get_hosts();
            if (is_array($hosts)) {
                $return = array_pop($hosts);    // MNETHOME is the first host.
                $return->jump = $return->url;   // Do not jump onto MNET HOME.
            }
        } else {
            $return = new \stdClass();
            $return->url = $CFG->wwwroot;
            $return->name = $SITE->fullname;
            $return->id = 1;
            $return->jump = $CFG->wwwroot;
        }

        return $return;
    }

    /**
     * get the Mnet Hosts URL of the Moodle Network.
     *
     * @return array of Hosts arrays(URL/name/IDs)
     */
    static public function get_hosts() {
        global $CFG, $DB;

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

        if (!empty($hosts)) {
            foreach ($hosts as $host) {
                $jumpurl = new \moodle_url($CFG->wwwroot . '/auth/mnet/jump.php', array('hostid' => $host->id));
                $thematic = new \stdClass();
                $thematic->url = $host->wwwroot;
                $thematic->name = $host->name;
                $thematic->id = $host->id;
                $thematic->jump = $jumpurl->__toString();
                $thematics[] = $thematic;
            }
        }

        return $thematics;
    }

    /**
     * This function is called from REST webservices. Returns local mnet hosts
     * or false if the curl call gets an error.
     *
     * @global type $CFG
     * @return mixed false or array of host objects
     */
    static public function get_hosts_from_mnethome() {

        if (self::is_home()) {
            return self::get_hosts();
        }

        if (theme_utilities::is_theme_settings_exists_and_nonempty('webservicestoken') ) {
            global $CFG, $PAGE;
            require_once($CFG->libdir . '/filelib.php'); // Include moodle curl class.
            $token = $PAGE->theme->settings->webservicestoken;
            $homemnet = self::get_home();
            $serverurl = new \moodle_url($homemnet->url . '/webservice/rest/server.php',
                    array('wstoken' => $token,
                        'wsfunction' => 'local_orange_library_get_resac_hosts',
                        'moodlewsrestformat' => 'json'));
            $curl = new \curl;
            $resacs = json_decode($curl->post(
                    htmlspecialchars_decode($serverurl->__toString()), array()));

            if ($resacs && is_object($resacs) && $resacs->errorcode) {
                error_log('Resac Nav Curl Request Returned An Error. Message: ' . $resacs->message);
                $resacs = false;
            }
        } else {
            $resacs = false;
        }

        return $resacs;
    }
}
