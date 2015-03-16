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
 * To add the flavours links to the administration block
 *
 * @package    local
 * @subpackage flavours
 * @copyright  2011 David Monllaó
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$orangeplugin = 'local_orange_rules';
//$orangeaddruleurl = '/local/orange_rules/index.php?sesskey=' . sesskey().'&action=rules_form';
$orangeaddruleurl = '/local/orange_rules/view.php?sesskey=' . sesskey();
$orangelistrulesurl = '/local/orange_rules/index.php?sesskey=' . sesskey().'&action=rules_list';


$ADMIN->add('localplugins', new admin_category('orange_rules', get_string('pluginname', $orangeplugin)));

$ADMIN->add('orange_rules', new admin_externalpage('orange_rule_level2',
    get_string('addrule', $orangeplugin),
    new moodle_url($orangeaddruleurl)));    
	
$ADMIN->add('orange_rules', new admin_externalpage('orange_rules_level2',
    get_string('listrules', $orangeplugin),
    new moodle_url($orangelistrulesurl)));    

/*
$blocks = core_plugin_manager::instance()->get_plugins_of_type('block');
$foundBlockOrange = false;
foreach ($blocks as $block) {
	if ($block->name == "orange_rules")
	{
		$foundBlockOrange = true;
	}
}
if (!$foundBlockOrange) echo html_writer::tag('div', clean_text(get_string('blockorangewarning', 'local_orange_rules')), array('class' => renderer_base::prepare_classes('notifyproblem')));

*/