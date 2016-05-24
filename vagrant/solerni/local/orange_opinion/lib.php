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
 * @subpackage orange_opinion
 * @copyright  2016 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


// STANDARD FUNCTIONS ///////////////////////////////////////////////////////////.

/**
 * Given an object containing all the necessary data,
 * (defined by the form) this function
 * will create or update a new instance and return true if it was created or updated
 *
 * @param stdClass $opinion
 * @return boolean
 */
function opinion_add_opinion($opinion) {
    global $DB;

    if (!isset($opinion->username)) {
        throw new coding_exception('Missing opinion username in opinion_add_opinion().');
    }

    if ($opinion->id == 0) {
        $opinion->timecreated = time();
        $lastinsertid = $DB->insert_record('orange_opinion', $opinion, false);
        return $lastinsertid;

    } else {
        $opinion->timemodified = time();
        $DB->update_record('orange_opinion', $opinion);
        return $opinion->id;
    }

}

/**
 * Return the opinion identified by $id
 *
 * @param int $id id of opinion
 * @return stdClass $opinion
 */
function opinion_get_opinion($id) {
    global $DB;

    $opinion = $DB->get_record('orange_opinion', array('id' => $id));

    return $opinion;

}