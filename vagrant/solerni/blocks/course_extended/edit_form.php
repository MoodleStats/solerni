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
 * @package     block_course_extended
 * @copyright   2012 David Mudrak <david@moodle.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Extends the block instance coinfiguration
 */
class block_course_extended_edit_form extends block_edit_form {


    /**
     * Defines fields to add to the settings form
     *
     * @param moodle_form $mform
     */
    protected function specific_definition($mform) {
        global $CFG,$PAGE, $DB;


        print_object($PAGE->course);
        $maxbytes = 50000;
        //$allowHTML = $CFG->Allow_HTML;
        $allowHTML = get_config('course_extended', 'Allow_HTML');
       

        $mform->addElement('header', 'configheader', get_string('blocksettings', 'core_block'));

       // $mform->addElement('filepicker', 'userfile', get_string('config_filetitle', 'block_course_extended'), null);
        $imageoptions = array('maxbytes' => 262144, 'accepted_types' => array('web_image'));
        $mform->addElement('filepicker', 'picture', get_string('config_filetitle', 'block_course_extended'), null, $imageoptions);
        
        $mform->addElement('text', 'config_title', get_string('config_title', 'block_course_extended'));
        $mform->setDefault('config_title', get_string('config_blocktitle_default', 'block_course_extended'));
        $mform->setType('config_title', PARAM_TEXT);
        $mform->addHelpButton('config_title', 'config_title', 'block_course_extended');

        $mform->addElement('date_selector', 'config_startdate', get_string('startdate', 'block_course_extended'));
        $mform->setType('config_startdate', PARAM_ALPHANUM);
        $mform->setDefault('config_startdate', date($PAGE->course->startdate));

        $mform->addElement('date_selector', 'config_enddate', get_string('enddate', 'block_course_extended'));
        $mform->setType('config_enddate', PARAM_ALPHANUM);

        $mform->addElement('duration', 'config_duration', get_string('duration', 'block_course_extended'));
        $mform->setType('config_duration', PARAM_ALPHANUM);

        $mform->addElement('duration', 'config_workingtime', get_string('workingtime', 'block_course_extended'));
        $mform->setType('config_workingtime', PARAM_ALPHANUM);

        $mform->addElement('text', 'config_cost', get_string('price', 'block_course_extended'));
        $mform->setType('config_cost', PARAM_INT);

        $mform->addElement('text', 'config_language', get_string('language', 'block_course_extended'));
        $mform->setType('config_language', PARAM_TEXT);
        $mform->setDefault('config_language', $PAGE->course->lang);

        $mform->addElement('advcheckbox', 'config_video', get_string('video', 'block_course_extended'),
            get_string('video', 'block_course_extended'));
        $mform->setDefault('config_video', 0);
        $mform->setType('config_video', PARAM_BOOL);

        $mform->addElement('date_selector', 'config_registration_startdate', get_string('registration_startdate', 'block_course_extended'));
        $mform->setType('config_registration_startdate', PARAM_ALPHANUM);
        $mform->setDefault('config_registration_startdate', date($PAGE->course->startdate));

        $mform->addElement('date_selector', 'config_registration_enddate', get_string('registration_enddate', 'block_course_extended'));
        $mform->setType('config_registration_enddate', PARAM_ALPHANUM);
        
         $mform->addElement('text', 'config_registeredusers', get_string('registeredusers', 'block_course_extended'));
        $mform->setType('config_registeredusers', PARAM_INT);

        $mform->addElement('text', 'config_prerequisites', get_string('prerequisites', 'block_course_extended'));
        $mform->setType('config_prerequisites', PARAM_MULTILANG);
        $mform->setDefault('config_prerequisites', get_string('prerequisites_default', 'block_course_extended'));
       //$mform->setType('config_prerequisites', PARAM_MULTILANG);

        $mform->addElement('text', 'config_teachingteam', get_string('teachingteam', 'block_course_extended'));
        $mform->setType('config_teachingteam', PARAM_MULTILANG);
        $mform->setDefault('config_teachingteam', get_string('teachingteam_default', 'block_course_extended'));

        $mform->addElement('hidden', 'id', 0);
        $mform->setType('id',PARAM_RAW);        
    }
}
