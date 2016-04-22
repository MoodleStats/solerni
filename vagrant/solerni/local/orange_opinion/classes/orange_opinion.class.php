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
 * Orange_opinion packaging system
 *
 * @package    local
 * @subpackage orange_opinion
 * @copyright  2016 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->dirroot . '/local/orange_opinion/forms/orange_opinion_form.php');
require_once($CFG->dirroot . '/local/orange_opinion/forms/orange_opinion_list.php');
require_once($CFG->dirroot . '/local/orange_opinion/lib.php');

/**
 * Packaging system manager
 *
 * @package local
 * @subpackage orange_opinion
 * @copyright 2016 Orange
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class orange_opinion  {

    protected $action;
    protected $renderable;
    protected $list;

    public function __construct($action) {

        global $CFG;

        $this->action = $action;
        $this->url = $CFG->wwwroot.'/local/orange_opinion/index.php';
    }


    /**
     * Outputs the packaging form
     */
    public function opinion_form() {
        global $DB;

        $get = new stdClass();

        foreach ($_GET as $varname => $value) {
            $get->{"$varname"} = $value;
        }

        // Create or modify.
        $toform = new stdClass();
        if (isset($get->id)) {
            $tobemodified = $DB->get_record('orange_opinion', array ('id' => $get->id));
            $toform->id = $tobemodified->id;
            $toform->username = $tobemodified->username;
            $toform->title = $tobemodified->title;
            $toform->content = $tobemodified->content;
            $toform->dateopinion = $tobemodified->dateopinion;
            $toform->suspended = $tobemodified->suspended;
            $toform->moocname = $tobemodified->moocname;
        }

        $this->renderable = new orange_opinion_form();
        $this->renderable->set_data($toform);

    }



    public function opinion_delete() {
        global $DB;

        if (empty($_GET)) {
            return false;
        }

        $get = new stdClass();
        foreach ($_GET as $varname => $value) {
            $get->{"$varname"} = $value;
        }

        $tobedeleted = $DB->get_record('orange_opinion', array ('id' => $get->id));
        $DB->delete_records('orange_opinion', array ('id' => $get->id));
        $returnurl = new moodle_url('index.php', array('action' => 'opinion_list', 'sesskey' => sesskey()));
        redirect($returnurl);
    }

    public function opinion_suspend() {
        global $DB;

        if (empty($_GET)) {
            return false;
        }

        $get = new stdClass();
        foreach ($_GET as $varname => $value) {
            $get->{"$varname"} = $value;
        }

        $opinion = new stdClass();
        $opinion->id = $get->id;
        $opinion->suspended = true;

        $DB->update_record('orange_opinion', $opinion);
        $returnurl = new moodle_url('index.php', array('action' => 'opinion_list', 'sesskey' => sesskey()));
        redirect($returnurl);
    }

    public function opinion_unsuspend() {
        global $DB;

        if (empty($_GET)) {
            return false;
        }

        $get = new stdClass();
        foreach ($_GET as $varname => $value) {
            $get->{"$varname"} = $value;
        }

        $opinion = new stdClass();
        $opinion->id = $get->id;
        $opinion->suspended = true;

        $DB->update_record('orange_opinion', $opinion);

        $returnurl = new moodle_url('index.php', array('action' => 'opinion_list', 'sesskey' => sesskey()));
        redirect($returnurl);
    }

    /**
     * Outputs list of opinions.
     */
    public function opinion_list() {
        global $DB, $OUTPUT;

        $sitecontext = context_system::instance();

        $strsuspend = get_string('suspendopinion', 'local_orange_opinion');
        $strunsuspend = get_string('unsuspendopinion', 'local_orange_opinion');

        $table = new html_table();
        $table->head = array ();
        $table->colclasses = array();
        $table->attributes['class'] = 'admintable generaltable';
        $table->head[] = get_string('username', 'local_orange_opinion');
        $table->head[] = get_string('content', 'local_orange_opinion');
        $table->head[] = get_string('date', 'local_orange_opinion');
        $table->head[] = "";

        $table->id = "opinion";

        $opinions = $DB->get_recordset('orange_opinion');

        $draftitemid = file_get_submitted_draft_itemid('logo');

        foreach ($opinions as $opinion) {
            $buttons = array();
            if (has_capability('local/orange_opinion:edit', $sitecontext)) {
                    $msgpopup = get_string('confirmdeleteopinion', 'local_orange_opinion', $opinion->username);
                    $buttons[] = html_writer::link( new moodle_url('index.php',
                                                    array('action' => 'opinion_delete', 'id' => $opinion->id, 'sesskey' => sesskey())),
                                                    html_writer::empty_tag('img',
                                                          array('src' => $OUTPUT->pix_url('t/delete'),
                                                                'alt' => get_string('delete'),
                                                                'class' => 'iconsmall')),
                                                    array('title' => get_string('delete'), 'onclick' => "return confirm('$msgpopup')")
                                                   );
                if ($opinion->suspended) {
                        $buttons[] = html_writer::link(new moodle_url('index.php',
                                                                    array('action' => 'opinion_unsuspend',
                                                                            'id' => $opinion->id,
                                                                            'sesskey' => sesskey())),
                                                       html_writer::empty_tag('img',
                                                                                 array('src' => $OUTPUT->pix_url('t/show'),
                                                                                    'alt' => $strunsuspend,
                                                                                    'class' => 'iconsmall')),
                                                       array('title' => $strunsuspend));
                    
                } else {
                    $buttons[] = html_writer::link(new moodle_url('index.php',
                                                                  array('action' => 'opinion_suspend',
                                                                          'id' => $opinion->id,
                                                                          'sesskey' => sesskey())),
                                                   html_writer::empty_tag('img',
                                                                          array('src' => $OUTPUT->pix_url('t/hide'),
                                                                                   'alt' => $strsuspend,
                                                                                   'class' => 'iconsmall')),
                                                   array('title' => $strsuspend));
                }
                    $buttons[] = html_writer::link(new moodle_url('view.php',
                                                                  array('action' => 'opinion_form',
                                                                          'id' => $opinion->id,
                                                                        'sesskey' => sesskey())),
                                                   html_writer::empty_tag('img',
                                                                          array('src' => $OUTPUT->pix_url('t/edit'),
                                                                                'alt' => get_string('edit'),
                                                                                'class' => 'iconsmall')),
                                                   array('title' => get_string('edit')));
            }
                       
            $row = array();
            $row[] = "<a href=\"view.php?sesskey=".sesskey()."&id=$opinion->id\">
                     $opinion->username</a>";
            $row[] = "<strong>" . format_text($opinion->title) . "</strong>" . format_text($opinion->content);
            $row[] = format_text($opinion->dateopinion);
            $row[] = implode(' ', $buttons);            
            
            $table->data[] = $row;
        }

        $opinions->close();
        $this->list = $table;

        $this->renderable = new orange_opinion_list();
    }

    /**
     * Render.
     */
    public function render() {
        global $PAGE;

        $renderer = $PAGE->get_renderer('local_orange_opinion');
        return $renderer->render_orange_wrapper($this->renderable, $this->action, $this->list);

    }

}
