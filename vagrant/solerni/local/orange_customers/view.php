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
require_once($CFG->dirroot . '/local/orange_customers/lib.php');

$id = optional_param('id', 0, PARAM_INT);
$categoryname = optional_param('categoryname', "", PARAM_RAW);
$action = optional_param('action', 'customers_form', PARAM_ALPHAEXT);

// Access control.
require_login();
require_capability('moodle/site:config', context_system::instance());

if (!confirm_sesskey()) {
    print_error('confirmsesskeybad', 'error');
}

$context = context_system::instance();

// New object or update ?
if ($id) {
    $customer = $DB->get_record('orange_customers', array('id' => $id), '*', MUST_EXIST);
} else {
    $customer = new stdClass();
    $customer->id          = 0;
    $customer->name        = '';
    $customer->description = '';
    $customer->summary = '';
    $customer->logo = 0;
    $customer->picture = 0;
}

$url = new moodle_url('/local/orange_customers/view.php');
$url->param('action', $action);
$PAGE->set_url($url);
$PAGE->set_context($context);
admin_externalpage_setup('orange_customers_level2');

$editoroptions = array('maxfiles' => 0, 'context' => $context);
$optionsfilemanager = array(
    'maxfiles' => 1,
    'maxbytes' => $CFG->maxbytes,
    'subdirs' => 0,
    'accepted_types' => 'web_image'
);

$customer = file_prepare_standard_editor($customer, 'summary', $editoroptions, $context);
$customer = file_prepare_standard_editor($customer, 'description', $editoroptions, $context);
$customer = file_prepare_standard_filemanager($customer, 'logo', $optionsfilemanager,
                                              $context, 'local_orange_customers', 'logo', $customer->id);
$customer = file_prepare_standard_filemanager($customer, 'picture', $optionsfilemanager,
                                              $context, 'local_orange_customers', 'picture', $customer->id);

$editform = new orange_customers_form(null,
        array('editoroptions' => $editoroptions, 'data' => $customer, 'optionsfilemanager' => $optionsfilemanager));

if ($editform->is_cancelled()) {
    $returnurl = new moodle_url('index.php', array('action' => 'customers_list', 'sesskey' => sesskey()));
    redirect($returnurl);

} else if ($data = $editform->get_data()) {

    $data->name = $customer->name;
    $data = file_postupdate_standard_editor($data, 'summary', $editoroptions, $context);
    $data = file_postupdate_standard_editor($data, 'description', $editoroptions, $context);

    $draftitemidl = file_get_submitted_draft_itemid('logo');
    $draftitemidp = file_get_submitted_draft_itemid('picture');

    file_save_draft_area_files($draftitemidl, $context->id, 'local_orange_customers', 'logo', $data->id, $optionsfilemanager );
    file_save_draft_area_files($draftitemidp, $context->id, 'local_orange_customers', 'picture', $data->id, $optionsfilemanager );

    $added = customer_add_customer($data);
    $returnurl = new moodle_url('index.php', array('action' => 'customers_list', 'sesskey' => sesskey()));

    redirect($returnurl);

} else {
    echo $OUTPUT->header();

    if (isset($_GET['id'])) {
        $customer->categoryname = $categoryname;
        $editform->set_data($customer);
    }

    $editform->display();

    echo $OUTPUT->footer();

}