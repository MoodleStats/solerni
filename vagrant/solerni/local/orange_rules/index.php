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
 * Orange_rules front controller
 *
 * @package    local
 * @subpackage orange_rules
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/local/orange_rules/classes/orange_rules.class.php');
require_once($CFG->dirroot . '/local/orange_rules/forms/orange_rules_form.php');

$action = optional_param('action', 'rules_form', PARAM_ALPHAEXT);


// Access control.
require_login();
require_capability('local/orange_rules:edit', context_system::instance());
if (!confirm_sesskey()) {
    print_error('confirmsesskeybad', 'error');
}

$context = context_system::instance();

$url = new moodle_url('/local/orange_rules/index.php', array('sesskey' => $USER->sesskey));
$url->param('action', $action);
$PAGE->set_url($url);
$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');

$instance = new orange_rules($action);

// Process the action.
if (!method_exists($instance, $action)) {
    print_error('actionnotsupported', 'local_orange_rules');
}

$instance->$action();

echo $instance->render();
