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
 * @see block_flexpagenav_lib_render_abstract
 */
require_once($CFG->dirroot.'/blocks/flexpagenav/lib/render/abstract.php');

/**
 * Menu Render Select
 *
 * @author Mark Nielsen
 * @package block_flexpagenav
 */
class block_flexpagenav_lib_render_select extends block_flexpagenav_lib_render_abstract {

    public function output() {
        $content = $this->to_html($this->root->children);
        if (!empty($content)) {
            $content = $this->renderer->box($content, 'block_flexpagenav_dropdown_box', html_writer::random_id());
        }
        return $content;
    }

    /**
     * @param navigation_node_collection $collection
     * @return string
     */
    protected function to_html(navigation_node_collection $collection) {
        $children = array();
        $options  = array();
        $selected = null;
        foreach ($collection as $node) {
            /** @var $node navigation_node */
            if (!$node->display) {
                continue;
            }
            $options[$node->action->out(false)] = $node->text;

            if ($node->contains_active_node() and is_null($selected)) {
                $selected   = $node->action->out(false);
                $children[] = $this->to_html($node->children);
            }
        }
        if (!empty($options)) {
            // Have to write our own url_select because url_select only allows relative URLs
            $selectid = html_writer::random_id('url_select');
            $output   = html_writer::empty_tag('input', array('type'=>'hidden', 'name'=>'sesskey', 'value'=>sesskey()));
            $output  .= html_writer::select($options, html_writer::random_id('jump'), $selected, array('' => 'choosedots'), array('id' => $selectid));
            $go       = html_writer::empty_tag('input', array('type'=>'submit', 'value'=>get_string('go')));
            $output  .= html_writer::tag('noscript', html_writer::tag('div', $go), array('style'=>'inline'));
            $output   = html_writer::tag('div', $output);
            $output   = html_writer::tag('form', $output, array(
                'method' => 'post',
                'action' => new moodle_url('/course/jumpto.php'),
                'id'     => html_writer::random_id('url_select_f')
            ));
            $output  = html_writer::tag('div', $output, array('class' => 'url_select'));
            $output .= html_writer::script("
                YUI(M.yui.loader).use('node', function(Y) {
                    Y.one('#$selectid').on('change', function(e) {
                        if (e.target.get('value') != '') {
                            window.location = e.target.get('value');
                        }
                    });
                });
            ");

            if (!empty($children)) {
                $output .= "<br /><br />\n".implode("<br /><br />\n", $children);
            }
            return $output;
        }
        return '';
    }
}