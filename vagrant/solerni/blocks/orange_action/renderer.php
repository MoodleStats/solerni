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
 * Orange Action block
 *
 * @package    block_orange_action
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
use local_orange_library\utilities\utilities_course;
use local_orange_library\utilities\utilities_image;

class block_orange_action_renderer extends plugin_renderer_base {

    /**
     * Display Course for my page (user dashboard)
     *
     * @return message
     */
    public function display_course_on_my_page ($course, $extendedcourse, $imgurl) {
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
                            get_string("gotocalendar", 'block_orange_action').'</a>';
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
        $output = html_writer::start_tag('div');
        $output .= html_writer::end_tag('div');

        return $output;
    }

    /**
     * Display for "Find out more" page
     *
     * @return message
     */
    public function display_on_course_page ($course, $extendedcourse, $imgurl) {

       // display_old_version();

        $output = html_writer::start_tag('div', array('class' => 'container '));
        $output .= html_writer::start_tag('div', array('class' => 'row '));

        $output .= $this->display_action_media($course, $extendedcourse, $imgurl);
        $output .= html_writer::end_tag('div');
        $output .= html_writer::start_tag('div', array('class' => 'row margin-bottom-md action-banner '));

        $output .= $this->display_action_banner($course, $extendedcourse, $imgurl);
        $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');
        return $output;

    }


    /**
     * Display for "Find out more" page
     *
     * @return message
     */
    public function display_action_media ($course, $extendedcourse, $imgurl) {

        $output = html_writer::start_tag('div', array('class' => 'embed-responsive embed-responsive-16by9 '));
        $output .= html_writer::start_tag('iframe', array('class' => 'embed-responsive-item', 'src' => 'https://www.youtube.com/embed/YE7VzlLtp-4?rel=0'));
        $output .= html_writer::end_tag('iframe');
        $output .= html_writer::end_tag('div');
        return $output;

    }

    /**
     * Display for "Find out more" page
     *
     * @return message
     */
    public function display_action_banner ($course, $extendedcourse, $imgurl) {

        $output = html_writer::start_tag('div', array('class' => 'col-md-4 action-banner__left'));
        $output .= $this->display_button_engage();
        $output .= html_writer::end_tag('div');
        $output .= html_writer::start_tag('div', array('class' => 'col-md-8 u-inverse action-banner__right'));
        $output .= html_writer::start_tag('h1', array('class' => 'oneline'));
        $output .= $course->fullname;
        $output .= html_writer::end_tag('h1');
        // Course summary if present.
        if ($course->summary) {
            $output .= html_writer::start_tag('h3', array('class' => 'oneline'));
                $output .= html_to_text($course->summary);
            $output .= html_writer::end_tag('h3');
        }
        $output .= $this->display_image($imgurl);
        // Nomber of enrolled users.
        $output .= html_writer::start_tag('span');
            if ($extendedcourse->enrolledusers <= 1) {
                $output .= get_string("enrolleduser", 'block_orange_action', $extendedcourse->enrolledusers);
            } else {
                $output .= get_string("enrolledusers", 'block_orange_action', $extendedcourse->enrolledusers);
            }
        $output .= html_writer::end_tag('span');
        // If next session link shoulfd be display.
        if ($extendedcourse->registrationstatus == utilities_course::MOOCREGISTRATIONCOMPLETE) {
            $output .= html_writer::tag('a', get_string('nextsessionlink', 'block_orange_action'),
                array('class' => '', 'href' => $extendedcourse->newsessionurl ));
        }
        return $output;
    }


    /**
     * Display for "Find out more" page
     *
     * @return message
     */
    public function display_old_version ($course, $extendedcourse, $imgurl) {

        $output = html_writer::start_tag('div', array('class' => 'row '));

        if ($imgurl) {
            $imgurl = utilities_image::get_resized_url($imgurl, array('w' => 940, 'h' => 360, 'scale' => false));
            $output .= html_writer::empty_tag('img', array('src' => $imgurl, 'class' => 'col-xs-12 essentiels-image'));
        }
        if (!empty($extendedcourse->videoplayer)) {
            $output .= $extendedcourse->videoplayer;
        }
        $output .= html_writer::end_tag('div');

        $output .= html_writer::start_tag('div', array('class' => 'row', 'style' => 'background-color:#000;'));
            // Subscription button.
            $output .= html_writer::start_tag('div', array('class' => 'col-xs-4 col-md-12'));
                    $output .= $extendedcourse->displaybutton;
            $output .= html_writer::end_tag('div');
            $output .= html_writer::start_tag('div', array('class' => 'col-xs-4 col-md-12'));
                $output .= html_writer::start_tag('h1', array('class' => '', 'style' => 'color:orange;'));
                    $output .= $course->fullname;
                $output .= html_writer::end_tag('h1');

                // Course summary if present.
                if ($course->summary) {
                    $output .= html_writer::start_tag('span', array('style' => 'font-size:28px;color:#FFF;'));
                        $output .= html_to_text($course->summary);
                    $output .= html_writer::end_tag('span');
                }

                // Nomber of enrolled users.
                $output .= html_writer::start_tag('span', array('style' => 'font-size:16px;color:#FFF;'));
                    if ($extendedcourse->enrolledusers <= 1) {
                        $output .= get_string("enrolleduser", 'block_orange_action', $extendedcourse->enrolledusers);
                    } else {
                        $output .= get_string("enrolledusers", 'block_orange_action', $extendedcourse->enrolledusers);
                    }
                $output .= html_writer::end_tag('span');

                // If next session link shoulfd be display.
                if ($extendedcourse->registrationstatus == utilities_course::MOOCREGISTRATIONCOMPLETE) {
                    $output .= html_writer::tag('a', get_string('nextsessionlink', 'block_orange_action'),
                        array('class' => '', 'href' => $extendedcourse->newsessionurl ));
                }
            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        return $output;
    }

}