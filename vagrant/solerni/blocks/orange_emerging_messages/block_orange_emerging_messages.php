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
 * Orange Emerging Messages block definition
 *
 * @package    block_orange_emerging_messages
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot.'/local/orange_library/classes/forumng/forumng_object.php');
require_once($CFG->dirroot.'/blocks/orange_emerging_messages/lib.php');


/**
 * Emerging Messages block class
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_orange_emerging_messages extends block_base {

    /**
     * Sets the block title
     *
     * @return void
     */
    public function init() {
        Global $PAGE;
        $this->title = get_string('pluginname', 'block_orange_emerging_messages');
        $this->renderer = $PAGE->get_renderer('block_orange_emerging_messages');
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

        $this->title = isset($this->config->title) ?
            format_string($this->config->title) : '';
    }

    /**
     * Controls whether multiple instances of the block are allowed on a page
     *
     * @return bool
     */

    public function instance_allow_multiple() {
        return !block_orange_emerging_messages_on_my_page();
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
        global $USER, $COURSE;

        // If content has already been generated, don't waste time generating it again.
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';

        // Guests do not have any progress. Don't show them the block.
        if (!isloggedin() or isguestuser()) {
            return $this->content;
        }

        // Check if user is in group for block.
        if (
            !empty($this->config->group) &&
            !has_capability('moodle/site:accessallgroups', $this->context) &&
            !groups_is_member($this->config->group, $USER->id)
        ) {
            return $this->content;
        }

        if (!isset($this->config->nbdisplaypost)) {
            $nbdisplaypost = intval(get_string('nbdisplaypostdefault', 'block_orange_emerging_messages'));
        } else {
            $nbdisplaypost = $this->config->nbdisplaypost;
        }

        $listposts = block_orange_emerging_messages_get_user_posts($COURSE->id, $USER->id, $nbdisplaypost);
        $listdiscussions = block_orange_emerging_messages_get_last_discussions($COURSE->id, $nbdisplaypost);
        $listbestposts = block_orange_emerging_messages_get_best_messages($COURSE->id, $nbdisplaypost);

        $this->content->text = $this->renderer->display_emerging_messages(
                $COURSE, $listposts->posts, $listdiscussions->posts, $listbestposts->posts);

        return $this->content;
    }

    /**
     * Extension bg-color
     *
     * @return array
     */

    public function html_attributes() {
        $attributes = parent::html_attributes();
        $attributes['class'] .= ' bg-yellow expanded';

        return $attributes;
    }
}
