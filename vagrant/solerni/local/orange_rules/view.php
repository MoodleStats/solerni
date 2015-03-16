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
 * Solerni front controller
 *
 * @package    local
 * @subpackage orange_rules
 * @copyright  2011 David Monllaó
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/local/orange_rules/classes/orange_rules.class.php');
require_once($CFG->dirroot . '/local/orange_rules/forms/orange_rules_form.php');
require_once($CFG->dirroot . '/local/orange_rules/lib.php');
require_once($CFG->dirroot . '/cohort/lib.php');


$blocks = core_plugin_manager::instance()->get_plugins_of_type('block');
$foundBlockOrange = false;
foreach ($blocks as $block) {
	if ($block->name == "orange_rules")
	{
		$foundBlockOrange = true;
	}
}


$action = optional_param('action', 'rules_form', PARAM_ALPHAEXT);

// Access control
require_login();
require_capability('moodle/site:config', context_system::instance());
if (!confirm_sesskey()) {
    print_error('confirmsesskeybad', 'error');
}

$context = context_system::instance();

$url = new moodle_url('/local/orange_rules/view.php');
$url->param('action', $action);
$PAGE->set_url($url);
$PAGE->set_context($context);
admin_externalpage_setup('orange_rules_level2');
$mform = new orange_rules_form();


if($mform->is_cancelled()) {
	$returnurl = new moodle_url('index.php', array('action'=>'rules_list','sesskey'=>sesskey()));
	redirect($returnurl);
} else if ($fromform = $mform->get_data()) {		
	$added = rule_add_rule($fromform);
	if ($added) {			
		$returnurl = new moodle_url('index.php', array('action'=>'rules_list','sesskey'=>sesskey()));	
		redirect($returnurl);
	}
	else {
		//Ajout d'un message d'erreur sur la page du formulaire :
		echo $OUTPUT->header();
		echo html_writer::tag('div', clean_text(get_string('noaddrulewarning', 'local_orange_rules')), array('class' => renderer_base::prepare_classes('notifyproblem')));
		$mform->display();
		echo $OUTPUT->footer();
	}	
} else {	
	echo $OUTPUT->header();	
	if (!$foundBlockOrange) echo html_writer::tag('div', clean_text(get_string('blockorangewarning', 'local_orange_rules')), array('class' => renderer_base::prepare_classes('notifyproblem')));
	
	if (isset($_GET['id'])) {		
		$rule = rule_get_rule($_GET['id']);	
		$mform->set_data($rule);		
	}
	$mform->display();	
			
	echo $OUTPUT->footer();
}