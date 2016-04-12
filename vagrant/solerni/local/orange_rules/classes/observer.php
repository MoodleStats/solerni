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
require_once($CFG->dirroot.'/local/orange_rules/lib.php');

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

        // For OAuth2 the email field is not populated. Not important for Solerni has OAuth2
        // is not used for private MOOC
        if (isset($user->email) && ($user->email != "")) {
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

    /**
     * Triggered via user_updated event.
     *
     * @param \core\event\user_updated $event
     */
    public static function user_updated(\core\event\user_updated $event) {
        global $DB;

        $user = (object)$event->get_record_snapshot('user', $event->objectid);

        // Read Orange Rules activated.
        $clause = array('suspended' => 0);
        $rules = $DB->get_records('orange_rules', $clause);

        // User domain name.
        $emailparts = explode('@', $user->email);
        $userdomain = $emailparts[1];

        foreach ($rules as $rule) {

            $added = false;

            // If email match whitelist then add to cohort.
            $emails = array_map("rtrim", explode("\n", $rule->emails));
            if (in_array($user->email, $emails)) {
                cohort_add_member($rule->cohortid, $user->id);
                $added = true;
            }

            // If the domains of the email match the whitelist.
            $domains = array_map("rtrim", explode("\n", $rule->domains));
            if (in_array($userdomain, $domains)) {
                cohort_add_member($rule->cohortid, $user->id);
                $added = true;
            }

            // If it has not been added and it is not enrolled in a course of the cohort, it is removed.
            if ($added === false && (!is_user_enrolled_in_course($rule, $user->id)) ) {
                cohort_remove_member($rule->cohortid, $user->id);
            }
        }
    }


    /**
     * Triggered via rule_updated event.
     * If an unregistered user at the course no longer satisfies the rule, he is removed from the cohort .
     * 
     * @param \local_orange_rules\event\rule_updated $event
     */
    public static function userregistration_updated(\local_orange_rules\event\rule_updated $event) {

        $rule = (object)$event->get_record_snapshot('orange_rules', $event->objectid);

        // Read Orange Rules.
        $emails = array_map("rtrim", explode("\n", $rule->emails));
        $domains = array_map("rtrim", explode("\n", $rule->domains));

        // List of userid in the cohort.
        $usersmembers = rule_get_users_cohort_member($rule);

        // List of userid enrolled in a course of the cohort.
        $enrolledusers = rule_get_users_enrolled_in_course($rule);

        // Userid in the cohort but not enrolled in a course.
        $usersidtotest = array_diff(array_keys($usersmembers), array_keys($enrolledusers));

        // Test if the user must stay in the cohort.
        foreach ($usersidtotest as $userid) {
            $emailparts = explode('@', $usersmembers[$userid]->email);
            $userdomain = $emailparts[1];
            if ( !in_array($usersmembers[$userid]->email, $emails) && !in_array($userdomain, $domains) ) {
                cohort_remove_member($rule->cohortid, $userid);
            }

        }
    }
}
