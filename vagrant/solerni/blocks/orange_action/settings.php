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
 * Orange Action block settings
 *
 * @package    block_orange_action
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;
require_once($CFG->dirroot.'/blocks/orange_action/classes/admin_setting_courselist.php');
require_once($CFG->dirroot.'/blocks/orange_action/classes/admin_setting_eventlist.php');

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_heading('generalconfig', new lang_string('generalconfig', 'block_orange_action'), ''));

    $settings->add(new admin_setting_configcheckbox('block_orange_action/hideblockheader',
                        new lang_string('hideblockheader', 'block_orange_action'),
                        new lang_string('hideblockheaderdesc', 'block_orange_action'), 1, PARAM_INT));

    $settings->add(new admin_setting_heading('myconfig', new lang_string('myconfig', 'block_orange_action'),
                        new lang_string('myconfigdesc', 'block_orange_action')));
    $settings->add(new block_orange_action_admin_setting_courselist('block_orange_action/course',
                        new lang_string('coursetopush', 'block_orange_action'),
                        new lang_string('coursetopushdesc', 'block_orange_action'), null, PARAM_INT));
    $settings->add(new block_orange_action_admin_setting_eventlist('block_orange_action/event',
                        new lang_string('eventtopush', 'block_orange_action'),
                        new lang_string('eventtopushdesc', 'block_orange_action'), null, PARAM_INT));
}