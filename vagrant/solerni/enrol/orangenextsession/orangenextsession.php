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
 * Adds new instance of enrol_orangeinvitation to specified course
 * or edits current instance.
 *
 * @package    enrol
 * @subpackage orangenextsession
 * @copyright  Orange 2015 based on Waitlist Enrol plugin / emeneo.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class orangenextsession {
    public function add_nextsession_list($instanceid, $userid) {
        global $DB;

        $nextsession = new stdClass();
        $nextsession->userid = $userid;
        $nextsession->instanceid = $instanceid;
        $nextsession->timecreated = time();

        return $DB->insert_record('user_enrol_nextsession', $nextsession);
    }

    public function vaildate_nextsession_list($instanceid, $userid) {
        global $DB, $CFG;

        $res = $DB->get_records_sql("select * from ".$CFG->prefix."user_enrol_nextsession where instanceid=".
                $instanceid." and userid=".$userid);
        if (count($res)) {
            return false;
        } else {
            return true;
        }
    }

    public function get_nextsession_list($instanceid) {
        global $DB, $CFG;

        return $DB->get_records_sql("select * from ".$CFG->prefix."user_enrol_nextsession where instanceid=".$instanceid);
    }
}