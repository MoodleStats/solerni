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
 * Orange Social Sharing Class
 *
 * @package    blocks
 * @subpackage orange_social_sharing
 * @copyright  2016 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_orange_social_sharing extends block_base{

    /**
     *  Set orange social sharing configuration setting.
     *
     * @global none
     * @param $mform
     * @return boolean
     */
    public function has_config() {
        return false;
    }

    /**
     *  Set the initial values for social sharing block.
     *
     * @global type $PAGE
     * @param none
     * @return none
     */
    public function init() {
        global $PAGE;

        $this->title = get_string('title', 'block_orange_social_sharing');
        $this->renderer = $PAGE->get_renderer('block_orange_social_sharing');
    }

    /**
     *  Get the content of social sharing block.
     *
     * @global $COURSE
     * @param none
     * @return string $this->content
     */
    public function get_content() {
        $this->content = new stdClass();
        $this->content->text = $this->renderer->get_text();

        return $this->content;
    }

    /**
     *  Allowing multiple instance social sharing block.
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

    /**
     * Sets block header to be hidden
     *
     * @return bool if true then header will be visible.
     */
    public function hide_header() {

        return true;
    }
}

