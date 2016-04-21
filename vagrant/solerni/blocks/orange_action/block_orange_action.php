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
 * Orange Action block
 *
 * @package    block_orange_action
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot.'/blocks/orange_action/lib.php');
require_once($CFG->dirroot.'/calendar/lib.php');
// Adding requirement to avoid  Class 'block_base' not found.
require_once($CFG->dirroot . '/blocks/moodleblock.class.php');

/**
 * @todo: separate the renderer calls from the lib.php inside the renderer
 * to avoid mixing logic and presentation.
 */

class block_orange_action extends block_base {

    /**
     * Sets the block title
     *
     * @return void
     */
    public function init() {
        global $PAGE;

        $this->title = get_string('config_default_title', 'block_orange_action');
        $this->renderer = $PAGE->get_renderer('block_orange_action');
    }

    /**
     *  we have global config/settings data
     *
     * @return bool
     */
    public function has_config() {
        return true;
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
     * Creates the blocks main content. Block orange_action wan be visible in three contexts :
     * course dashboard, user dashboard and forum list.
     *
     * It could display either a course or a event.
     *
     * @return string
     */
    public function get_content() {
        global $COURSE;

        // If content has already been generated, don't waste time generating it again.
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';

        // TODO-a revoir Guests do not have any progress. Don't show them the block.
        if (!isloggedin() or isguestuser()) {
            return $this->content;
        }

        if (block_orange_action_on_course_dashboard_page()) {
            $this->content->text = $this->renderer->display_on_course_dashboard();
        }

        if (block_orange_action_on_forum_index_page()) {
            $this->content->text = $this->renderer->display_on_forum_index();
        }

        if (block_orange_action_on_course_page()) {
             $this->content->text = block_orange_action_get_course($COURSE->id);
        }

        if (block_orange_action_on_my_page()) {
            // Read course id from block config. In priority we take the course.
            if (!empty($this->config->coursetopush)) {
                $this->content->text = block_orange_action_get_course($this->config->coursetopush);
            } elseif (!empty($this->config->eventtopush)) {
                $this->content->text = block_orange_action_get_event($this->config->eventtopush);
            }
        }

        return $this->content;
    }

    /**
     * Sets block header to be hidden
     *
     * @return bool if true then header will be visible.
     */
    public function hide_header() {
        $config = get_config('block_orange_action');
        return !empty($config->hideblockheader);
    }
}
