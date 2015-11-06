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
 * To manage contact form
 *
 * @subpackage contact
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use local_orange_library\utilities\utilities_course;
use local_orange_library\utilities\utilities_object;
require_once($CFG->libdir . '/formslib.php');

class contact_form extends moodleform implements renderable {

    public function definition() {
        global $CFG;

        $mform = & $this->_form;

        $mform->addElement('select', 'requestid', get_string('contact_request_type', 'theme_halloween'));
        $mform->addRule('requestid', null, 'required', null, 'client');

        $mform->addElement('select', 'civilityid', get_string('contact_civility', 'theme_halloween'));

        $mform->addElement('text', 'firstname', get_string('contact_firstname', 'theme_halloween'));
        $mform->setType('firstname', PARAM_TEXT);

        $mform->addElement('text', 'lastname', get_string('contact_lastname', 'theme_halloween'));
        $mform->setType('lastname', PARAM_TEXT);

        $mform->addElement('text', 'email', get_string('contact_email', 'theme_halloween'));
        $mform->addRule('email', null, 'email', null, 'client');
        $mform->setType('email', PARAM_TEXT);

        if (!isloggedin()) {
            $mform->addRule('firstname', null, 'required', null, 'client');
            $mform->addRule('lastname', null, 'required', null, 'client');
            $mform->addRule('email', null, 'required', null, 'client');
        }

        if (!$CFG->solerni_isprivate) {
            $mform->addElement('text', 'company', get_string('contact_company', 'theme_halloween'));
            $mform->setType('company', PARAM_TEXT);

            $mform->addElement('text', 'phone', get_string('contact_phone', 'theme_halloween'));
            $mform->setType('phone', PARAM_TEXT);

            $mform->addElement('text', 'jobtitle', get_string('contact_jobtitle', 'theme_halloween'));
            $mform->setType('jobtitle', PARAM_TEXT);
        }

        $mform->addElement('textarea', 'question', get_string('contact_question', 'theme_halloween'),
            'wrap="virtual" rows="10" cols="50"');
        $mform->addRule('question', null, 'required', null, 'client');
        $mform->setType('question', PARAM_TEXT);

        $mform->addElement('hidden', 'userid', 0);
        $mform->setType('userid', PARAM_INT);

        $mform->addElement('hidden', 'action', 'send_mail');
        $mform->setType('action', PARAM_RAW);

        $this->add_action_buttons();
    }


    public function definition_after_data() {
        global $DB, $USER, $CFG;

        parent::definition_after_data();
        $mform     =& $this->_form;

        $civilityid      =& $mform->getElement('civilityid');
        $civilityid->addOption(get_string('contact_civility_mr', 'theme_halloween'), 1);
        $civilityid->addOption(get_string('contact_civility_mrs', 'theme_halloween'), 2);

        $requestid       =& $mform->getElement('requestid');
        $requestid->addOption(get_string('contact_request_default', 'theme_halloween'), null);
        $filter = new stdClass();
        $filter->categoriesid = array();
        $filter->thematicsid = array();
        $filter->durationsid = null;
        $filter->statusid = array(1, 2);
        $courses = utilities_course::get_courses_catalogue($filter);
        foreach ($courses as $course) {
            $moocname = utilities_object::trim_text(get_string('contact_mooc_help', 'theme_halloween') .
                    $course->fullname, 60, true, false);
            if ($course->visible) {
                $requestid->addOption($moocname, $course->id);
            }
        }
        $requestid->addOption(get_string('contact_request_pb', 'theme_halloween'), CONTACT_REQUEST_PB_ID);
        if (!$CFG->solerni_isprivate) {
            $requestid->addOption(get_string('contact_request_partner', 'theme_halloween'), CONTACT_REQUEST_PARTNER_ID);
            $requestid->addOption(get_string('contact_request_commercial', 'theme_halloween'), CONTACT_REQUEST_COMMERCIAL_ID);
        }
        $requestid->addOption(get_string('contact_request_other', 'theme_halloween'), CONTACT_REQUEST_OTHER_ID);

        if (isloggedin()) {
            $mform->setDefault('firstname', $USER->firstname);
            $mform->setDefault('lastname', $USER->lastname);
            $mform->setDefault('email', $USER->email);
            $mform->setDefault('userid', $USER->id);
            $mform->disabledIf('firstname', 'userid', 'neq', -1);
            $mform->disabledIf('lastname', 'userid', 'neq', -1);
            $mform->disabledIf('email', 'userid', 'neq', -1);
        }
    }

    public function validation($data, $files) {
        global $DB, $contacts;

        $errors = array();
        if (isset($data['requestid'])) {
            if ($data['requestid'] > 0) {
                if ($foundcourse = $DB->get_record('course', array('id' => $data['requestid']))) {
                    if (empty($foundcourse)) {
                        $errors['requestid'] = get_string('contact_requestid_invalid', 'theme_halloween');
                    }
                }
            } else {
                if (!isset($contacts[$data['requestid']])) {
                    $errors['requestid'] = get_string('contact_requestid_invalid', 'theme_halloween');
                }
            }
        } else {
            $errors['requestid'] = get_string('contact_requestid_missing', 'theme_halloween');
        }

        if (!isloggedin()) {
            if (!isset($data['firstname'])) {
                $errors['firstname'] = get_string('err_required', 'form');
            }
            if (!isset($data['lastname'])) {
                $errors['lastname'] = get_string('err_required', 'form');
            }
            if (!isset($data['email'])) {
                $errors['email'] = get_string('err_required', 'form');
            }
        }
        if (!isset($data['question'])) {
            $errors['question'] = get_string('err_required', 'form');
        }

        return $errors;
    }

    /**
     * Overriding formslib's add_action_buttons() method, to rename submit button.
     *
     * @param bool $cancel show cancel button
     * @param string $submitlabel null means default, false means none, string is label text
     * @return void
     */
    public function add_action_buttons($cancel=false, $submitlabel=null) {
        if (is_null($submitlabel)) {
                $submitlabel = get_string('contact_submit', 'theme_halloween');
        }

        $mform = $this->_form;

        $buttonarray = array();

        if ($submitlabel !== false) {
            $buttonarray[] = &$mform->createElement('submit', 'submitbutton', $submitlabel);
        }

        if ($cancel) {
            $buttonarray[] = &$mform->createElement('cancel');
        }

        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
        $mform->setType('buttonar', PARAM_RAW);
        $mform->closeHeaderBefore('buttonar');
    }
}
