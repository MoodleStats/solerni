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
 * To manage thematics
 *
 * @package    local
 * @subpackage orange_thematics
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->libdir . '/formslib.php');

/**
 * Form to select the ingredients to deploy
 *
 * @package local
 * @subpackage orange_thematics
 * @copyright 2015 Orange
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class orange_thematics_form extends moodleform implements renderable {

    public function definition() {
        global $CFG;

        $mform = & $this->_form;
        // Step header.
        $steplabel = get_string('definethematicsheader', 'local_orange_thematics');
        $mform->addElement('header', 'flavourdata', $steplabel);

        $mform->addElement('text', 'name', get_string('thematicname', 'local_orange_thematics'));
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->setType('name', PARAM_TEXT);

        $mform->addElement('hidden', 'id', 0);
        $mform->setType('id', PARAM_RAW);
        $mform->addElement('hidden', 'suspended', 0);
        $mform->setType('suspended', PARAM_RAW);
        $mform->addElement('hidden', 'action', 'thematics_add');
        $mform->setType('action', PARAM_RAW);

        $this->add_action_buttons();
    }


    public function validation($data, $files) {
        global $DB;
        $errors = array();

        return $errors;
    }


}
