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
 * @package    local
 * @subpackage orange_thematics
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


// STANDARD FUNCTIONS ///////////////////////////////////////////////////////////.

/**
 * Given an object containing all the necessary data,
 * (defined by the form) this function
 * will create or update a new instance and return true if it was created or updated
 *
 * @param stdClass $thematic 
 * @return int
 */
function thematic_add_thematic($thematic) {
    global $DB;

    if (!isset($thematic->name)) {
        throw new coding_exception('Missing thematic name in thematic_add_thematic().');
    }

    if ($thematic->id == 0) {
        $lastinsertid = $DB->insert_record('orange_thematics', $thematic, false);
        return $lastinsertid;

    } else {
        $DB->update_record('orange_thematics', $thematic);
        return $thematic->id;
    }

}

/**
 * Return the thematic identified by $id or all thematics
 * Language is calculated
 * @param int $id id of thematic
 * @return stdClass $thematics
 */
function thematic_get_thematic($id=null) {
    global $DB;

    if ($id == null) {

        $thematics = $DB->get_records('orange_thematics');

        foreach ($thematics as $key => $thematic) {
            $temp = &$thematics[$key];
            $temp->name = format_text($thematic->name);
        }

    } else {
        $thematics = $DB->get_record('orange_thematics', array('id' => $id));
        $thematics->name = format_text($thematics->name);
    }

    return $thematics;

}

/**
 * Return the thematic identified by $id or all thematics
 * return all languages
 * @param int $id id of thematic
 * @return stdClass $thematics
 */
function thematic_get_thematic_alllanguages($id=null) {
    global $DB;

    if ($id == null) {
        $thematics = $DB->get_records('orange_thematics');
    } else {
        $thematics = $DB->get_record('orange_thematics', array('id' => $id));
    }

    return $thematics;

}
