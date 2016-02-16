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
 * orange_action block config form class
 * 
 * @package block_orange_action
 * @copyright  2016 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->dirroot.'/blocks/orange_action/lib.php');

class block_orange_action_edit_form extends block_edit_form {
    protected function specific_definition($mform) {

        if (block_orange_action_on_my_page()) {
            // Section header title according to language file.
            $mform->addElement('header', 'configheader', get_string('myconfig', 'block_orange_action'));

            $mform->addElement('html', '<p>' . get_string('myconfigdesc', 'block_orange_action') . '</p>');

            $courses = block_orange_action_get_courses_list();
            $mform->addElement('select', 'config_coursetopush', get_string('coursetopush', 'block_orange_action'), $courses);
            $mform->addElement('html', '<span>' . get_string('coursetopush_help', 'block_orange_action') . "</span><br /><br />");

            $events = block_orange_action_get_events_list();
            $mform->addElement('select', 'config_eventtopush', get_string('eventtopush', 'block_orange_action'), $events);
            $mform->addElement('html', '<span>' . get_string('eventtopush_help', 'block_orange_action') . "</span><br/><br />");
        }
    }
}