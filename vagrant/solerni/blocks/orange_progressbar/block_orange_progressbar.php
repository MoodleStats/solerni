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
 * Orange Progress Bar block definition
 *
 * @package    block_orange_progressbar
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot.'/blocks/orange_progressbar/lib.php');

/**
 * Progress Bar block class
 *
 * @copyright 2010 Michael de Raadt
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_orange_progressbar extends block_base {

    /**
     * Sets the block title
     *
     * @return void
     */
    public function init() {
        Global $PAGE;
        $this->title = get_string('config_default_title', 'block_orange_progressbar');
        $this->renderer = $PAGE->get_renderer('block_orange_progressbar');
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
     * Controls the block title based on instance configuration
     *
     * @return bool
     */
    public function specialization() {
        $this->title = get_string('block_title', 'block_orange_progressbar');
    }

    /**
     * Controls whether multiple instances of the block are allowed on a page
     *
     * @return bool
     */
    public function instance_allow_multiple() {
        return !block_orange_progressbar_on_my_page();
    }

    /**
     * Controls whether the block is configurable
     *
     * @return bool
     */
    public function instance_allow_config() {
        return !block_orange_progressbar_on_my_page();
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
        global $USER, $COURSE, $OUTPUT;

        // If content has already been generated, don't waste time generating it again.
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';
        $blockinstancesonpage = array();

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

        $completion = new completion_info($COURSE);
        if ($completion->is_enabled()) {

            $activitymonitored = $completion->get_progress_all('u.id = '. $USER->id);

            // At first access to the course, the list is not set.
            if (!isset($activitymonitored[$USER->id])) {
                $activitymonitored[$USER->id] = null;
            }
            list($completed, $total, $all) = block_orange_progressbar_filterfollowedactivity($COURSE,
                    $activitymonitored[$USER->id]);

            if ($total) {
                // Display progress bar.
                $this->content->text = $this->renderer->display_progress($total, $completed);

                // Allow access the overview page.
                if (has_capability('block/orange_progressbar:overview', $this->context)) {
                    $parameters = array('progressbarid' => $this->instance->id, 'courseid' => $COURSE->id);
                    $url = new moodle_url('/blocks/orange_progressbar/overview.php', $parameters);
                    $label = get_string('overviewbutton', 'block_orange_progressbar');
                    $options = array('class' => 'overviewButton');
                    $this->content->text .= $OUTPUT->single_button($url, $label, 'post', $options);
                }

            } else {
                $this->content->text = $this->renderer->display_noactivity_monitored();
            }
        } else {
            $this->content->text = $this->renderer->display_completion_notenabled();
        }
        $blockinstancesonpage = array($this->instance->id);

        return $this->content;
    }
}
