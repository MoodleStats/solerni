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
 * Orange Listforumng block definition
 *
 * @package    block_orange_listforumng
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/mod/forumng/mod_forumng.php');
require_once($CFG->dirroot.'/blocks/orange_listforumng/lib.php');

/**
 * Listforumng block class
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_orange_listforumng extends block_base {

    /**
     * Sets the block title
     *
     * @return void
     */
    public function init() {
        Global $PAGE;
        $this->title = get_string('pluginname', 'block_orange_listforumng');
        $this->renderer = $PAGE->get_renderer('block_orange_listforumng');
    }

    /**
     *  we have global config/settings data
     *
     * @return bool
     */
    public function has_config() {
        return true;
    }

    public function specialization() {
        $this->title = isset($this->config->title) ?
                format_string($this->config->title) : format_string(get_string('newlistforumnglock', 'block_orange_listforumng'));
    }

    /**
     * Controls whether multiple instances of the block are allowed on a page
     *
     * @return bool
     */

    public function instance_allow_multiple() {
        return !block_orange_listforumng_on_my_page();
    }

    /**
     * Defines where the block can be added
     *
     * @return array
     */
    public function applicable_formats() {
        return array(
            'course-view'    => true,
            'site'           => true,
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
        global $USER;

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

        $listforumngid = array();
        if (isset($this->config)) {
            foreach ($this->config as $key => $value) {

                if (strpos($key, "forumng_") === 0 && $value === "1") {
                    $listforumngid[] = intval(substr($key, stripos($key, "_") + 1));
                }
            }
        }

        if (count($listforumngid) == 0) {
            $this->content->text = $this->renderer->display_noforumng_affected();
        } else {
            $listforumngdisplay = block_orange_listforumng_get_bylistforumngid($listforumngid);
            $this->content->text = $this->renderer->display_listforumng($listforumngdisplay);
        }

        return $this->content;
    }
}
