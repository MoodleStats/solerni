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
 * @package    blocks
 * @subpackage orange_social_sharing
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_orange_social_sharing extends block_base{
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
        Global $PAGE;
        $this->title = get_string('title', 'block_orange_social_sharing');
        $this->renderer = $PAGE->get_renderer('block_orange_social_sharing');
    }

    /**
     *  Get the content of social sharing block.
     *
     * @global none
     * @param none
     * @return string $this->content
     */
    public function get_content() {

        if (!is_null($this->content)) {
            return $this->content;
        }
        $this->content = new stdClass();
        $this->content->text   = '';

        if (empty($this->instance)) {
            return $this->content;
        }
        $course = $this->page->course;

        $this->content->text .= html_writer::start_tag('ul');
        $this->content->text .= html_writer::start_tag('li');
        $this->content->text .= html_writer::link('span', $course->fullname);
        $this->content->text .= html_writer::end_tag('li');
        $this->content->text .= html_writer::end_tag('ul');

        $text = $this->renderer->get_text();
        $this->content->text = $text;
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
        return false;
    }

    /**
     *  This "magic" method is guaranteed to be automatically called by Moodle
     *  as soon as our instance configuration is loaded and available
     * @global none
     * @param none
     * @return boolean
     */
    public function specialization() {
        if (isset($this->config)) {
            if (empty($this->config->title)) {
                $this->title = get_string('defaulttitle', 'block_orange_social_sharing');
            } else {
                $this->title = $this->config->title;
            }
            if (empty($this->config->facebook)) {
                $this->facebook = get_string('labelfacebook', 'block_orange_social_sharing');
            } else {
                $this->facebook = $this->config->facebook;
            }
            if (empty($this->config->twitter)) {
                $this->twitter = get_string('labeltwitter', 'block_orange_social_sharing');
            } else {
                $this->twitter = $this->config->twitter;
            }
            if (empty($this->config->linkedin)) {
                $this->linkedin = get_string('labellinkedin', 'block_orange_social_sharing');
            } else {
                $this->linkedin = $this->config->linkedin;
            }
            if (empty($this->config->google_plus)) {
                $this->google_plus = get_string('labelgoogleplus', 'block_orange_social_sharing');
            } else {
                $this->google_plus = $this->config->google_plus;
            }
        }
    }

    /**
     *  Is this block allowed into this page or not?
     *
     * @global none
     * @param none
     * @return boolean
     */
    public function applicable_formats() {
        return array(
            'course-view-flexpage' => true,
            'mod-descriptionpage' => true);
    }
}

