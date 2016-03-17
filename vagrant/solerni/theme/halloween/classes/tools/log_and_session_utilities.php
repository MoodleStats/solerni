<?php
// This file is part of The Orange Halloween Moodle Theme
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

namespace theme_halloween\tools;

use local_orange_library\utilities\utilities_network;

class log_and_session_utilities {

    /**
     * Function checking testsession value and initialize some variables
     * used in login/index.php for error management.
     *
     * @global global $USER
     * @param type int $testsession
     * @return array()
     */
    public static function testsession_initialize($testsession) {
        global $USER;
        $errormsg = '';
        $errorcode = 0;

        // test for errors
        switch(true) {
            // $testsession null, or wrong. No need to go further. This is login first iteration.
            case !isset($testsession):
            case !$testsession:
            case !is_int($testsession):
                break;

            // TODO: try to find out what is the exact reason why sessions do not work.
            // Default message is cookies not enabled. (Comment from Moodle original file).
            case $testsession !== (int)$USER->id:
                $errormsg = get_string("cookiesnotenabled");
                $errorcode = 1;
        }

        return array(
            'errormsg'     => $errormsg,
            'errorcode'    => $errorcode
        );
    }

    /**
     *
     *  Redirect user depending on parameters from login page.
     *
     * @global global $SESSION (object)
     * @param array() $loginstateinit (from testsession_initialize())
     * @param int $testsession (query string)
     * @return void
     */
    public static function login_redirect_user($loginstateinit, $testsession) {

        // If errors or not into $testession, do not redirect.
        if ($loginstateinit['errorcode'] !== 0 || !$testsession) {
            return;
        }

        redirect(self::get_session_user_redirect_url());
    }

    /**
     * This function gets keys from $SESSION to check if user comes from an MNET thematic
     * or have a previously wanted to see a page.
     *
     * Return the URL of one of those keys, or use homepage as default.
     *
     * @global $SESSION
     *
     * @return string (URL)
     *
     */
    public static function get_session_user_redirect_url() {
        global $SESSION, $CFG;

        switch (true) {
            // User needs to be redirect to a previous page.
            case isset($SESSION->wantsurl):
                $urltogo = $SESSION->wantsurl;
                unset($SESSION->wantsurl);
                break;
            default:
                $urltogo = $CFG->wwwroot . '/';
        }

        return $urltogo;

    }

    /**
     * We have hidden field in MNET log form coming from thematics.
     * We have to save this value in $SESSION to use it when redirecting user.
     *
     * @global global $CFG
     * @global global $SESSION
     * @param Object moodle_form $frm
     *
     * @return void
     */
    public static function check_for_mnet_origin($frm) {
        // Compute possible redirect jump to thematic form login form $frm
        if($frm && isset($frm->mnetorigin)) {
            self::set_session_mnet_redirect($frm->mnetorigin);
        }
    }

    public static function set_session_mnet_redirect($thematicurl) {
        global $SESSION, $CFG;
        if ($hosts = utilities_network::get_hosts()) {
            foreach($hosts as $host) {
                if ($host->url == $thematicurl) {
                    $SESSION->mnetredirect = new \moodle_url($CFG->wwwroot . '/auth/mnet/jump.php', array('hostid' => $host->id));
                }
            }
        }
    }

    /**
     *
     * Check conditions to define if we use local database or send the form to MNET HOME.
     *
     * Return array with form action url $formactionhost and boolean $isthematic
     *
     * @global global $CFG
     * @param bool $locallog
     * @return array()
     */
    public static function define_login_form_action($locallog) {
        global $CFG;
        $formactionhost = $CFG->wwwroot;
        $isthematic = false;

        if (utilities_network::is_platform_uses_mnet() && utilities_network::is_thematic() && !$locallog) {
            $homemnet = utilities_network::get_home();
            if ($homemnet) {
                $formactionhost = $homemnet->url;
            }
            $isthematic = true;
        }

        return array(
            'host'          => $formactionhost,
            'isthematic'    => $isthematic
        );
    }

    /**
     * Construction of the URL for registration. If we are on a thematic, we will
     * be directed toward the MNET HOME with the current host and a URL query for
     * post-registration forwarding.
     *
     * @return URL
     */
    public static function get_register_form_url() {
        global $CFG;
        $formaction = self::define_login_form_action(false);
        $query = '';

        if (utilities_network::is_platform_uses_mnet() && $formaction['isthematic']) {
            $query = '?mnetorigin=' . urlencode($CFG->wwwroot);
        }

        return $formaction['host'] . '/login/signup.php' . $query;
    }
}
