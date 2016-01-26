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
 * @package    local-mail
 * @copyright  Marc Català <reskit@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->libdir . '/formslib.php');

class local_mail_preferences_form extends moodleform {

    public function definition() {
        $mform = $this->_form;

        $mform->addElement('header', 'general', get_string('notificationpref', 'local_mail'));

        $mform->addElement('checkbox', 'markasread', get_string('markasread', 'local_mail'));
        $mform->addHelpButton('markasread', 'markasread', 'local_mail');

        $this->add_action_buttons(true, get_string('savechanges'));
    }
}
