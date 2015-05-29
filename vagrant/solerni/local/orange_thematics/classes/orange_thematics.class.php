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


class orange_thematics  {

    protected $action;
    protected $renderable;
    protected $list;

    public function __construct($action) {

        global $CFG;

        $this->action = $action;
        $this->url = $CFG->wwwroot.'/local/orange_thematics/index.php';
    }


    /**
     * Outputs the packaging form
     */
    public function thematics_form() {
        global $CFG, $PAGE, $DB;

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

        $this->renderable = new orange_thematics_form();
        $this->renderable->set_data($toform);

    }


    /**
     * Outputs list of thematics.
     */
    public function thematics_list() {
        global $CFG, $PAGE, $DB, $OUTPUT;

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

        $thematics = $DB->get_recordset('orange_thematics');

        foreach ($thematics as $thematic) {
            $buttons = array();

            if (has_capability('local/orange_thematics:edit', $sitecontext)) {
                    $msgpopup = get_string('confirmdeletethematic', 'local_orange_thematics', $thematic->name);
                    $buttons[] = html_writer::link( new moodle_url('index.php',
                                                    array('action' => 'thematics_delete', 'id' => $thematic->id,
                                                          'sesskey' => sesskey())),
                                                    html_writer::empty_tag('img',
                                                          array('src' => $OUTPUT->pix_url('t/delete'),
                                                                'alt' => $strdelete,
                                                                'class' => 'iconsmall')),
                                                    array('title' => $strdelete, 'onclick' => "return confirm('$msgpopup')")
                                                   );

                    $buttons[] = html_writer::link(new moodle_url('view.php',
                                                                  array('action' => 'thematics_form',
                                                                          'id' => $thematic->id,
                                                                        'sesskey' => sesskey())),
                                                   html_writer::empty_tag('img',
                                                                          array('src' => $OUTPUT->pix_url('t/edit'),
                                                                                'alt' => $stredit,
                                                                                'class' => 'iconsmall')),
                                                   array('title' => $stredit));
            }
            $row = array ();
            $row[] = $thematic->id;
            $row[] = "<a href=\"view.php?sesskey=".sesskey()."&action=thematics_form&id=$thematic->id\">$thematic->name</a>";

            $row[] = implode(' ', $buttons);
            $table->data[] = $row;
        }

        $thematics->close();
        $this->list = $table;

        $this->renderable = new orange_thematics_list(/* $this->url */);
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
