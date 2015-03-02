<?php
/**
 * Flexpage Navigation Block
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://opensource.org/licenses/gpl-3.0.html.
 *
 * @copyright Copyright (c) 2009 Moodlerooms Inc. (http://www.moodlerooms.com)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @package block_flexpagenav
 * @author Mark Nielsen
 */

/**
 * @see block_flexpagenav_lib_link_abstract
 */
require_once($CFG->dirroot.'/blocks/flexpagenav/lib/link/abstract.php');

/**
 * Trouble Ticket Link
 *
 * @author Mark Nielsen
 * @package block_flexpagenav
 */
class block_flexpagenav_lib_link_ticket extends block_flexpagenav_lib_link_abstract {

    public function has_dependencies() {
        global $DB;

        static $result = null;

        if (is_null($result)) {
            // Trouble ticket block must be installed and visible
            $result = $DB->record_exists('block', array('name' => 'trouble_ticket', 'visible' => 1));
        }
        return $result;
    }

    /**
     * @return moodle_url
     */
    protected function get_url() {
        global $COURSE;

        return new moodle_url('/blocks/trouble_ticket/ticket.php', array(
            'id' => $COURSE->id,
            'subject' => $this->get_link()->get_config('subject')
        ));
    }

    public function get_info() {
        if (!$this->has_dependencies()) {
            return $this->get_link()->get_config('label');
        }
        return html_writer::link($this->get_url(), $this->get_link()->get_config('label'));
    }

    public function handle_form() {
        $this->get_link()->set_config('label', required_param('label', PARAM_TEXT))
                         ->set_config('subject', trim(optional_param('subject', '', PARAM_TEXT)));
    }

    public function edit_form(moodle_url $submiturl) {
        $box = new course_format_flexpage_lib_box(array('class' => 'format_flexpage_form'));

        $box->add_new_row()->add_new_cell(html_writer::label(get_string('label', 'block_flexpagenav'), 'id_label'))
                           ->add_new_cell(html_writer::empty_tag('input', array('id' => 'id_label', 'name' => 'label', 'type' => 'text', 'size' => 50, 'value' => $this->get_link()->get_config('label'))));

        $box->add_new_row()->add_new_cell(html_writer::label(get_string('subject', 'block_flexpagenav'), 'id_subject'))
                           ->add_new_cell(html_writer::empty_tag('input', array('id' => 'id_subject', 'name' => 'subject', 'type' => 'text', 'size' => 50, 'value' => $this->get_link()->get_config('subject'))));

        return $this->get_renderer()->form_wrapper($submiturl, $box);
    }

    public function add_nodes(navigation_node $root) {
        $root->add($this->get_link()->get_config('label'), $this->get_url(), navigation_node::TYPE_CUSTOM, null, 'ticket_'.$this->get_link()->get_id());
    }
}