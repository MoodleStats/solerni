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
 * To add the Orange_rules links to the administration block
 *
 * @package    local
 * @subpackage orange_rules
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$orangeplugin = 'local_orange_rules';
$orangeaddruleurl = '/local/orange_rules/view.php?sesskey=' . sesskey();
$orangelistrulesurl = '/local/orange_rules/index.php?sesskey=' . sesskey().'&action=rules_list';

$ADMIN->add('localplugins', new admin_externalpage('orange_rules_level2',
    get_string('listrules', $orangeplugin),
    new moodle_url($orangelistrulesurl)));
