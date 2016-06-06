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
 * Orange Transverse Disucssion block definition
 *
 * @package    block_orange_transverse_discussion
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot.'/local/orange_library/classes/forumng/forumng_object.php');
require_once($CFG->dirroot.'/mod/forumng/mod_forumng.php');
require_once($CFG->dirroot.'/mod/forumng/mod_forumng_discussion.php');

use local_orange_library\utilities\utilities_course;
use local_orange_library\utilities\utilities_image;
use local_orange_library\extended_course\extended_course_object;

/**
 * Orange Transverse discussion block class
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_orange_transverse_discussion extends block_base {

    /**
     * Sets the block title
     *
     * @return void
     */
    public function init() {
        Global $PAGE;
        $this->title = get_string('pluginname', 'block_orange_transverse_discussion');
        $this->renderer = $PAGE->get_renderer('block_orange_transverse_discussion');
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
            'course-view'    => false,
            'site'           => true,
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

        $forumobject = new forumng_object();
        $res = $forumobject->get_recent_discussions(1, 0, 1);

        if (count($res->posts) == 0) {
            return $this->content;
        }
        $lastpost = array_shift($res->posts);

        $discussion = mod_forumng_discussion::get_from_id($lastpost->discussionid, mod_forumng::CLONE_DIRECT);

        $this->content->text .= $this->renderer->display_transverse_discussion($discussion);

        return $this->content;
    }

    /**
     * Extension bg-color
     *
     * @return array
     */

    public function html_attributes() {
        $attributes = parent::html_attributes();
        $attributes['class'] .= ' bg-green expanded';

        return $attributes;
    }
}