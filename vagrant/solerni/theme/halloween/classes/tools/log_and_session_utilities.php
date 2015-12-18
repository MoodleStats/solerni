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

class log_and_session_utilities {


    /**
     * Function to determine if we have to log locally or not on this instance
     */
    public static function is_platform_login_uses_mnet($mnethosts) {
        global $CFG;

        return ($CFG->solerni_isprivate || !is_enabled_auth('mnet') || empty($mnethosts));
    }

    /**
     *
     * @global type $USER
     * @global type $SESSION
     * @param type int $testsession
     * @return type
     */
    public static function test_session_and_initialize($USER, $testsession) {
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

    public static function redirect_user($SESSION, $loginstateinit, $testsession) {

        switch (true) {
            // Error. Cannot redirect
            case $loginstateinit['errorcode'] !== 0:
            case !$testsession:
                return;
            // We are in a mnet situation. mnetredirect variable come from the login page first iteration.
            case isset($SESSION->mnetredirect):
                $urltogo = $SESSION->mnetredirect;
                unset($SESSION->mnetredirect);
                break;
            // User needs to be redirect to a previous page.
            case isset($SESSION->wantsurl):
                $urltogo = $SESSION->wantsurl;
                unset($SESSION->wantsurl);
        }

        redirect($urltogo);
    }
}
