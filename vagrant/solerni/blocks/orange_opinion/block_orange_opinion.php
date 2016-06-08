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
 * Orange Opinion block definition
 *
 * @package    block_orange_opinion
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(dirname(__FILE__) . '/../../config.php');

/**
 * Orange Opinion block class
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_orange_opinion extends block_base {

    /**
     * Sets the block title
     *
     * @return void
     */
    public function init() {
        Global $PAGE;
        $this->title = get_string('pluginname', 'block_orange_opinion');
        $this->renderer = $PAGE->get_renderer('block_orange_opinion');
    }

    /**
     *  we have global config/settings data
     *
     * @return bool
     */
    public function has_config() {
        return false;
    }

    public function specialization() {
        $this->title = "";
    }

    /**
     * Controls whether multiple instances of the block are allowed on a page
     *
     * @return bool
     */

    public function instance_allow_multiple() {
        return false;
    }

    /**
     * Defines where the block can be added
     *
     * @return array
     */
    public function applicable_formats() {
        return array(
            'site-index' => true
        );
    }

    /**
     * Creates the blocks main content
     *
     * @return string
     */
    public function get_content() {
        global $DB;
        // If content has already been generated, don't waste time generating it again.
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';

        if (empty($this->instance)) {
            return $this->content;
        }

        $opinions = $DB->get_records('orange_opinion', array('suspended' => 0), 'timemodified', '*', 0 , 6);

        $this->content->text .= $this->renderer->display_carousel($opinions);

        return $this->content;
    }

    /**
     * Extension bg-color
     *
     * @return array
     */

    public function html_attributes() {
        $attributes = parent::html_attributes();
        $attributes['class'] .= ' bg-blue expanded';

        return $attributes;
    }
}