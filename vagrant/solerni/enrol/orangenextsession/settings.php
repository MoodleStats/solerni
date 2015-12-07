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
 * @subpackage orangenextsession
 * @copyright  Orange 2015 based on Waitlist Enrol plugin / emeneo.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    $settings->add(new admin_setting_heading('enrol_orangenextsession_settings', '',
            get_string('pluginname_desc', 'enrol_orangenextsession')));

    $settings->add(new admin_setting_heading('enrol_orangenextsession_defaults',
        get_string('enrolinstancedefaults', 'admin'), get_string('enrolinstancedefaults_desc', 'admin')));

    $settings->add(new admin_setting_configcheckbox('enrol_orangenextsession/defaultenrol',
        get_string('defaultenrol', 'enrol'), get_string('defaultenrol_desc', 'enrol'), 1));

    $options = array(ENROL_INSTANCE_ENABLED  => get_string('yes'),
                     ENROL_INSTANCE_DISABLED => get_string('no'));
    $settings->add(new admin_setting_configselect('enrol_orangenextsession/status',
        get_string('status', 'enrol_orangenextsession'), get_string('status_desc', 'enrol_orangenextsession'),
            ENROL_INSTANCE_DISABLED, $options));

    $settings->add(new admin_setting_configcheckbox('enrol_orangenextsession/sendconfirmationmessage',
        get_string('sendconfirmationmessage', 'enrol_orangenextsession'),
            get_string('sendconfirmationmessage_help', 'enrol_orangenextsession'), 1));
}
