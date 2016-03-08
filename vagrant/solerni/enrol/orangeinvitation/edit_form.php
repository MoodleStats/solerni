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
 * @subpackage orangeinvitation
 * @copyright  Orange 2015 based on Jerome Mouneyrac invitation plugin{@link http://www.moodleitandme.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');
require_once('locallib.php');

class enrol_orangeinvitation_edit_form extends moodleform {

    public function definition() {
        $mform = $this->_form;

        list($instance, $plugin, $context) = $this->_customdata;

        $mform->addElement('header', 'header', get_string('pluginname', 'enrol_orangeinvitation'));

        $mform->addElement('text', 'name', get_string('custominstancename', 'enrol'));
        $mform->setType('name', PARAM_NOTAGS);

        $options = array(ENROL_INSTANCE_ENABLED  => get_string('yes'),
                         ENROL_INSTANCE_DISABLED => get_string('no'));
        $mform->addElement('select', 'status', get_string('status', 'enrol_orangeinvitation'), $options);
        $mform->setDefault('status', $plugin->get_config('status'));

        $mform->addElement('static', 'customtext1static', get_string('invitationlink', 'enrol_orangeinvitation'));
        $mform->addHelpButton('customtext1static', 'invitationlink', 'enrol_orangeinvitation');

        $mform->addElement('static', 'customtext2static', get_string('enrollink', 'enrol_orangeinvitation'));
        $mform->addHelpButton('customtext2static', 'enrollink', 'enrol_orangeinvitation');

        $mform->addElement('static', 'customtext3static', get_string('nextsessionlink', 'enrol_orangeinvitation'));
        $mform->addHelpButton('customtext3static', 'nextsessionlink', 'enrol_orangeinvitation');

        $mform->addElement('hidden', 'customtext1');
        $mform->setType('customtext1', PARAM_URL);
        $mform->addElement('hidden', 'customtext2');
        $mform->setType('customtext2', PARAM_URL);
        $mform->addElement('hidden', 'customtext3');
        $mform->setType('customtext3', PARAM_URL);
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);

        $this->add_action_buttons(true, ($instance->id ? null : get_string('addinstance', 'enrol')));

        $this->set_data($instance);
    }

    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        return $errors;
    }
}