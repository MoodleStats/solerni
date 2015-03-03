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
 * @see block_flexpagenav_lib_render_navhorizontal
 */
require_once($CFG->dirroot.'/blocks/flexpagenav/lib/render/navhorizontal.php');

/**
 * Menu Render Vertical Navigation Bar
 *
 * @author Mark Nielsen
 * @package block_flexpagenav
 * @todo This currently doesn't work because the left column has overflow hidden, so fly out menus are "covered"
 */
class block_flexpagenav_lib_render_navvertical extends block_flexpagenav_lib_render_navhorizontal {

    public function output() {
        global $PAGE;

        $content = $this->to_html($this->root->children);
        if (!empty($content)) {
            $id = html_writer::random_id();

            $PAGE->requires->js_init_call('M.core_custom_menu.init', array($id));

            $content = html_writer::start_tag('div', array('id' => $id, 'class' => 'yui3-menu javascript-disabled')).
                       html_writer::tag('div', html_writer::tag('ul', $content), array('class' => 'yui3-menu-content')).
                       html_writer::end_tag('div');
        }
        return $content;
    }
}