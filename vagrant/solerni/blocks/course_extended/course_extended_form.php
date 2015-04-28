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
 * @package    block_course_extended
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once("{$CFG->libdir}/formslib.php");
require_once($CFG->dirroot.'/blocks/course_extended/lib.php');
require_once($CFG->dirroot.'/blocks/course_extended/locallib.php');

class course_extended_form extends moodleform {

    public function definition() {
        global $CFG, $DB, $OUTPUT, $PAGE;

        $regstartdate = 'registration_startdate';
        $blockcourseextended = 'block_course_extended';
        $mform =& $this->_form;

        // Add page title element.
        $mform->addElement('header', 'displayinfo', get_string('blocktitle', $blockcourseextended));

        // Adding the "maxvisibility" field.
        $options = array(COURSEEXTENDEDPAGE_VISIBILITY_COURSEUSER => get_string('visiblecourseusers', 'descriptionpage'),
                COURSEEXTENDEDPAGE_VISIBILITY_LOGGEDINUSER => get_string('visibleloggedinusers', 'descriptionpage'),
                COURSEEXTENDEDPAGE_VISIBILITY_PUBLIC => get_string('visiblepublic', 'descriptionpage'));

        $mform->addElement('select', 'maxvisibility', get_string('maxvisibility', 'descriptionpage'), $options);
        $mform->setType('maxvisibility', PARAM_INT);
        $mform->addHelpButton('maxvisibility', 'maxvisibility', 'descriptionpage');

        // Add filename selection.
        $imageoptions = array('maxbytes' => $CFG->maxbytes, 'accepted_types' => array('web_image'));
        $mform->addElement('filepicker', 'picture', get_string('filetitle', $blockcourseextended), null, $imageoptions);

        // Rename the bloc.
        $mform->addElement('text', 'pagetitle', get_string('title', $blockcourseextended));
        $mform->setDefault('pagetitle', get_string('blocktitle_default', $blockcourseextended));
        $mform->setType('pagetitle', PARAM_TEXT);
        $mform->addHelpButton('pagetitle', 'pagetitle', $blockcourseextended);

        // Define the cousre start date.
        $mform->addElement('date_selector', 'startdate', get_string('startdate', $blockcourseextended));
        $mform->setType('startdate', PARAM_ALPHANUM);
        $mform->setDefault('startdate', date($PAGE->course->startdate));

        $mform->addElement('date_selector', 'enddate', get_string('enddate', $blockcourseextended));
        $mform->setType('enddate', PARAM_ALPHANUM);

        $mform->addElement('duration', 'duration', get_string('duration', $blockcourseextended));
        $mform->setType('duration', PARAM_ALPHANUM);

        $mform->addElement('duration', 'workingtime', get_string('workingtime', $blockcourseextended));
        $mform->setType('workingtime', PARAM_ALPHANUM);

        $badges = get_badges();

        foreach ($badges as $value) {
            $optionsbadges[$value->id] = $value->name;
        }
        $mform->addElement('select', 'certification', get_string('certification', $blockcourseextended), $optionsbadges);

        $mform->addElement('text', 'price', get_string('price', $blockcourseextended));
        $mform->setType('price', PARAM_INT);

        $mform->addElement('text', 'language', get_string('language', $blockcourseextended));
        $mform->setType('language', PARAM_TEXT);
        $mform->setDefault('language', $PAGE->course->lang);

        $mform->addElement('advcheckbox', 'video', get_string('video', $blockcourseextended),
            get_string('video', $blockcourseextended));
        $mform->setDefault('video', 0);
        $mform->setType('video', PARAM_BOOL);

        $mform->addElement('date_selector', $regstartdate, get_string($regstartdate, $blockcourseextended));
        $mform->setType($regstartdate, PARAM_ALPHANUM);
        $mform->setDefault($regstartdate, date($PAGE->course->startdate));

        $mform->addElement('date_selector', 'registration_enddate', get_string('registration_enddate', $blockcourseextended));
        $mform->setType('registration_enddate', PARAM_ALPHANUM);

        $mform->addElement('text', 'registeredusers', get_string('registeredusers', $blockcourseextended));
        $mform->setType('registeredusers', PARAM_INT);

        $mform->addElement('text', 'prerequesites', get_string('prerequesites', $blockcourseextended));
        $mform->setType('prerequesites', PARAM_MULTILANG);
        $mform->setDefault('prerequesites', get_string('prerequesites_default', $blockcourseextended));

        $mform->addElement('text', 'teachingteam', get_string('teachingteam', $blockcourseextended));
        $mform->setType('teachingteam', PARAM_MULTILANG);
        $mform->setDefault('teachingteam', get_string('teachingteam_default', $blockcourseextended));

        $mform->addElement('hidden', 'id', 0);
        $mform->setType('id', PARAM_RAW);

        // Hidden elements.
        $mform->addElement('hidden', 'blockid');
        $mform->setType('blockid', PARAM_INT);
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);

        $this->add_action_buttons();
    }
}
