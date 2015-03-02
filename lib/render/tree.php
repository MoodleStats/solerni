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
 * Menu Render Tree
 *
 * This code is inspired from block_settings_renderer
 *
 * @author Mark Nielsen
 * @package block_flexpagenav
 */
class block_flexpagenav_lib_render_tree extends block_flexpagenav_lib_render_abstract {

    public function output() {
        $content = $this->to_html($this->root->children, array('class' => 'block_tree list'));
        if (!empty($content)) {
            $content = $this->renderer->box($content, 'block_tree_box', html_writer::random_id());
        }
        return $content;
    }

    /**
     * @param navigation_node_collection $items
     * @param array $attributes
     * @return string
     */
    protected function to_html(navigation_node_collection $items, $attributes = array()) {
        $lis = array();
        foreach ($items as $item) {
            /** @var $item navigation_node */
            if (!$item->display) {
                continue;
            }

            $isbranch = ($item->children->count()>0  || $item->nodetype==navigation_node::NODETYPE_BRANCH);
            $hasicon = (!$isbranch && $item->icon instanceof renderable);

            if ($isbranch) {
                $item->hideicon = true;
            }
            $content = $this->renderer->render($item);

            // this applies to the li item which contains all child lists too
            $liclasses = array($item->get_css_type());
            if (!$item->forceopen || (!$item->forceopen && $item->collapse) || ($item->children->count()==0  && $item->nodetype==navigation_node::NODETYPE_BRANCH)) {
                $liclasses[] = 'collapsed';
            }
            if ($isbranch) {
                $liclasses[] = 'contains_branch';
            } else if ($hasicon) {
                $liclasses[] = 'item_with_icon';
            }
            if ($item->isactive === true) {
                $liclasses[] = 'current_branch';
            }
            if ($item->hidden) {
                $liclasses[] = 'dimmed_text';
            }
            $liattr = array('class'=>join(' ',$liclasses));
            // class attribute on the div item which only contains the item content
            $divclasses = array('tree_item');
            if ($isbranch) {
                $divclasses[] = 'branch';
            } else {
                $divclasses[] = 'leaf';
            }
            if (!empty($item->classes) && count($item->classes)>0) {
                $divclasses[] = join(' ', $item->classes);
            }
            $divattr = array('class'=>join(' ', $divclasses));
            if (!empty($item->id)) {
                $divattr['id'] = $item->id;
            }
            $content = html_writer::tag('p', $content, $divattr) . $this->to_html($item->children);
            if (!empty($item->preceedwithhr) && $item->preceedwithhr===true) {
                $content = html_writer::empty_tag('hr') . $content;
            }
            $content = html_writer::tag('li', $content, $liattr);
            $lis[] = $content;
        }

        if (!empty($lis)) {
            return html_writer::tag('ul', implode("\n", $lis), $attributes);
        } else {
            return '';
        }
    }
}