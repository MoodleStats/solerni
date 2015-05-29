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
require_once($CFG->dirroot . '/local/orange_thematics/lib.php');

$id = optional_param('id', 0, PARAM_INT);
$categoryname = optional_param('categoryname', "", PARAM_RAW);
$action = optional_param('action', 'thematics_form', PARAM_ALPHAEXT);

// Access control.
require_login();
require_capability('moodle/site:config', context_system::instance());

if (!confirm_sesskey()) {
    print_error('confirmsesskeybad', 'error');
}

$context = context_system::instance();

$url = new moodle_url('/local/orange_thematics/view.php');
$url->param('action', $action);
$PAGE->set_url($url);
$PAGE->set_context($context);
admin_externalpage_setup('orange_thematics_level2');

$mform = new orange_thematics_form();

if ($mform->is_cancelled()) {
    $returnurl = new moodle_url('index.php', array('action' => 'thematics_list', 'sesskey' => sesskey()));
    redirect($returnurl);
} else if ($fromform = $mform->get_data()) {
    $added = thematic_add_thematic($fromform);
    if ($added) {
        $returnurl = new moodle_url('index.php', array('action' => 'thematics_list', 'sesskey' => sesskey()));
        redirect($returnurl);
    } else {
        // Add message in the page of form.
        echo $OUTPUT->header();
        $mform->display();
        echo $OUTPUT->footer();
    }
} else {
    echo $OUTPUT->header();
    if (isset($_GET['id'])) {
        $thematic = thematic_get_thematic($_GET['id']);
        $mform->set_data($thematic);
    }
    $mform->display();

    echo $OUTPUT->footer();
}