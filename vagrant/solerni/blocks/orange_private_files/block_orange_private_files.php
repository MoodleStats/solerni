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
 * Manage user private area files
 *
 * @package    block_orange_private_files
 * @copyright  2016 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_orange_private_files extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_orange_private_files');
    }

    public function specialization() {
        $this->title = "";
    }

    public function applicable_formats() {
        return array('site-index'     => true);
    }

    public function instance_allow_multiple() {
        return false;
    }

    public function get_content() {
        global $CFG, $USER, $PAGE, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }
        if (empty($this->instance)) {
            return null;
        }

        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';
        if (isloggedin() && !isguestuser()) {   // Show the block.
            $this->content = new stdClass();

            $renderer = $this->page->get_renderer('block_orange_private_files');
            $url = "";
            if (has_capability('moodle/user:manageownfiles', $this->context)) {
                $url = html_writer::link(
                    new moodle_url('/user/files.php', array('returnurl' => $PAGE->url->out())),
                    get_string('manage_myfiles', 'block_orange_private_files'),
                        array('class' => 'btn btn-default btn--orange-block-heading-action'));
            }
            $this->content->text = $renderer->block_orange_private_files_heading($url);
            $this->content->text .= $renderer->private_files_tree();

        }
        return $this->content;
    }

    public function html_attributes() {
        $attributes = parent::html_attributes();
        $attributes['class'] .= ' bg-blue expanded';

        return $attributes;
    }
}
