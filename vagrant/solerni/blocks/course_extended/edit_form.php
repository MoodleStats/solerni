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
 * @package    blocks
 * @subpackage course_extended
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
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
        if (isset($this->config)) {
            if (empty($this->config->title)) {
                $this->title = get_string('defaulttitle', 'block_course_extended');
            } else {
                $this->title = $this->config->title;
            }

            if (empty($this->config->text)) {
                $this->config->text = get_string('defaulttext', 'block_course_extended');
            }
        }
        
        // Adding the "maxvisibility" field.
        $options = array(
            COURSEEXTENDEDPAGE_VISIBILITY_COURSEUSER => get_string('visiblecourseusers', 'block_course_extended'),
            COURSEEXTENDEDPAGE_VISIBILITY_LOGGEDINUSER => get_string('visibleloggedinusers', 'block_course_extended'),
            COURSEEXTENDEDPAGE_VISIBILITY_PUBLIC => get_string('visiblepublic', 'block_course_extended')
            );

        $mform->addElement('select', 'config_maxvisibility', get_string('maxvisibility', 'block_course_extended'), $options);
        $mform->setType('maxvisibility', PARAM_INT);
        $mform->addHelpButton('config_maxvisibility', 'maxvisibility', 'block_course_extended');

    }
}
