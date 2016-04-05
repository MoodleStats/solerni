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
 * To manage rules
 *
 * @package    local
 * @subpackage orange_rules
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->libdir . '/formslib.php');

class orange_rules_form extends moodleform implements renderable {

    public function definition() {

        $mform = & $this->_form;
        // Step header.
        $steplabel = get_string('definerulesheader', 'local_orange_rules');
        $mform->addElement('header', 'flavourdata', $steplabel);

        $mform->addElement('text', 'name', get_string('rulename', 'local_orange_rules'));
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->setType('name', PARAM_TEXT);

        $mform->addElement('textarea', 'emails', get_string('ruleemails', 'local_orange_rules'),
            'wrap="virtual" rows="10" cols="50"');
        $mform->setType('emails', PARAM_TEXT);
        $mform->addHelpButton('emails', 'ruleemails', 'local_orange_rules');

        $mform->addElement('textarea', 'domains', get_string('ruledomains', 'local_orange_rules'),
                           'wrap="virtual" rows="10" cols="50"');
        $mform->setType('domains', PARAM_TEXT);
        $mform->addHelpButton('domains', 'ruledomains', 'local_orange_rules');

        $mform->addElement('select', 'cohortid', get_string('rulecohorts', 'local_orange_rules'));

        $mform->addRule('cohortid', null, 'required', null, 'client');
        $mform->addHelpButton('cohortid', 'rulecohorts', 'local_orange_rules');

        $mform->addElement('hidden', 'id', 0);
        $mform->setType('id', PARAM_RAW);
        $mform->addElement('hidden', 'suspended', 0);
        $mform->setType('suspended', PARAM_RAW);
        $mform->addElement('hidden', 'action', 'rules_add');
        $mform->setType('action', PARAM_RAW);

        $this->add_action_buttons();
    }


    public function definition_after_data() {
        global $DB;
        parent::definition_after_data();
        $mform     =& $this->_form;
        $cohortid      =& $mform->getElement('cohortid');
        $cohortidvalue = $mform->getElementValue('cohortid');

        $sql = "SELECT c.id, c.name, r.cohortid AS idcohortrule
        FROM {cohort} c left outer join {orange_rules} r
        ON r.cohortid = c.id
        group by c.id, c.name";

        $cohorts = $DB->get_records_sql($sql);

        foreach ($cohorts as $cohort) {
            if ($cohort->idcohortrule == null || $cohort->id == $cohortidvalue[0] ) {
                $cohortid->addOption($cohort->name, $cohort->id);
            } else {
                $cohortid->addOption($cohort->name, $cohort->id, array( 'disabled' => 'disabled' ));
            }
        }
    }



    public function validation($data, $files) {
        $errors = array();

        return $errors;
    }

}
