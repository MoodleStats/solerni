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
 * Orange Last Message block (from plugin local mail)
 *
 * @package    block_orange_last_message
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot.'/blocks/orange_last_message/locallib.php');

/**
 * Displays last message (local mail)
 */
class block_orange_last_message extends block_base {

    public function init() {
        Global $PAGE;
        $this->title = get_string('title', 'block_orange_last_message');
        $this->renderer = $PAGE->get_renderer('block_orange_last_message');
    }

    public function instance_allow_multiple() {
        return true;
    }

    public function has_config() {
        return false;
    }

    public function instance_allow_config() {
        return false;
    }

    public function applicable_formats() {
        return array(
            'admin' => false,
            'site-index' => true,
            'course-view' => true,
            'mod' => false,
            'my' => true
            );
    }

    public function html_attributes() {
        $attributes = parent::html_attributes(); // Get default values.
        $attributes['class'] .= ' block_'. $this->name(); // Append our class to class attribute.
        return $attributes;
    }

    public function specialization() {
        if (empty($this->config->title)) {
            $this->title = get_string('title', 'block_orange_last_message');
        } else {
            $this->title = $this->config->title;
        }
    }

    public function get_content() {
        Global $USER;

        if ($this->content !== null) {
            return $this->content;
        }

        // Create empty content.
        $this->content = new stdClass();
        $this->content->text = '';

        // Get last message.
        $message = get_user_last_message($USER);
        $nummsgs = count($message);
        if ($nummsgs) {
            $this->content->text .= $this->renderer->message_display($message[0]);
        } else {
            $this->content->text .= $this->renderer->no_message_display();
        }
        return $this->content;
    }
}
