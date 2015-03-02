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
 * @see course_format_flexpage_lib_box
 */
require_once($CFG->dirroot.'/course/format/flexpage/lib/box.php');

/**
 * Abstract Link
 *
 * @author Mark Nielsen
 * @package block_flexpagenav
 */
abstract class block_flexpagenav_lib_link_abstract {
    /**
     * @var block_flexpagenav_model_link
     */
    protected $link;

    /**
     * @return block_flexpagenav_model_link
     */
    public function get_link() {
        return $this->link;
    }

    /**
     * @param block_flexpagenav_model_link $link
     * @return block_flexpagenav_lib_link_abstract
     */
    public function set_link(block_flexpagenav_model_link $link) {
        $this->link = $link;
        return $this;
    }

    /**
     * Get the link type
     *
     * @return string
     */
    public function get_type() {
        return end(explode('_', get_class($this)));
    }

    /**
     * Get human readable link type name
     *
     * @return string
     */
    public function get_name() {
        return get_string($this->get_type().'link', 'block_flexpagenav');
    }

    /**
     * @return block_flexpagenav_renderer
     */
    public function get_renderer() {
        global $PAGE;

        static $renderer = null;

        if (is_null($renderer)) {
            $renderer = $PAGE->get_renderer('block_flexpagenav');
        }
        return $renderer;
    }

    /**
     * Determine if the link has all of it's dependencies
     *
     * If not, then the link cannot be added, edited or
     * displayed in menus.
     *
     * @return bool
     */
    public function has_dependencies() {
        return true;
    }

    /**
     * Get information about the link
     *
     * @abstract
     * @return string
     */
    abstract public function get_info();

    /**
     * Grab data from {@link edit_form} in the request, clean and set
     * to link config.
     *
     * @abstract
     * @return void
     */
    abstract public function handle_form();

    /**
     * Return the form HTML for editing this link
     *
     * @abstract
     * @param moodle_url $submiturl
     * @return string
     */
    abstract public function edit_form(moodle_url $submiturl);

    /**
     * Add navigational nodes to the root node
     *
     * @abstract
     * @param navigation_node $root
     * @return void
     */
    abstract public function add_nodes(navigation_node $root);
}