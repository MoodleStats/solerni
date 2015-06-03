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
 * Invitation plugin settings and presets.
 *
 * @package    enrol
 * @subpackage orangeinvitation
 * @copyright  Orange 2015 based on Jerome Mouneyrac invitation plugin{@link http://www.moodleitandme.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    // Settings.
    $settings->add(new admin_setting_heading('enrol_orangeinvitation_settings', '',
        get_string('pluginname_desc', 'enrol_orangeinvitation')));

    // Enrol instance defaults.
    $settings->add(new admin_setting_heading('enrol_orangeinvitation_defaults',
        get_string('enrolinstancedefaults', 'admin'), get_string('enrolinstancedefaults_desc', 'admin')));

    $options = array(ENROL_INSTANCE_ENABLED  => get_string('yes'),
                     ENROL_INSTANCE_DISABLED => get_string('no'));
    $settings->add(new admin_setting_configselect('enrol_orangeinvitation/status',
        get_string('status', 'enrol_orangeinvitation'), get_string('status_desc', 'enrol_orangeinvitation'),
        ENROL_INSTANCE_DISABLED, $options));

}
