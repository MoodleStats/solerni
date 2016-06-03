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
 * Orange Course Dashboard block
 *
 * @package    block_orange_course_dashboard
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use local_orange_library\utilities\utilities_course;

class block_orange_course_dashboard extends block_base {
    /**
     * If this is passed as mynumber then showallcourses, irrespective of limit by user.
     */
    const SHOW_ALL_COURSES = -2;

    /**
     * Block initialization
     */
    public function init() {
        $this->title   = get_string('pluginname', 'block_orange_course_dashboard');
    }

    /**
     * Return contents of orange_course_dashboard block
     *
     * @return stdClass contents of block
     */
    public function get_content() {

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';
        $renderer = $this->page->get_renderer('block_orange_course_dashboard');

        $sortedcourses =
            utilities_course::get_ordered_user_courses($this->config->defaultmaxcourses);

        // We have courses and no manual override.
        if (count($sortedcourses) && !$this->config->forcednoavailabalemooc) {
            $title = get_string('titlefollowedcourses', 'block_orange_course_dashboard');
            $condition = (count($sortedcourses) > $this->config->defaultmaxcourses);
            $btntitle = get_string('titlefollowedcourses', 'block_orange_course_dashboard');
            $btnurl = (empty($this->config->mymoocsurl)) ?
                    new moodle_url('/moocs/mymoocs.php') :
                    new moodle_url($this->config->mymoocsurl);
            $this->content->text .= $renderer->block_orange_course_dashboard_heading($title, $btntitle, $btnurl, $condition);
            $this->content->text .= $renderer->block_orange_course_dashboard_render_courses_list($sortedcourses);
        } else {
            $this->content->text .= $renderer->block_orange_course_dashboard_heading(get_string('nomooctodisplay', 'block_orange_course_dashboard'));
            $this->content->text .= $renderer->block_orange_course_dashboard_render_nocourses();
        }

        if ($this->config->catalogurl) {
            $this->content->text .= $renderer->block_orange_course_dashboard_render_footer($this->config->catalogurl);
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
     * Locations where block can be displayed
     *
     * @return array
     */
    public function applicable_formats() {
        return array('my-index' => true);
    }

    /**
     * Sets block header to be hidden or visible
     *
     * @return bool if true then header will be visible.
     */
    public function hide_header() {
        // Funny. The config must be set here or is uncomplete.
        $this->config = get_config('block_orange_course_dashboard');
        return true;
    }

    public function html_attributes() {
        $attributes = parent::html_attributes();
        $attributes['class'] .= ' bg-graylight expanded';

        return $attributes;
    }
}
