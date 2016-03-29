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
 * orange_paragraph_list block
 *
 * @package    orange_paragraph_list
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
use local_orange_library\utilities\utilities_course;
use local_orange_library\utilities\utilities_image;
use local_orange_library\find_out_more\find_out_more_object;

class block_orange_paragraph_list_renderer extends plugin_renderer_base {

    /**
     * Display Course for my page (user dashboard)
     *
     * @return message
     */
    public function display_course_on_my_page ($course, $extendedcourse, $imgurl) {
        echo 'display_course_on_my_page';
        // To be done after having the design for this case.
        $output = $this->display_on_course_page ($course, $extendedcourse, $imgurl);

        return $output;
    }

    /**
     * Display Event for my page (user dashboard)
     *
     * @return message
     */
    public function display_event_on_my_page ($event, $imgurl, $eventurl) {
        echo 'display_event_on_my_page';

        $output = html_writer::start_tag('div', array('class' => 'row '));

        if ($imgurl) {
            $imgurl = utilities_image::get_resized_url($imgurl, array('w' => 940, 'h' => 360, 'scale' => false));
            $output .= html_writer::empty_tag('img', array('src' => $imgurl, 'class' => 'col-xs-12 essentiels-image'));
        }
        $output .= html_writer::end_tag('div');

        $output .= html_writer::start_tag('div', array('class' => 'row', 'style' => 'background-color:#000;'));
            // Subscription button.
            $output .= html_writer::start_tag('div', array('class' => 'col-xs-4 col-md-12'));
                    $output .= '<a class="btn btn-default" href="' . $eventurl . '">' .
                            get_string("gotocalendar", 'block_orange_paragraph_list').'</a>';
            $output .= html_writer::end_tag('div');
            $output .= html_writer::start_tag('div', array('class' => 'col-xs-4 col-md-12'));
                $output .= html_writer::start_tag('h1', array('class' => '', 'style' => 'color:orange;'));
                    $output .= $event->name . " (" . calendar_day_representation($event->timestart) . " " .
                            calendar_time_representation($event->timestart) . ")";
                $output .= html_writer::end_tag('h1');

                $output .= html_writer::start_tag('span', array('style' => 'font-size:28px;color:#FFF;'));
                    $output .= html_to_text($event->description);
                $output .= html_writer::end_tag('span');

            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        return $output;
    }

    /**
     * Display for course dashboard
     *
     * @return message
     */
    public function display_on_course_dashboard () {
        echo 'display_on_course_dashboard';
        $output = html_writer::start_tag('div');
        $output .= html_writer::end_tag('div');

        return $output;
    }

    /**
     * Display for forum index page
     *
     * @return message
     */
    public function display_on_forum_index () {
        echo 'display_on_forum_index';
        $output = html_writer::start_tag('div');
        $output .= html_writer::end_tag('div');

        return $output;
    }

    /**
     * Display for "Find out more" page
     *
     * @return message
     */
    public function display_on_course_page ($course, $findoutmore, $imgurl) {
        echo 'display_on_course_page';
$findoutmore = new find_out_more_object();
        $output = html_writer::start_tag('div', array('class' => 'zigzag'));
        $i=0;
        print_object($imgurl);
        foreach ($imgurl as $value) {
            $output .= html_writer::start_tag('div', array('class' => 'row bg-info'));
                $output .= html_writer::start_tag('div', array('class' => 'col-xs-12 col-md-5'));
                    $output .= html_writer::empty_tag('img', array('src' => $value, 'class' => 'img-responsive'));
                $output .= html_writer::end_tag('div');
                $output .= html_writer::start_tag('div', array('class' => 'col-xs-12 col-md-5 col-md-offset-1'));
                    $output .= html_writer::start_tag('p', array('class' => 'h2'));
                        $output .= $findoutmore->paragraphtitle[$i];
                    $output .= html_writer::end_tag('p');
                    $output .= html_writer::start_tag('p', array('class' => 'h7 thumbnail-text'));
                        $output .= $findoutmore->paragraphdescription[$i];
                    $output .= html_writer::end_tag('p');
                $output .= html_writer::end_tag('div');
            $output .= html_writer::end_tag('div');
            $i++;
        }
        $output .= html_writer::end_tag('div');

        return $output;
    }

}