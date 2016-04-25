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
 * To manage opinion
 *
 * @package    local
 * @subpackage orange_opinion
 * @copyright  2016 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->libdir . '/formslib.php');

/**
 * Form to select the ingredients to deploy
 *
 * @package local
 * @subpackage orange_opinion
 * @copyright 2016 Orange
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class orange_opinion_form extends moodleform implements renderable {

    public function definition() {
        global $CFG;

        $mform = & $this->_form;
        // Step header.
        $steplabel = get_string('defineopinionheader', 'local_orange_opinion');
        $mform->addElement('header', 'flavourdata', $steplabel);

        $mform->addElement('text', 'username', get_string('username', 'local_orange_opinion'), array('size' => '64'));
        $mform->setType('username', PARAM_TEXT);
        $mform->addRule('username', null, 'required', null, 'client');

        $mform->addElement('textarea', 'title', get_string('title', 'local_orange_opinion'));
        $mform->addRule('title', null, 'required', null, 'client');
        $mform->setType('title', PARAM_TEXT);
        $mform->setDefault('title', get_string('defaulttitle', 'local_orange_opinion'));

        $mform->addElement('textarea', 'moocname', get_string('moocname', 'local_orange_opinion'));
        $mform->addRule('moocname', null, 'required', null, 'client');
        $mform->setType('moocname', PARAM_TEXT);
        $mform->addHelpButton('moocname', 'moocname', 'local_orange_opinion');
        $mform->setDefault('moocname', get_string('defaultmoocname', 'local_orange_opinion'));

        $mform->addElement('textarea', 'dateopinion', get_string('date', 'local_orange_opinion'));
        $mform->addRule('dateopinion', null, 'required', null, 'client');
        $mform->setType('dateopinion', PARAM_TEXT);
        $mform->addHelpButton('dateopinion', 'date', 'local_orange_opinion');
        $mform->setDefault('dateopinion', get_string('defaultdate', 'local_orange_opinion'));

        $mform->addElement('textarea', 'content', get_string('content', 'local_orange_opinion'));
        $mform->setType('content', PARAM_TEXT);
        $mform->setDefault('content', get_string('defaultcontent', 'local_orange_opinion'));

        $mform->addElement('hidden', 'id', 0);
        $mform->setType('id', PARAM_RAW);

        $mform->addElement('hidden', 'suspended', 0);
        $mform->setType('suspended', PARAM_RAW);
        $mform->addElement('hidden', 'action', 'opinion_add');
        $mform->setType('action', PARAM_RAW);
        $this->add_action_buttons();
    }


    public function validation($data, $files) {
        $errors = array();
        return $errors;
    }


}
