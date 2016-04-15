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
 * Orange Separator Line class
 *
 * @package    blocks
 * @subpackage orange_separator_line
 * @copyright  2016 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot.'/blocks/orange_separator_line/lib.php');
// Adding requirement to avoid  Class 'block_base' not found.
require_once($CFG->dirroot . '/blocks/moodleblock.class.php');


class block_orange_separator_line extends block_base{

    /**
     *  Set orange separator line configuration setting.
     *
     * @global none
     * @param $mform
     * @return boolean
     */
    public function has_config() {
        return false;
    }

    /**
     *  Set the initial values for orange_separator_line.
     *
     * @global type $PAGE
     * @param none
     * @return none
     */
    public function init() {
        Global $PAGE;

        $this->title = get_string('title', 'block_orange_separator_line');
        $this->renderer = $PAGE->get_renderer('block_orange_separator_line');
    }

    /**
     *  Allowing multiple instance of separator line.
     *
     * @global none
     * @param none
     * @return boolean
     */
    public function instance_allow_multiple() {

        return true;
    }

    /**
     * Controls whether the block is configurable
     *
     * @return bool
     */
    public function instance_allow_config() {

        return false;
    }

    /**
     * Defines where the block can be added
     *
     * @return array
     */
    public function applicable_formats() {

        return array(
            'course-view'    => true,
            'site'           => false,
            'mod'            => false,
            'my'             => true
        );
    }


    /**
     * Creates the blocks main content
     *
     * @return string
     */
    public function get_content() {
        global $COURSE, $context;

        // If content has already been generated, don't waste time generating it again.
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';

        if (block_orange_separator_line_on_course_page()) {
            $this->content->text = $this->renderer->display_on_course_page($COURSE, $context);
        }

        return $this->content;
    }
}

