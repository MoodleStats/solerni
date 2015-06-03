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
 * Event observers used in orange_rules.
 *
 * @package    local
 * @subpackage orange_rules
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/cohort/lib.php');

/**
 * Event observer for mod_forum.
 */
class local_orange_rules_observer {

    /**
     * Triggered via cohort_deleted event.
     *
     * @param \core\event\cohort_deleted $event
     */
    public static function rule_suspended(\core\event\cohort_deleted $event) {
        global $DB;

        $cohort = (object)$event->get_record_snapshot('cohort', $event->objectid);

        $DB->execute("UPDATE {orange_rules} SET suspended = 1 WHERE cohortid = ". $cohort->id );

    }


    /**
     * Triggered via user_created event.
     *
     * @param \core\event\user_created $event
     */
    public static function user_created(\core\event\user_created $event) {
        global $DB;

        $user = (object)$event->get_record_snapshot('user', $event->objectid);

        // Read Orange Rules activated.
        $clause = array('suspended' => 0);
        $rules = $DB->get_records('orange_rules', $clause);

        // User domain name.
        $emailparts = explode('@', $user->email);
        $userdomain = $emailparts[1];

        foreach ($rules as $rule) {
            // If email match whitelist then add to cohort.
            $emails = array_map("rtrim", explode("\n", $rule->emails));
            if (in_array($user->email, $emails)) {                
                    cohort_add_member($rule->cohortid, $user->id);
            }

            // If the domains of the email match the whitelist.
            $domains = array_map("rtrim", explode("\n", $rule->domains));
            if (in_array($userdomain, $domains)) {
                    cohort_add_member($rule->cohortid, $user->id);
            }
        }
    }

}
