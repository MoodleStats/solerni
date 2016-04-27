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
 * orange_course_dashboard block renderer
 *
 * @package    block_orange_course_dashboard
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot.'/theme/halloween/renderers/core_course_renderer.php');

class block_orange_course_dashboard_renderer extends plugin_renderer_base {

     /**
     * Construct contents of orange_course_dashboard block
     *
     * @return string html to be displayed in orange_course_dashboard block
     */
    public function block_orange_course_dashboard_render_nocourses() {

        $html = html_writer::start_tag('div', array('class' => 'row courses-list no-courses'));
            $html .= html_writer::start_tag('div', array('class' => 'col-xs-12'));
                $html .= html_writer::tag('p', get_string('nomoocfollow', 'block_orange_course_dashboard'),
                        array('class' => 'h3'));
                $html .= html_writer::tag('p', get_string('nomoocfollowtext', 'block_orange_course_dashboard'),
                        array('class' => 'bold'));
            $html .= html_writer::end_tag('div');
        $html .= html_writer::end_tag('div');

        return $html;
    }

    /**
     * Construct contents of orange_course_dashboard block
     *
     * @param array $courses list of courses in sorted order
     * @param array $overviews list of course overviews
     * @return string html to be displayed in orange_course_dashboard block
     */
    public function block_orange_course_dashboard_render_courses_list($courses) {
        global $PAGE;

        $renderer = $PAGE->get_renderer('core', 'course');

        $html = html_writer::start_tag('div', array('class' => 'row courses-list'));
            foreach ($courses as $course) {
                $html .= $renderer->render_halloween_mooc_component(null, $course);
            }
        $html .= html_writer::end_tag('div');

        return $html;
    }

    /**
     *
     * Display the orange block heading
     *
     * @param: string $title
     * @optionnal: string $btntitle
     * @optionnal: string $btntitle
     * @optionnal: boolean $condition
     *
     * @return string html
     *
     * @todo: make it site wide by using the theme renderer.
     */
    public function block_orange_course_dashboard_heading($title, $btntitle = '', $url = '', $condition = false) {

        if ($condition && $url && $btntitle) {
            $firstcolumn = 'col-xs-8';
            $secondcolumn = 'col-xs-8';
        } else {
            $firstcolumn = 'col-xs-12';
            $secondcolumn = '';
        }

        $html = html_writer::start_tag('div', array('class' => 'row u-row-table orange-block-heading'));
            $html .= html_writer::start_tag('div', array('class' => $firstcolumn));
                $html .= html_writer::tag('h2', $title);
            $html .= html_writer::end_tag('div');
            if ($secondcolumn) {
                $html .= html_writer::start_tag('div', array('class' => $secondcolumn . ' col-xs-4 text-right u-vertical-align'));
                    $html .= html_writer::tag('a', $btntitle, array('class' => 'btn btn-default',
                        'href' => $url));
                $html .= html_writer::end_tag('div');
            }
        $html .= html_writer::end_tag('div');

        return $html;
    }

    /**
     * Returns the HTML for Orange block footer
     *
     * @param string url $catalogurl
     * @return string (html)
     */
    public function block_orange_course_dashboard_render_footer($catalogurl) {
        $html = html_writer::start_tag('div', array('class' => 'row orange-block-footer'));
            $html .= html_writer::start_tag('div', array('class' => 'col-xs-12'));
                $html .= html_writer::link(new moodle_url($catalogurl),
                            get_string('displaycatalog', 'block_orange_course_dashboard'),
                            array('class' => 'btn btn-default btn-block'));
            $html .= html_writer::end_tag('div');
        $html .= html_writer::end_tag('div');

        return $html;
    }
}
