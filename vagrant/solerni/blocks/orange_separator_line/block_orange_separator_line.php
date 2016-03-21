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
     *  Get the content of social sharing block.
     *
     * @global none
     * @param none
     * @return string $this->content
     */
    public function get_content() {

        $this->content = new stdClass();
        $this->content->text   = '';
        $text = $this->renderer->get_text();
        $this->content->text = $text;

        return $this->content;

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
}

