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
 * Menu Render Horizontal Navigation Bar
 *
 * This code is inspired from custom_menu code
 *
 * @author Mark Nielsen
 * @package block_flexpagenav
 */
class block_flexpagenav_lib_render_navhorizontal extends block_flexpagenav_lib_render_abstract {

    public function output() {
        global $PAGE;

        $content = $this->to_html($this->root->children);
        if (!empty($content)) {
            $id = html_writer::random_id();

            $PAGE->requires->js_init_call('M.core_custom_menu.init', array($id));

            $content = html_writer::start_tag('div', array('id' => 'custommenu')).
                       html_writer::start_tag('div', array('id' => $id, 'class' => 'yui3-menu yui3-menu-horizontal javascript-disabled')).
                       html_writer::tag('div', html_writer::tag('ul', $content), array('class' => 'yui3-menu-content')).
                       html_writer::end_tag('div').
                       html_writer::end_tag('div');
        }
        return $content;
    }

    /**
     * @param navigation_node_collection $nodes
     * @return string
     */
    protected function to_html(navigation_node_collection $nodes) {
        $content = '';
        foreach ($nodes as $node) {
            /** @var $node navigation_node */
            if (!$node->display) {
                continue;
            }
            if ($node->hidden) {
                $linkclass = ' dimmed_text';
            } else {
                $linkclass = '';
            }
            if ($node->children->count()) {
                // If the child has menus render it as a sub menu
                $content .= html_writer::start_tag('li');
                $content .= html_writer::link($node->action, $node->text, array('class' => "yui3-menu-label$linkclass", 'title' => $node->title));
                $content .= html_writer::start_tag('div', array('id' => html_writer::random_id(), 'class' => 'yui3-menu custom_menu_submenu'));
                $content .= html_writer::tag('div', html_writer::tag('ul', $this->to_html($node->children)), array('class'=>'yui3-menu-content'));
                $content .= html_writer::end_tag('div');
                $content .= html_writer::end_tag('li');
            } else {
                // The node doesn't have children so produce a final menuitem
                $content .= html_writer::start_tag('li', array('class' => 'yui3-menuitem'));
                $content .= html_writer::link($node->action, $node->text, array('class' => "yui3-menuitem-content$linkclass", 'title' => $node->title));
                $content .= html_writer::end_tag('li');
            }
        }
        return $content;
    }
}