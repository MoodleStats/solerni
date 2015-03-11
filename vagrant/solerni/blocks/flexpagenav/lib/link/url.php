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
 * URL Link
 *
 * @author Mark Nielsen
 * @package block_flexpagenav
 */
class block_flexpagenav_lib_link_url extends block_flexpagenav_lib_link_abstract {

    public function get_info() {
        return html_writer::link($this->get_link()->get_config('url'), $this->get_link()->get_config('label'));
    }

    public function handle_form() {
        $this->get_link()->set_config('label', required_param('label', PARAM_TEXT))
                         ->set_config('url', required_param('url', PARAM_URL));
    }

    public function edit_form(moodle_url $submiturl) {
        $box = new course_format_flexpage_lib_box(array('class' => 'format_flexpage_form'));

        $box->add_new_row()->add_new_cell(html_writer::label(get_string('label', 'block_flexpagenav'), 'id_label'))
                           ->add_new_cell(html_writer::empty_tag('input', array('id' => 'id_label', 'name' => 'label', 'type' => 'text', 'size' => 50, 'value' => $this->get_link()->get_config('label'))));

        $box->add_new_row()->add_new_cell(html_writer::label(get_string('url', 'block_flexpagenav'), 'id_url'))
                           ->add_new_cell(html_writer::empty_tag('input', array('id' => 'id_url', 'name' => 'url', 'type' => 'text', 'size' => 50, 'value' => $this->get_link()->get_config('url'))));

        return $this->get_renderer()->form_wrapper($submiturl, $box);
    }

    public function add_nodes(navigation_node $root) {
        $root->add($this->get_link()->get_config('label'), $this->get_link()->get_config('url'), navigation_node::TYPE_CUSTOM, null, 'url_'.$this->get_link()->get_id());
    }
}