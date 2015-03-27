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
 * Goodbye
 *
 * This module has been created to provide users the option to delete their account
 *
 * @package    local
 * @subpackage goodbye, delete your moodle account
 * @copyright  2013 Bas Brands, www.basbrands.nl
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    global $CFG, $USER, $DB;

    $moderator = get_admin();
    $site = get_site();

    $settings = new admin_settingpage('local_goodbye', get_string('pluginname', 'local_goodbye'));
    $ADMIN->add('localplugins', $settings);

    $name = 'local_goodbye/enabled';
    $title = get_string('enabled', 'local_goodbye');
    $description = get_string('enabled_desc', 'local_goodbye');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $settings->add($setting);

    $name = 'local_goodbye/farewell';
    $title = get_string('farewell', 'local_goodbye');
    $description = get_string('farewell_desc', 'local_goodbye');
    $setting = new admin_setting_confightmleditor($name, $title, $description, get_string('defaultfarewell', 'local_goodbye'));
    $settings->add($setting);
}

