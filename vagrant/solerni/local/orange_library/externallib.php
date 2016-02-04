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

}
