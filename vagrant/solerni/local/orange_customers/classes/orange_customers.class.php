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
 * Orange_customers packaging system
 *
 * @package    local
 * @subpackage orange_customers
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->dirroot . '/local/orange_customers/forms/orange_customers_form.php');
require_once($CFG->dirroot . '/local/orange_customers/forms/orange_customers_list.php');
require_once($CFG->dirroot . '/local/orange_customers/lib.php');

/**
 * Packaging system manager
 *
 * @package local
 * @subpackage orange_customers
 * @copyright 2015 Orange
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class orange_customers  {

    protected $action;
    protected $renderable;
    protected $list;

    public function __construct($action) {

        global $CFG;

        $this->action = $action;
        $this->url = $CFG->wwwroot.'/local/orange_customers/index.php';
    }


    /**
     * Outputs the packaging form
     */
    public function customers_form() {
        global $CFG, $PAGE, $DB;

        $get = new stdClass();

        foreach ($_GET as $varname => $value) {
            $get->{"$varname"} = $value;
        }

        // Create or modify.
        $toform = new stdClass();
        if (isset($get->id)) {
            $tobemodified = $DB->get_record('orange_customers', array ('id' => $get->id));
            $toform->id = $tobemodified->id;
            $toform->name = $tobemodified->name;
            $toform->summary = $tobemodified->summary;
            $toform->description = $tobemodified->description;
            $toform->logo = $tobemodified->logo;
            $toform->picture = $tobemodified->picture;
        }

        $this->renderable = new orange_customers_form();
        $this->renderable->set_data($toform);

    }

    /*
     *
     */
    public function customers_delete() {
        global $CFG, $PAGE, $DB;

        if (empty($_GET)) {
            return false;
        }

        $get = new stdClass();
        foreach ($_GET as $varname => $value) {
            $get->{"$varname"} = $value;
        }

        $tobedeleted = $DB->get_record('orange_customers', array ('id' => $get->id));
        $DB->delete_records('orange_customers', array ('id' => $get->id));
        $returnurl = new moodle_url('index.php', array('action' => 'customers_list', 'sesskey' => sesskey()));

        redirect($returnurl, get_string('customerdeleted', 'local_orange_customers', $tobedeleted->name));
    }

    /*
     *
     */
    public function customers_list() {
        global $CFG, $PAGE, $DB, $OUTPUT;

        $sitecontext = context_system::instance();

        $stredit   = get_string('edit');
        $strdelete = get_string('delete');

        $table = new html_table();
        $table->head = array ();
        $table->colclasses = array();
        $table->attributes['class'] = 'admintable generaltable';
        $table->head[] = get_string('customerid', 'local_orange_customers');
        $table->head[] = get_string('customername', 'local_orange_customers');
        $table->head[] = get_string('categoryname', 'local_orange_customers');
        $table->head[] = get_string('customersummary', 'local_orange_customers');
        $table->head[] = get_string('customerlogo', 'local_orange_customers');

        $table->id = "customers";

        $customers = $DB->get_recordset('orange_customers');

        $draftitemid = file_get_submitted_draft_itemid('logo');

        foreach ($customers as $customer) {

            // Path of category.
            $category = $DB->get_record('course_categories', array('id' => $customer->categoryid));
            $parentid = $category->parent;
            $namecategory = $category->name;
            $cpt = 0;
            while ( ($parentid != 0) || ($cpt == 10) ) {

                $category = $DB->get_record('course_categories', array('id' => $parentid));
                $namecategory = $category->name . "/" . $namecategory;
                $parentid = $category->parent;
                $cpt++;
            }

            $row = array ();
            $row[] = $customer->id;
            $row[] = "<a href=\"view.php?sesskey=".sesskey()."&action=customers_form&id=$customer->id&categoryname=$namecategory\">$customer->name</a>";

            $row[] = $namecategory;

            $row[] = $customer->summary;
            $fs = get_file_storage();
            $files = $fs->get_area_files($sitecontext->id, 'local_orange_customers', 'logo', $customer->id);
            $urlimg = "";
            foreach ($files as $file) {
                $imgurl = moodle_url::make_pluginfile_url($file->get_contextid(),
                        $file->get_component(),
                        $file->get_filearea(),
                        $file->get_itemid(),
                        $file->get_filepath(),
                        $file->get_filename());
                // We keep only the last (there are a filename).
                $urlimg = "<img src='{$imgurl}' />";
            }
            $row[] = $urlimg;

            $table->data[] = $row;
        }

        $customers->close();
        $this->list = $table;

        html_writer::empty_tag('input', array('type' => 'submit', 'value' => 'hello world !'));
        $this->renderable = new orange_customers_list();
    }

    /*
     *
     */
    public function render() {
        global $PAGE;

        $renderer = $PAGE->get_renderer('local_orange_customers');
        return $renderer->render_orange_wrapper($this->renderable, $this->action, $this->list);

    }

}
