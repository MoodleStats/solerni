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
 * Orange Course Home block
 *
 * @package    block_orange_course_home
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use local_orange_library\utilities\utilities_network;
require_once($CFG->dirroot.'/blocks/orange_course_home/locallib.php');

class block_orange_course_home extends block_base {

    /**
     * Block initialization
     */
    public function init() {
            $this->title   = get_string('pluginname', 'block_orange_course_home');
    }

    /**
     * Return contents of orange_course_home block
     *
     * @return stdClass contents of block
     */
    public function get_content() {
        if (utilities_network::is_platform_uses_mnet() && utilities_network::is_home()) {
            return "";
        }
        if ($this->content !== null) {
            return $this->content;
        }

        $config = get_config('block_orange_course_home');

        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';

        $site  = get_site();

        $renderer = $this->page->get_renderer('block_orange_course_home');

        list($courses, $catalogbutton) = block_orange_course_home_get_courses($config->defaultmaxcourses);

        if (!count($courses)) {
            $this->content->text .= $renderer->display_nocourse();
            return $this->content;
        }

        $this->content->text .= $renderer->display_courses($courses, format_string($site->fullname));
        if ($catalogbutton) {
            $this->content->text .= $renderer->display_catalogbutton(format_string($site->fullname), $config->catalogurl);
        }

        return $this->content;
    }

    /**
     * Allow the block to have a configuration page
     *
     * @return boolean
     */
    public function has_config() {
        return true;
    }

    /**
     * Sets block header to be hidden or visible
     *
     * @return bool if true then header will be visible.
     */
    public function hide_header() {
        return true;
    }
}
