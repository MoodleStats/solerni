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
 * @subpackage orange_rules
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


// STANDARD FUNCTIONS ///////////////////////////////////////////////////////////

/**
 * Given an object containing all the necessary data,
 * (defined by the form) this function
 * will create or update a new instance and return true if it was created or updated
 *
 * @param stdClass $rule 
 * @return boolean
 */
function rule_add_rule($rule) {
    global $CFG, $DB;

    if (!isset($rule->name)) {
        throw new coding_exception('Missing rule name in rule_add_rule().');
    }
    if (!isset($rule->cohortid)) {
        throw new coding_exception('Missing cohortid in rule_add_rule().');
    }
    if (!isset($rule->emails)) {
        $rule->emails = '';
    }
    if (!isset($rule->domains)) {
        $rule->domains = "";
    }

    if ($rule->id == 0) {
        // Before insert or update : verified if rule name not exist and if cohort is not used by other rules.
        if ( rule_existname($rule->name) || rule_existcohortid($rule->cohortid) ) {
            return false;
        }

        $lastinsertid = $DB->insert_record('orange_rules', $rule, false);

    } else {
        $DB->update_record('orange_rules', $rule);
    }

    // Affects users that match the rule to the cohort.
    $emails = array_map("rtrim", explode("\n", $rule->emails));
    $domains = array_map("rtrim", explode("\n", $rule->domains));

    // List of users who are not in the cohort.
    $users = $DB->get_records_sql("SELECT U.id,U.email from mdl_user U
            where U.id not in (select C.userid from mdl_cohort_members C where C.cohortid=".$rule->cohortid . ")");

    foreach ($users as $user) {
        // If email match whitelist then add to cohort.
        $emailparts = explode('@', $user->email);
        $userdomain = $emailparts[1];

        // echo $userdomain . " - " . $user->email . "<br>";
        // If the domains of the email match the whitelist then add to cohort.
        if ( (in_array($userdomain, $domains)) || (in_array($user->email, $emails)) ) {
            // echo "ajout de l'user : " . $user->email . " dans la cohorte <BR>";
            cohort_add_member($rule->cohortid, $user->id);
        }
    }
    // return $rule->id;
    return true;

}

/**
 * Return the rule identified by $id
 *
 * @param int $id id of rule
 * @return stdClass $rule 
 */
function rule_get_rule($id) {
    global $CFG, $DB;

    $rule = $DB->get_record('orange_rules', array('id' => $id));

    return $rule;

}

/**
 * Return the name of cohort if exist or error message (cohort deleted)
 *
 * @param int $cohortid id of cohort
 * @return string
 */
function rule_get_cohortname($cohortid) {
    global $CFG, $DB;

    $cohort = $DB->get_record('cohort', array('id' => $cohortid));
    if (isset($cohort->name)) {
        return $cohort->name;
    } else {
        return (get_string('cohortdeleted', 'local_orange_rules'));
    }
}

/**
 * Return true if this name of rule already exist
 *
 * @param string $name of rule
 * @return boolean
 */
function rule_existname($name) {
    global $DB;

    return $DB->record_exists('orange_rules', array('name' => $name));

}

/**
 * Return true if this cohortid is already affected to one rule
 *
 * @param string $cohortid of rule
 * @return boolean
 */
function rule_existcohortid($cohortid) {
    // In orange_rule.
    global $DB;

    return $DB->record_exists('orange_rules', array('cohortid' => $cohortid));

}

/**
 * Return true if this cohort exist
 *
 * @param string $cohortid id of cohort
 * @return boolean
 */
function rule_existcohort($cohortid) {
    // In cohort.
    global $DB;

    return $DB->record_exists('cohort', array('id' => $cohortid));

}