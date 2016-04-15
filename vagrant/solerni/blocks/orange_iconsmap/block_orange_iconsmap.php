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
 * Orange Icons Map
 *
 * @package    block_orange_iconsmap
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot.'/blocks/orange_iconsmap/lib.php');
require_once($CFG->dirroot . '/blocks/moodleblock.class.php');

class block_orange_iconsmap extends block_base {

    /**
     * Sets the block title
     *
     * @return void
     */
    public function init() {
        Global $PAGE;

        $this->title = get_string('default_title', 'block_orange_iconsmap');
        $this->renderer = $PAGE->get_renderer('block_orange_iconsmap');
    }

    /**
     *  we have global config/settings data
     *
     * @return bool
     */
    public function has_config() {

        return false;
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
            'my'             => false
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


        if (block_orange_iconsmap_is_on_course_page()) {
            $this->content->text = $this->renderer->display_on_course_page($COURSE, $context);
        }

        return $this->content;
    }
}
