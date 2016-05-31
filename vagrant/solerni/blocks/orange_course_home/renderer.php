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
 * orange_course_home block renderer
 *
 * @package    block_orange_course_home
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot.'/theme/halloween/renderers/core_course_renderer.php');

class block_orange_course_home_renderer extends plugin_renderer_base {

    /**
     * Construct courses list of orange_course_home block
     *
     * @param array $courses list of courses to display
     * @param string $sitename thematic name
     * @return string html to be displayed in orange_course_home block
     */
    public function display_courses($courses, $sitename) {
        global $PAGE;

        $html = html_writer::tag('h2', get_string('titlecoursehome', 'block_orange_course_home'));
        $html .= html_writer::tag('div', get_string('subtitlecoursehome', 'block_orange_course_home', $sitename),
                array('class' => 'h3 text-oneline'));

        $renderer = $PAGE->get_renderer('core', 'course');

        $html .= html_writer::start_tag('div', array('class' => 'row courses-list'));
            foreach ($courses as $course) {
                $html .= $renderer->render_halloween_mooc_component(null, $course);
            }
        $html .= html_writer::end_tag('div');

        return $html;
    }

    /**
     * Construct catalog button of orange_course_home block
     *
     * @param string $sitename thematic name
     * @param url $catalogurl URL of catalog
     * @return string html to be displayed in orange_course_home block
     */
    public function display_catalogbutton($sitename, $catalogurl) {

        $html = html_writer::start_tag('div', array('class' => 'row orange-block-footer'));
            $html .= html_writer::start_tag('div', array('class' => 'col-xs-12'));
                $html .= html_writer::link(new moodle_url($catalogurl),
                        get_string('displaycatalog', 'block_orange_course_home', $sitename),
                        array('class' => 'btn btn-default btn-block'));
            $html .= html_writer::end_tag('div');
        $html .= html_writer::end_tag('div');

        return $html;
    }

    /**
     * Construct contents of orange_course_home block when no course available
     *
     * @return string html to be displayed in orange_course_home block
     */
    public function display_nocourse() {

        $html = html_writer::tag('h2', get_string('titlecoursehome', 'block_orange_course_home'));
        $html .= html_writer::tag('div', get_string('nomooctodisplay', 'block_orange_course_home'),
                array('class' => 'h3 text-oneline orange-coursehome-subtitle'));

        return $html;
    }
}