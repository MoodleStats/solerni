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
 * Menu Render Abstract
 *
 * @author Mark Nielsen
 * @package block_flexpagenav
 */
abstract class block_flexpagenav_lib_render_abstract {
    /**
     * @var block_flexpagenav_model_menu
     */
    protected $menu;

    /**
     * @var block_flexpagenav_renderer
     */
    protected $renderer;

    /**
     * The root navigation node
     *
     * @var navigation_node
     */
    protected $root;

    /**
     * @param block_flexpagenav_model_menu $menu
     */
    public function __construct(block_flexpagenav_model_menu $menu) {
        global $PAGE;

        $this->menu     = $menu;
        $this->renderer = $PAGE->get_renderer('block_flexpagenav');

        $this->init_root();
    }

    /**
     * Initialize the root navigation node
     *
     * @return void
     */
    public function init_root() {
        $this->root = new navigation_node(array(
            'key' => 'menu_'.$this->menu->get_id(),
            'text' => format_string($this->menu->get_name()),
        ));
        foreach ($this->menu->get_links() as $link) {
            if ($link->load_type()->has_dependencies()) {
                $link->load_type()->add_nodes($this->root);
            }
        }
    }

    /**
     * Convert the navigation collection into HTML
     *
     * @return string
     */
    abstract public function output();
}