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
 * Orange_thematics packaging system
 *
 * @package    local
 * @subpackage orange_thematics
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->dirroot . '/local/orange_thematics/forms/orange_thematics_form.php');
require_once($CFG->dirroot . '/local/orange_thematics/forms/orange_thematics_list.php');
require_once($CFG->dirroot . '/local/orange_thematics/lib.php');

class orange_thematics {

    protected $action;
    protected $renderable;
    protected $list;

    public function __construct($action) {
        $this->action = $action;
        $this->renderable = new orange_thematics_form();
    }


    /**
     * Outputs the packaging form
     */
    public function thematics_form() {
        global $DB;

        $get = new stdClass();

        foreach ($_GET as $varname => $value) {
            $get->{"$varname"} = $value;
        }

        // Create or modify.
        $toform = new stdClass();
        if (isset($get->id)) {
            $tobemodified = $DB->get_record('orange_thematics', array ('id' => $get->id));
            $toform->id = $tobemodified->id;
            $toform->name = $tobemodified->name;
        }

        $this->renderable->set_data($toform);

    }

    /**
     * Delete thematic and redirects to the list page
     */
    public function thematics_delete() {
        global $DB;

        if (empty($_GET)) {
            return false;
        }

        // List of thematics associated to a course (Even if table course_format_options doesn't exist, this script is valid).
        $listidthematic = array();
        try {
            $formatoptions = $DB->get_records('course_format_options', array ('name' => 'coursethematics'));
            foreach ($formatoptions as $formatoption) {
                $listidthematic = array_merge($listidthematic, explode(",", $formatoption->value));
            }
            $listidthematic = array_unique($listidthematic);

        } catch (Exception $e) {
            // If table doesn't exist, the array listidthematic is empty.
        }

        $get = new stdClass();
        foreach ($_GET as $varname => $value) {
            $get->{"$varname"} = $value;
        }

        $tobedeleted = $DB->get_record('orange_thematics', array ('id' => $get->id));

        if (!in_array($get->id, $listidthematic)) {
            $DB->delete_records('orange_thematics', array ('id' => $get->id));
            $returnurl = new moodle_url('index.php', array('action' => 'thematics_list', 'sesskey' => sesskey()));
            redirect($returnurl, get_string('thematicdeleted', 'local_orange_thematics', format_text($tobedeleted->name)));
        } else {
            $returnurl = new moodle_url('index.php', array('action' => 'thematics_list', 'sesskey' => sesskey()));
            redirect($returnurl, get_string('impossiblethematicdeleted', 'local_orange_thematics',
                format_text($tobedeleted->name)));
        }
    }

    /**
     * Add new thematic or update if it exists. Redirects to the list page.
     */
    public function thematics_add() {
        global $DB;

        if (empty($_POST)) {
            return false;
        }

        $thematic = new stdClass();
        foreach ($_POST as $varname => $value) {
            // Mtrace($varname."=".$value."<br/>");.
            $thematic->{"$varname"} = $value;
        }

        if (isset($thematic->id)) {
            if ($thematic->id == 0) {
                $DB->insert_record('orange_thematics', $thematic, false);
            } else {
                $DB->update_record('orange_thematics', $thematic);
            }
        }

        $returnurl = new moodle_url('index.php', array('action' => 'thematics_list', 'sesskey' => sesskey()));

        redirect($returnurl);
    }

    /**
     * Outputs list of thematics.
     */
    public function thematics_list() {
        global $DB, $OUTPUT;

        $sitecontext = context_system::instance();

        $stredit   = get_string('edit');
        $strdelete = get_string('delete');

        $table = new html_table();
        $table->head = array ();
        $table->colclasses = array();
        $table->attributes['class'] = 'admintable generaltable';
        $table->head[] = get_string('thematicid', 'local_orange_thematics');
        $table->head[] = get_string('thematicname', 'local_orange_thematics');

        $table->id = "thematics";

        // List of thematics associated to a course (Even if table course_format_options doesn't exist, this script is valid).
        $listidthematic = array();
        try {
            $formatoptions = $DB->get_records('course_format_options', array ('name' => 'coursethematics'));
            foreach ($formatoptions as $formatoption) {
                $listidthematic = array_merge($listidthematic, explode(",", $formatoption->value));
            }
            $listidthematic = array_unique($listidthematic);

        } catch (Exception $e) {
            // If table doesn't exist, the array listidthematic is empty.
        }

        $thematics = thematic_get_thematic();

        foreach ($thematics as $thematic) {

            $buttons = array();
            if (has_capability('local/orange_thematics:edit', $sitecontext)) {

                $buttons[] = html_writer::link(new moodle_url('view.php',
                                                                  array('action' => 'thematics_form',
                                                                          'id' => $thematic->id,
                                                                        'sesskey' => sesskey())),
                                                   html_writer::empty_tag('img',
                                                                          array('src' => $OUTPUT->pix_url('t/edit'),
                                                                                'alt' => $stredit,
                                                                                'class' => 'iconsmall')),
                                                   array('title' => $stredit));

                // If thematic is not associated to a course, we can show the button delete.
                if (!in_array($thematic->id, $listidthematic)) {
                    $msgpopup = get_string('confirmdeletethematic', 'local_orange_thematics', strip_tags($thematic->name));
                    $buttons[] = html_writer::link( new moodle_url('index.php',
                            array('action' => 'thematics_delete', 'id' => $thematic->id,
                                    'sesskey' => sesskey())),
                            html_writer::empty_tag('img',
                                    array('src' => $OUTPUT->pix_url('t/delete'),
                                            'alt' => $strdelete,
                                            'class' => 'iconsmall')),
                            array('title' => $strdelete, 'onclick' => "return confirm('$msgpopup')")
                    );
                }

            }
            $row = array ();
            $row[] = $thematic->id;
            $row[] = "<a href=\"view.php?sesskey=".sesskey()."&action=thematics_form&id=$thematic->id\">$thematic->name</a>";

            $row[] = implode(' ', $buttons);
            $table->data[] = $row;
        }

        $this->list = $table;

    }


    /**
     * Render.
     */
    public function render() {
        global $PAGE;

        $renderer = $PAGE->get_renderer('local_orange_thematics');
        return $renderer->render_orange_wrapper($this->renderable, $this->action, $this->list);

    }

}
