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
 * English language strings
 *
 * @package    local
 * @subpackage orange_rules
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Orange Rules';
$string['listrules'] = 'Manage rules';
$string['definerulesheader'] = 'Managing rules';
$string['actionrules_list'] = 'List of rules';
$string['actionrules_form'] = 'Add new rule';

$string['ruleid'] = 'Id.';
$string['rulename'] = 'Rule name';
$string['nbruleemails'] = 'Number of authorized emails';
$string['nbruledomains'] = 'Number of authorized domains';
$string['ruleemails'] = 'List of authorized emails';
$string['ruledomains'] = 'List of authorized domains';
$string['ruleemails_help'] = 'List of authorized emails. One line per email.';
$string['ruledomains_help'] = 'List of authorized domains. One line per domain.';
$string['rulecohorts'] = 'Cohort associated with the rule';
$string['rulecohorts_help'] = 'Only cohorts that are not associated with any rules are presented here';

$string['suspendrule'] = 'Deactivate a rule';
$string['unsuspendrule'] = 'Activate a rule';
$string['impossibleaction'] = "Action impossible, the associated cohort was deleted";
$string['confirmdeleterule'] = 'Are you sure you want to delete the rule <b>{$a}</b> ?';
$string['ruledeleted'] = 'The rule {$a} has been deleted.';
$string['selectcohort'] = 'Select a cohort';
$string['cohortempty'] = 'You must select a cohort';
$string['cohortdeleted'] = 'this rule is not assigned to any cohort';

$string['noaddrulewarning'] = 'The rule can not be created. Two possible reasons: his name already exists or the selected cohort has already been assigned to another rule.';

$string['eventruleupdated'] = 'Rule updated';

$string['orange_rules:edit'] = 'Edit rules';