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


$action = optional_param('action', 'rules_form', PARAM_ALPHAEXT);

// Access control
require_login();
require_capability('moodle/site:config', context_system::instance());
if (!confirm_sesskey()) {
    print_error('confirmsesskeybad', 'error');
}
//mtrace("Action=",$action);
//$context = get_context_instance(CONTEXT_SYSTEM);
$context = context_system::instance();

$url = new moodle_url('/local/orange_rules/confirm.php');
$url->param('action', $action);
$PAGE->set_url($url);
$PAGE->set_context($context);
admin_externalpage_setup('orange_rules_level2');

$yesurl = new moodle_url('index.php', array('action'=>'rules_delete', 'id'=>$_GET['id'],'sesskey'=>sesskey()));
$nourl = new moodle_url('index.php', array('action'=>'rules_list','sesskey'=>sesskey()));
$message = get_string('confirmdeleterule', 'local_orange_rules');

echo $OUTPUT->header();
echo $OUTPUT->confirm($message, $yesurl, $nourl);
echo $OUTPUT->footer();










