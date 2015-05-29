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
 * Orange_thematics front controller
 *
 * @package    local
 * @subpackage orange_thematics
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/local/orange_thematics/classes/orange_thematics.class.php');
require_once($CFG->dirroot . '/local/orange_thematics/forms/orange_thematics_form.php');

$action = optional_param('action', 'thematics_form', PARAM_ALPHAEXT);


// Access control.
require_login();
require_capability('moodle/site:config', context_system::instance());
if (!confirm_sesskey()) {
    print_error('confirmsesskeybad', 'error');
}

$context = context_system::instance();

$url = new moodle_url('/local/local_orange_thematics/index.php');
$url->param('action', $action);
$PAGE->set_url($url);
$PAGE->set_context($context);

$instance = new orange_thematics($action);

admin_externalpage_setup('orange_thematics_level2');

// Process the action.
if (!method_exists($instance, $action)) {
    print_error('actionnotsupported', 'local_orange_thematics');
}

$instance->$action();

echo $instance->render();
