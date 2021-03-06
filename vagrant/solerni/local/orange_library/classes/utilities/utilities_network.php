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
require_once($CFG->dirroot . '/local/orange_mail/classes/mail_test.php');
require_once($CFG->dirroot . '/lib/classes/user.php');
require_once($CFG->dirroot . '/local/orange_mail/classes/mail_object.php');
require_once($CFG->dirroot.'/local/orange_library/classes/forumng/forumng_object.php');

defined('MOODLE_INTERNAL') || die();

class utilities_network {

    /**
     * Function to determine if the platform should use (ie not private, not guest) and is
     * correctly configured to use mnet.
     * @return bool
     */
    public static function is_platform_uses_mnet() {
        global $CFG;
        $mnethosts = self::get_hosts();
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

    /**
     * This function is called from CRON task to check validiy of MNet keys.
     *
     * @global type $CFG, $DB
     * @return none
     */
    static public function renew_mnet_key() {
        global $CFG, $DB;

        $error = false;

        if (!isset($CFG->mnet_key_autorenew)) {
            set_config('mnet_key_autorenew', 0); // Not activated as a default.
        }

        // If we are not in mnet configuration or autorenew not enabled.
        if (!self::is_platform_uses_mnet() || empty($CFG->mnet_key_autorenew)) {
            return false;
        }

        require_once($CFG->dirroot.'/mnet/lib.php');
        $mnet = get_mnet_environment();

        (isset($CFG->mnet_autorenew) && ($CFG->mnet_autorenew == 1)) ? $force = true : $force = false;

        if (self::mnet_key_havetorenew($mnet) || $force) {
            if ($force) {
                $content = "<p>Enter key Renew process (force mode)</p>";
                $error = true;
            } else {
                $content = "<p>Enter key Renew process (regular mode)</p>";
            }
            include_once($CFG->dirroot.'/mnet/peer.php');

            $mnet->replace_keys();
            $content .= "<p>Renew Local key. Validy : " . userdate($mnet->public_key_expires) ."</p>";
        } else {
            $content = "<p>Local key still valid. Validy : " . userdate($mnet->public_key_expires) ."</p>";
        }

        // Send new key using key exchange transportation.
        // Make a key and exchange it with all known and active peers.
        $mnetpeers = $DB->get_records('mnet_host', array('deleted' => 0));
        if ($mnetpeers) {
            foreach ($mnetpeers as $peer) {
                if (($peer->id == $CFG->mnet_all_hosts_id) || ($peer->id == $CFG->mnet_localhost_id)) {
                    continue;
                }

                $content .= "<p> Remote Host : ". $peer->name . " ("  . $peer->wwwroot . ") : </p>";

                $application = $DB->get_record('mnet_application', array('id' => $peer->applicationid));

                $mnetpeer = new \mnet_peer();
                $mnetpeer->set_wwwroot($peer->wwwroot);
                // Get the sessions for each vmoodle that have same ID Number.
                // We use a force parameter to force fetching the key remotely anyway.
                $content .= "<ul>". "Get remote key for host". "</ul>";
                $currentkey = mnet_get_public_key($mnetpeer->wwwroot, $application, 1);
                if ($currentkey) {
                    if (clean_param($currentkey, PARAM_PEM) != $peer->public_key) {
                        $content .= "<ul>". "Key difference, update localy". "</ul>";

                        $mnetpeer->public_key = clean_param($currentkey, PARAM_PEM);
                        $mnetpeer->updateparams = new \stdClass();
                        $mnetpeer->updateparams->public_key = clean_param($currentkey, PARAM_PEM);
                        $mnetpeer->public_key_expires = $mnetpeer->check_common_name($currentkey);
                        $mnetpeer->updateparams->public_key_expires = $mnetpeer->check_common_name($currentkey);
                        $mnetpeer->commit();
                        $content .= "<ul>".'Key validity : '. userdate($mnetpeer->public_key_expires) . "</ul>";
                    } else {
                        $content .= "<ul>". "Key up to date. Validy : ".
                                userdate($mnetpeer->check_common_name($currentkey)) . "</ul>";
                    }
                } else {
                    $content .= "<p>". 'Failed renewing key with '.$peer->wwwroot. "</p>";
                    $error = true;
                }
            }
        }
        set_config('mnet_autorenew_haveto', 0);

        $user = \core_user::get_user_by_username('admin');
        self::send_mnet_key_check_status($user, $content, $error);
    }

    /**
     * Check if key is getting obsolete.
     *
     * @global type $CFG
     * @params mnet environment $mnet
     * @return boolean
     */
    static public function mnet_key_havetorenew($mnet) {
        global $CFG;
        $havetorenew = false;

        // Setting some defaults if the config has not been setup.
        if (!isset($CFG->mnet_key_autorenew_gap)) {
            set_config('mnet_key_autorenew_gap', 24 * 3); // Three days.
        }
        if (!isset($CFG->mnet_key_autorenew_hour)) {
            set_config('mnet_key_autorenew_hour', 0); // Midnight.
        }
        if (!isset($CFG->mnet_key_autorenew_min)) {
            set_config('mnet_key_autorenew_min', 0); // Midnight.
        }

        $CFG->mnet_key_autorenew_time = $CFG->mnet_key_autorenew_hour * HOURSECS + $CFG->mnet_key_autorenew_min * MINSECS;

        // Key is getting old : check if it is time to operate.
        if ($mnet->public_key_expires - time() < $CFG->mnet_key_autorenew_gap * HOURSECS) {
            // This one is needed as temporary global toggle between distinct cron invocations,
            // but should not be changed through the GUI.
            if (empty($CFG->mnet_autorenew_haveto)) {
                set_config('mnet_autorenew_haveto', 1);
            } else {
                if (!empty($CFG->mnet_key_autorenew_time)) {
                    $now = getdate(time());
                    if ( ($now['hours'] * HOURSECS + $now['minutes'] * MINSECS) > $CFG->mnet_key_autorenew_time ) {
                        $havetorenew = true;
                    }
                } else {
                    $havetorenew = true;
                }
            }
        }

        return $havetorenew;
    }

    /**
     * This send a status of MNet key validy to admin user.
     *
     * @global type $CFG
     * @params user $user
     * @params mail content $content
     * @return none
     */
    static public function send_mnet_key_check_status($user, $content='', $error) {
        global $CFG;

        if ((isset($CFG->mnet_status_mail) && ($CFG->mnet_status_mail)) || $error) {
            $site  = get_site();
            $supportuser = \core_user::get_support_user();

            $a = new \stdClass();
            $a->firstname   = $user->firstname;
            $a->lastname    = $user->lastname;
            $a->sitename    = format_string($site->fullname);

            $messagehtml = get_string('orange_library_mnet_mail', 'local_orange_library', $a);
            $messagehtml .= "<p>" . $content . "</p>";
            $messagehtml = \mail_object::get_mail($messagehtml, 'html', '');
            $message = html_to_text($messagehtml);

            $subject  = format_string($site->fullname) .': '. get_string('orange_library_mnet_mail_subject', 'local_orange_library');

            $user->mailformat = 1;

            return email_to_user($user, $supportuser, $subject, $message, $messagehtml);
        }
    }


    /**
     * Get informations of a Thematic.
     *
     * @params host $host
     * @return object $host
     */
    static public function get_thematic_info($host) {
        global $DB;

        // Try to find entry in DB cache.
        if ($thematic = $DB->get_record('thematic_info', array('hostid' => $host->id), '*', IGNORE_MULTIPLE)) {
            foreach ($thematic as $key => $value) {
                $host->{$key} = $value;
            }

            return $host;
        } else {
            // No entry, we need to update the data.
            return self::update_thematic_info($host);
        }
    }

    /**
     * update informations of a Thematic.
     *
     * @params host $host
     * @return object $host
     */
    static public function update_thematic_info($host) {
        global $CFG, $DB;

        // If we are on Home Solerni.
        if (self::is_platform_uses_mnet() && self::is_home()) {
            $host = self::retreive_remote_thematic_info($host);
        }

        if ((!self::is_platform_uses_mnet()) ||
            (self::is_platform_uses_mnet() && self::is_thematic())) {
            // If we are on Solerni Thematic or simple installation.
            $infos = self::retreive_local_thematic_info($host);
            foreach ($infos as $field) {
                $host->{$field['name']} = $field['value'];
            }
        }

        // In case image have not be set on thematic.
        if (empty($host->logo)) {
            $host->logo = $CFG->wwwroot . "/blocks/orange_thematics_menu/pix/defaultlogo.png";
        }
        if (empty($host->illustration)) {
            $host->illustration = $CFG->wwwroot . "/blocks/orange_thematics_menu/pix/defaultillustration.jpg";
        }

        if (!$host->available) {
            error_log('Error in retreiving thematic information for : ' . $host->id);
            return $host;
        }

        // Resize image to store a local copy.
        $host->illustration = utilities_image::get_resized_url($host->illustration,
                array('w' => 664, 'h' => 354, 'scale' => false));

        if ($thematic = $DB->get_record('thematic_info', array('hostid' => $host->id), '*', IGNORE_MULTIPLE)) {
            $thematic->available        = $host->available;
            $thematic->nbmooc           = $host->nbmooc;
            $thematic->nbinprogressmooc = $host->nbinprogressmooc;
            $thematic->nbfuturemooc     = $host->nbfuturemooc;
            $thematic->nbuser           = $host->nbuser;
            $thematic->nbpost           = $host->nbpost;
            $thematic->nbconnected      = $host->nbconnected;
            $thematic->illustration     = $host->illustration;
            $thematic->logo             = $host->logo;
            $thematic->timeupdated      = time();
            $DB->update_record('thematic_info', $thematic);
        } else {
            $thematic = new \stdClass();
            $thematic->hostid           = $host->id;
            $thematic->available        = $host->available;
            $thematic->nbmooc           = $host->nbmooc;
            $thematic->nbinprogressmooc = $host->nbinprogressmooc;
            $thematic->nbfuturemooc     = $host->nbfuturemooc;
            $thematic->nbuser           = $host->nbuser;
            $thematic->nbpost           = $host->nbpost;
            $thematic->nbconnected      = $host->nbconnected;
            $thematic->illustration     = $host->illustration;
            $thematic->logo             = $host->logo;
            $thematic->timeupdated      = time();
            $DB->insert_record('thematic_info', $thematic);
        }

        return $host;
    }

    /**
     * Get informations of the current Thematic.
     *
     * @return array $data
     */
    static public function retreive_local_thematic_info() {
        global $CFG, $PAGE;

        $data = array();

        // Get total number of Moocs on the thematic.
        $filter = new \stdclass();
        $nbmooc = utilities_course::get_courses_catalogue_count($filter);
        $data[] = array ('type' => 'int', 'name' => 'nbmooc', 'value' => $nbmooc);

        // Get number of Moocs in progress.
        $filter->statusid[0] = 1;
        $nbinprogressmooc = utilities_course::get_courses_catalogue_count($filter);
        $data[] = array ('type' => 'int', 'name' => 'nbinprogressmooc', 'value' => $nbinprogressmooc);

        // Get number of Moocs to be started.
        $filter->statusid[0] = 2;
        $nbfuturemooc = utilities_course::get_courses_catalogue_count($filter);
        $data[] = array ('type' => 'int', 'name' => 'nbfuturemooc', 'value' => $nbfuturemooc);

        // Get illustration.
        if (theme_utilities::is_theme_settings_exists_and_nonempty('homepageillustration')) {
            $context = \context_system::instance();
            $file = utilities_image::get_moodle_stored_file($context, 'theme_halloween', 'homepageillustration');
            // Image size : in small screen, one item.
            $illustrationurl = utilities_image::get_resized_url($file,
                    array('w' => 664, 'h' => 354, 'scale' => true));
            $data[] = array ('type' => 'url', 'name' => 'illustration', 'value' => $illustrationurl);
        }

        // Get logo.
        if (theme_utilities::is_theme_settings_exists_and_nonempty('homepagelogo')) {
            $context = \context_system::instance();
            $file = utilities_image::get_moodle_stored_file($context, 'theme_halloween', 'homepagelogo');
            $logourl = utilities_image::get_resized_url($file,
                    array('w' => 100, 'h' => 100, 'scale' => true));
            // In case an error occurs we have a moodle_url as return.
            if (is_a ( $logourl , 'moodle_url')) {
                error_log("Thematic logo error");
            } else {
                $data[] = array ('type' => 'url', 'name' => 'logo', 'value' => $logourl);
            }
        }

        // Number of registered users.
        $data[] = array ('type' => 'int', 'name' => 'nbuser', 'value' => utilities_user::get_nbusers());

        // Number of connected users.
        $data[] = array ('type' => 'int', 'name' => 'nbconnected', 'value' => utilities_user::get_nbconnectedusers());

        // Number of posts.
        $data[] = array ('type' => 'int', 'name' => 'nbpost', 'value' => \forumng_object::get_nbposts());

        // Data available.
        $data[] = array ('type' => 'int', 'name' => 'available', 'value' => true);

        return $data;
    }

    /**
     * retreive informations of a remote Thematic.
     *
     * @params host $host
     * @return object $host
     */
    static public function retreive_remote_thematic_info($host) {
        global $CFG, $PAGE;

        $host->available = false;
        // Check that Webservice is activated.
        if (!theme_utilities::is_theme_settings_exists_and_nonempty('webservicestoken'.$host->id)) {
            error_log('Resac WebService not configurated - Cannot get thematic informations');
            return $host;
        }

        require_once($CFG->libdir . '/filelib.php'); // Include moodle curl class.
        $token = $PAGE->theme->settings->{"webservicestoken{$host->id}"};
        $serverurl = new \moodle_url($host->url . '/webservice/rest/server.php',
                array('wstoken' => $token,
                    'wsfunction' => 'local_orange_library_get_thematic_info',
                    'moodlewsrestformat' => 'json'));
        $curl = new \curl;
        $thematic = json_decode($curl->post(
                htmlspecialchars_decode($serverurl->__toString())));

        if ($thematic && is_object($thematic) && $thematic->errorcode) {
            error_log('Resac Get Thematic Info Request Returned An Error. Message: '
                    . $thematic->message);
            $thematic = false;
        }

        if (empty($thematic)) {
            return $host;
        }

        foreach ($thematic as $field) {
            $host->{$field->name} = $field->value;
        }

        // In case image have not be set on thematics.
        if (empty($host->logo)) {
            $host->logo = $CFG->wwwroot . "/blocks/orange_thematics_menu/pix/defaultlogo.png";
        }
        if (empty($host->illustration)) {
            $host->illustration = $CFG->wwwroot . "/blocks/orange_thematics_menu/pix/defaultillustration.jpg";
        }

        $host->available = true;

        return $host;
    }
}
