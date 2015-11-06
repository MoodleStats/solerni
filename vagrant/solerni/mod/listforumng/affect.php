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
 * Print the form to manage affect forum in subpart of list
 * @package mod_listforumng
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/mod/listforumng/affect_form.php');
require_once($CFG->dirroot . '/mod/listforumng/lib.php');

$instance = optional_param('instance', 0, PARAM_INT);
$subpartid = optional_param('subpartid', 0, PARAM_INT);
$id = optional_param('id', 0, PARAM_INT);

// Access control.
require_login();

$context = context_system::instance();

$url = new moodle_url('/mod/listforumng/affect.php', array('instance' => $instance, 'subpartid' => $subpartid, 'id' => $id) );

$PAGE->set_url($url);
$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');

// Id course and id of instance listforumng.
$cm = get_coursemodule_from_instance('listforumng', $instance);

$formparams = array($cm->course, $instance, $subpartid, $id);

$mform = new mod_listforumng_affect_form(null, $formparams);

if ($mform->is_cancelled()) {
    $returnurl = new moodle_url('view.php', array('instance' => $instance));
    redirect($returnurl);

} else if ($fromform = $mform->get_data()) {

    $added = lisforumng_add_affect($fromform);
    if ($added) {
        $returnurl = new moodle_url('view.php', array('id' => $id));
        redirect($returnurl);

    } else {
        // Add message in the page of form.
        echo $OUTPUT->header();
        $mform->display();
        echo $OUTPUT->footer();
    }
} else {
    echo $OUTPUT->header();
    if (isset($_GET['subpartid'])) {
        if ($_GET['subpartid'] != 0) {
            $affectation = lisforumng_get_affectation($_GET['subpartid']);
        } else {
            $affectation = lisforumng_get_affectation($_GET['instance']);
        }
        $mform->set_data($affectation);
    }
    $mform->display();

    echo $OUTPUT->footer();
}
