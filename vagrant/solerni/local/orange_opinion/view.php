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
 * Orange_opinion front controller
 *
 * @package    local
 * @subpackage orange_opinion
 * @copyright  2016 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/local/orange_opinion/classes/orange_opinion.class.php');
require_once($CFG->dirroot . '/local/orange_opinion/forms/orange_opinion_form.php');
require_once($CFG->dirroot . '/local/orange_opinion/lib.php');

$id = optional_param('id', 0, PARAM_INT);
$action = optional_param('action', 'opinion_form', PARAM_ALPHAEXT);

// Access control.
require_login();
require_capability('local/orange_opinion:edit', context_system::instance());

if (!confirm_sesskey()) {
    print_error('confirmsesskeybad', 'error');
}

$context = context_system::instance();

// New object or update ?
if ($id) {
    $opinion = $DB->get_record('orange_opinion', array('id' => $id), '*', MUST_EXIST);
} else {
    $opinion = new stdClass();
    $opinion->id          = 0;
    $opinion->username    = '';
    $opinion->title = '';
    $opinion->content = '';
    $opinion->dateopinion = '';
    $opinion->moocname = '';
}

$url = new moodle_url('/local/orange_opinion/view.php', array('sesskey' => $USER->sesskey, 'id' => $id));
$url->param('action', $action);
$PAGE->set_url($url);
$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');

/*
$editoroptions = array('maxfiles' => 0, 'context' => $context);
$optionsfilemanager = array(
    'maxfiles' => 1,
    'maxbytes' => $CFG->maxbytes,
    'subdirs' => 0,
    'accepted_types' => 'web_image'
);


$opinion = file_prepare_standard_editor($opinion, 'content', $editoroptions, $context);


$editform = new orange_opinion_form(null,
        array('editoroptions' => $editoroptions, 'data' => $opinion, 'optionsfilemanager' => $optionsfilemanager));
*/
$editform = new orange_opinion_form();

if ($editform->is_cancelled()) {
    $returnurl = new moodle_url('index.php', array('action' => 'opinion_list', 'sesskey' => sesskey()));
    redirect($returnurl);

} else if ($data = $editform->get_data()) {

    //$data = file_postupdate_standard_editor($data, 'content', $editoroptions, $context);

    $added = opinion_add_opinion($data);
    $returnurl = new moodle_url('index.php', array('action' => 'opinion_list', 'sesskey' => sesskey()));

    redirect($returnurl);

} else {
    echo $OUTPUT->header();

    if (isset($_GET['id'])) {       
        $editform->set_data($opinion);
    }

    $editform->display();

    echo $OUTPUT->footer();

}