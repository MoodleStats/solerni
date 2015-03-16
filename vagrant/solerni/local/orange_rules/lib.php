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
 * @package   mod_forum
* @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
* @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

defined('MOODLE_INTERNAL') || die();


/// STANDARD FUNCTIONS ///////////////////////////////////////////////////////////

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @param stdClass $rule add forum instance
 * @param mod_forum_mod_form $mform
 * @return int intance id
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
		// before insert : verified if rule name not exist and if cohort is not used by other rules						
		if (rule_existname($rule->name) || rule_existcohortid($rule->cohortid) )
			return false;
		
		$lastinsertid = $DB->insert_record('orange_rules', $rule, false);
				
		//Affects users that match the rule to the cohort

		$emails = explode(PHP_EOL, $rule->emails);
		$domains = explode(PHP_EOL, $rule->domains);				
		
		//list of users who are not in the cohort
		$users = $DB->get_records_sql("SELECT U.id,U.email from mdl_user U
		where U.id not in (select C.userid from mdl_cohort_members C where C.cohortid=".$rule->cohortid . ")");

		foreach($users as $user) {
			// If email match whitelist then add to cohort
			$emailparts = explode('@', $user->email);
			$userdomain = $emailparts[1];
			
			// If the domains of the email match the whitelist then add to cohort
			if ( (in_array($userdomain, $domains)) || (in_array($user->email, $emails)) )						
				cohort_add_member($rule->cohortid, $user->id);
		}
		
	}
	else
		$DB->update_record('orange_rules', $rule);		
	
	//return $rule->id;
	return true;
		
}

function rule_get_rule($id) {
	global $CFG, $DB;
	
	$rule = $DB->get_record('orange_rules', array('id'=>$id));

	return $rule;


}

function rule_get_cohortname($cohortid) {
	global $CFG, $DB;

	$cohort = $DB->get_record('cohort', array('id'=>$cohortid));
	if (isset($cohort->name))
		return $cohort->name;
	else
		return (get_string('cohortdeleted','local_orange_rules'));

}

function rule_existname($name) {
	global $DB;

	return $DB->record_exists('orange_rules', array('name'=>$name));
	
}


function rule_existcohortid($cohortid) {
	global $DB;

	return $DB->record_exists('orange_rules', array('cohortid'=>$cohortid));

}