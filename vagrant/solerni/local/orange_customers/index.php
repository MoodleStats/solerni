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
 * Orange_customers front controller
 *
 * @package    local
 * @subpackage orange_customers
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/local/orange_customers/classes/orange_customers.class.php');
require_once($CFG->dirroot . '/local/orange_customers/forms/orange_customers_form.php');

$action = optional_param('action', 'customers_form', PARAM_ALPHAEXT);


// Access control
require_login();
require_capability('moodle/site:config', context_system::instance());
if (!confirm_sesskey()) {
    print_error('confirmsesskeybad', 'error');
}
//mtrace("Action=",$action);
//$context = get_context_instance(CONTEXT_SYSTEM);
$context = context_system::instance();

$url = new moodle_url('/local/local_orange_customers/index.php');
$url->param('action', $action);
$PAGE->set_url($url);
$PAGE->set_context($context);

/*
// Calling the appropiate class
$manager = substr($action, 0, strpos($action, '_'));
//mtrace("Manager=",$manager);
$classname = 'orange_' . $manager;
//mtrace("Classname=",$classname);
$instance = new $classname($action);
*/

$instance = new orange_customers($action);

admin_externalpage_setup('orange_customers_level2');

// Process the action
if (!method_exists($instance, $action)) {
    print_error('actionnotsupported', 'local_orange_customers');
}

$instance->$action();

echo $instance->render();

