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
 * @package     block_course_essentials
 * @copyright   2012 David Mudrak <david@moodle.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Extends the block instance coinfiguration
 */
class block_course_essentials_edit_form extends block_edit_form {

    /**
     * Defines fields to add to the settings form
     *
     * @param moodle_form $mform
     */
    protected function specific_definition($mform) {
        $maxbytes = 50000;

        $mform->addElement('header', 'configheader', get_string('blocksettings', 'core_block'));

        $mform->addElement('filepicker', 'userfile', get_string('config_filetitle', 'block_course_essentials'), null,
                   array('maxbytes' => $maxbytes, 'accepted_types' => '*'));
        $mform->addElement('text', 'config_blocktitle', get_string('config_blocktitle', 'block_course_essentials'));
        $mform->setDefault('config_blocktitle', '');
        $mform->setType('config_blocktitle', PARAM_MULTILANG);
        $mform->addHelpButton('config_blocktitle', 'config_blocktitle', 'block_course_essentials');

        $mform->addElement('advcheckbox', 'config_enumerate', get_string('config_enumerate', 'block_course_essentials'),
            get_string('config_enumerate_label', 'block_course_essentials'));
        $mform->setDefault('config_enumerate', 1);
        $mform->setType('config_enumerate', PARAM_BOOL);

        $mform->addElement('filepicker', 'userfile', get_string('config_datelogo', 'block_course_essentials'), null,
                   array('maxbytes' => $maxbytes, 'accepted_types' => '*'));
        $mform->addElement('date_selector', 'config_startdate', get_string('config_startdate', 'block_course_essentials'));
        $mform->addHelpButton('config_startdate', 'config_startdate', 'block_course_essentials');

        $mform->addElement('date_selector', 'config_enddate', get_string('config_enddate', 'block_course_essentials'));
        $mform->addHelpButton('config_enddate', 'config_enddate', 'block_course_essentials');

        $mform->addElement('filepicker', 'userfile', get_string('config_durationlogo', 'block_course_essentials'), null,
                   array('maxbytes' => $maxbytes, 'accepted_types' => '*'));
        $mform->addElement('duration', 'config_duration', get_string('config_duration', 'block_course_essentials'));
        $mform->addHelpButton('config_duration', 'config_duration', 'block_course_essentials');

        $mform->addElement('duration', 'config_workingtime', get_string('config_workingtime', 'block_course_essentials'));
        $mform->addHelpButton('config_workingtime', 'config_workingtime', 'block_course_essentials');

        $mform->addElement('filepicker', 'userfile', get_string('config_costlogo', 'block_course_essentials'), null,
                   array('maxbytes' => $maxbytes, 'accepted_types' => '*'));
        $mform->addElement('text', 'config_cost', get_string('config_cost', 'block_course_essentials'));
        $mform->addHelpButton('config_cost', 'config_cost', 'block_course_essentials');

        $mform->addElement('filepicker', 'userfile', get_string('config_languagelogo', 'block_course_essentials'), null,
                   array('maxbytes' => $maxbytes, 'accepted_types' => '*'));
        $mform->addElement('text', 'config_language', get_string('config_language', 'block_course_essentials'));
        $mform->addHelpButton('config_language', 'config_language', 'block_course_essentials');

        $mform->addElement('filepicker', 'userfile', get_string('config_videologo', 'block_course_essentials'), null,
                   array('maxbytes' => $maxbytes, 'accepted_types' => '*'));
        $mform->addElement('text', 'config_video', get_string('config_video', 'block_course_essentials'));
        $mform->addHelpButton('config_video', 'config_video', 'block_course_essentials');

        $mform->addElement('filepicker', 'userfile', get_string('config_registrationlogo', 'block_course_essentials'), null,
                   array('maxbytes' => $maxbytes, 'accepted_types' => '*'));
        $mform->addElement('text', 'config_registration', get_string('config_registration', 'block_course_essentials'));
        $mform->addHelpButton('config_registration', 'config_registration', 'block_course_essentials');

        $mform->addElement('filepicker', 'userfile', get_string('config_registereduserslogo', 'block_course_essentials'), null,
                   array('maxbytes' => $maxbytes, 'accepted_types' => '*'));
        $mform->addElement('text', 'config_registeredusers', get_string('config_registeredusers', 'block_course_essentials'));
        $mform->addHelpButton('config_registeredusers', 'config_registeredusers', 'block_course_essentials');

        $mform->addElement('text', 'config_prerequisites', get_string('config_prerequisites', 'block_course_essentials'));
        $mform->setDefault('config_prerequisites', '');
        //$mform->setType('config_prerequisites', PARAM_MULTILANG);
        $mform->addHelpButton('config_prerequisites', 'config_prerequisites', 'block_course_essentials');

        $mform->addElement('text', 'config_teachingteam', get_string('config_teachingteam', 'block_course_essentials'));
        $mform->setDefault('config_teachingteam', '');
        //$mform->setType('config_teachingteam', PARAM_MULTILANG);
        $mform->addHelpButton('config_teachingteam', 'config_teachingteam', 'block_course_essentials');

    }
}
