<?php
// This file is part of The Orange Library Plugin
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

defined('MOODLE_INTERNAL') || die();

use local_orange_library\utilities\utilities_network;
use local_orange_library\utilities\utilities_user;

/**
 * Exposes web services as "external" functions
 *
 * @package     local
 * @subpackage  orange_library
 * @copyright  2016 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_orange_library_external extends external_api {

    /**
     * Returns HOME MNET hosts from library utilities_network
     */
    public static function get_resac_hosts() {

        return utilities_network::get_hosts_from_mnethome();
    }

    /**
     * Define function parameters
     *
     * @return \external_function_parameters
     */
    public static function get_resac_hosts_parameters() {
        return new external_function_parameters(
            array()
        );
    }

    /**
     * Define expected function return
     *
     * @return \external_multiple_structure
     */
    public static function get_resac_hosts_returns() {
        return new external_multiple_structure(
            new external_single_structure(
                array(
                    'url'   => new external_value(PARAM_URL, 'host url'),
                    'name'  => new external_value(PARAM_TEXT, 'host name'),
                    'id'    => new external_value(PARAM_INT, 'host id'),
                    'jump'  => new external_value(PARAM_URL, 'host jump url')
                )
            )
        );
    }

    /**
     * Returns User profile fields from library utilities_user
     */
    public static function get_profile_fields($username, $host, $mode) {

        return utilities_user::get_user_profile_fields($username, $host, $mode);
    }

    /**
     * Define function parameters
     *
     * @return \external_function_parameters
     */
    public static function get_profile_fields_parameters() {
        return new external_function_parameters(
            array(
                'username' => new external_value(PARAM_TEXT, 'user name'),
                'host' => new external_value(PARAM_URL, 'remote host'),
                'mode' => new external_value(PARAM_NUMBER, 'Sync mode: 1 is full mode and 0 simple mode'),
            )
        );
    }

    /**
     * Define expected function return
     *
     * @return \external_multiple_structure
     */
    public static function get_profile_fields_returns() {
        return new external_multiple_structure(
            new external_single_structure(
                array(
                    'type'   => new external_value(PARAM_TEXT, 'profile field or preference'),
                    'name'   => new external_value(PARAM_TEXT, 'field name'),
                    'value'  => new external_value(PARAM_TEXT, 'field value')
                )
            )
        );
    }

    /**
     * Returns Thematic information from library utilities_network
     */
    public static function get_thematic_info() {

        return utilities_network::retreive_local_thematic_info();
    }

    /**
     * Define function parameters
     *
     * @return \external_function_parameters
     */
    public static function get_thematic_info_parameters() {
        return new external_function_parameters(
            array()
        );
    }

    /**
     * Define expected function return
     *
     * @return \external_multiple_structure
     */
    public static function get_thematic_info_returns() {
        return new external_multiple_structure(
            new external_single_structure(
                array(
                    'type'   => new external_value(PARAM_TEXT, 'information type'),
                    'name'   => new external_value(PARAM_TEXT, 'information name'),
                    'value'  => new external_value(PARAM_TEXT, 'information value')
                )
            )
        );
    }


    /**
     * Request user deletion from home to Thematic
     */
    public static function del_user_on_thematic($username, $email) {

        return utilities_user::del_user_on_thematic($username, $email);
    }

    /**
     * Define function parameters
     *
     * @return \external_function_parameters
     */
    public static function del_user_on_thematic_parameters() {
        return new external_function_parameters(
            array(
                'username' => new external_value(PARAM_TEXT, 'user name'),
                'email' => new external_value(PARAM_TEXT, 'email')
            )
        );
    }

    /**
     * Define expected function return
     *
     * @return \external_multiple_structure
     */
    public static function del_user_on_thematic_returns() {
        return new external_value(PARAM_INT, 'Command status');
    }


    /**
     * Request user update from home to Thematic
     */
    public static function update_user_on_thematic($username, $email) {

        return utilities_user::update_user_on_thematic($username, $email);
    }

    /**
     * Define function parameters
     *
     * @return \external_function_parameters
     */
    public static function update_user_on_thematic_parameters() {
        return new external_function_parameters(
            array(
                'username' => new external_value(PARAM_TEXT, 'user name'),
                'email' => new external_value(PARAM_TEXT, 'email')
            )
        );
    }

    /**
     * Define expected function return
     *
     * @return \external_multiple_structure
     */
    public static function update_user_on_thematic_returns() {
        return new external_value(PARAM_INT, 'Command status');
    }
}
