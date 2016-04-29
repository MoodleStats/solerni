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
 *
 * Orange Thematics Menu renderer.
 *
 * @package    block_orange_thematics_menu
 * @copyright  2016 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

use theme_halloween\tools\theme_utilities;

/**
 * Get information about a thematic.
 *
 * @param user $user
 */
function block_orange_thematics_menu_get_infos($host) {
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

