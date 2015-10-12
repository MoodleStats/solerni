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
$orangelistrulesurl = '/local/orange_rules/index.php?sesskey=' . sesskey().'&action=rules_list';
$orangeaddrulesurl = '/local/orange_rules/view.php?sesskey=' . sesskey();

if ($hassiteconfig or has_capability('local/orange_rules:edit', context_system::instance())) {

    $ADMIN->add('root', new admin_category('rule', get_string('ruleslink', $orangeplugin)));

    $ADMIN->add('rule', new admin_externalpage('orangeruleslist', get_string('ruleslinklist', $orangeplugin),
        new moodle_url($orangelistrulesurl),
        array('local/orange_rules:edit')
    ));

    $ADMIN->add('rule', new admin_externalpage('orangerulesadd', get_string('ruleslinkadd', $orangeplugin),
        new moodle_url($orangeaddrulesurl),
        array('local/orange_rules:edit')
    ));
}