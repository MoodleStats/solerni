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
    public function display_course_on_my_page($course, $extendedcourse, $imgurl) {
        return $this->display_on_course_page($course, $extendedcourse, $imgurl);
    }

    /**
     * Display Event for my page (loggedin user dashboard)
     *
     * @return message
     */
    public function display_event_on_my_page($event, $imgurl, $eventurl) {

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
    public function display_on_course_page($course, $extendedcourse, $imgurl) {
        global $OUTPUT, $PAGE;
        $havevideo = !empty($extendedcourse->videoplayer);
        $translations = new stdClass();
        $translations->number = $extendedcourse->enrolledusers;
        $translations->plural = ( $translations->number > 1) ? 's' : '';

        // Media.
        $output = html_writer::start_tag('div', array('class' => 'orange-action-media'));
            if ($imgurl) {
                $imgurl = utilities_image::get_resized_url($imgurl, array('w' => 940, 'h' => 360, 'scale' => false));
                $output .= html_writer::start_tag('div', array('class' => 'action-media-image'));
                    $output .= html_writer::empty_tag('img', array('src' => $imgurl, 'class' => 'img-responsive'));
                    if ($havevideo) {
                        $PAGE->requires->js('/blocks/orange_action/js/orange_action.js');
                        $output .= html_writer::empty_tag('img', array('src' => $OUTPUT->pix_url('playbutton', 'theme'),
                            'class' => 'action-media-playbutton js-action-media-playbutton',
                            'tabindex' => 5,
                            'role' => 'button'));
                    }
                $output .= html_writer::end_tag('div');
            }

            if ($havevideo) {
                $additionnalclasses = (!$imgurl) ? ' embed-responsive embed-responsive-16by9' : '';
                $output .= html_writer::start_tag('div', array('class' => 'action-media-video' . $additionnalclasses));
                    $output .= $extendedcourse->videoplayer;
                $output .= html_writer::end_tag('div');
            }
        $output .= '</div>';

        // Banner
        $output .= html_writer::start_tag('div', array('class' => 'orange-action-banner u-inverse'));
            $output .= html_writer::start_tag('div', array('class' => 'row'));
                // First cell.
                $output .= html_writer::start_tag('div', array('class' => 'col-xs-12 col-md-8 orange-action-banner-cell text-container'));
                    $output .= html_writer::start_tag('h1', array('class' => 'text-oneline'));
                        $output .= $course->fullname;
                    $output .= html_writer::end_tag('h1');
                    // Course summary if present.
                    if ($course->summary) {
                        $output .= html_writer::start_tag('div', array('class' => 'summary h3'));
                            $output .= html_to_text($course->summary);
                        $output .= html_writer::end_tag('div');
                    }
                    // Number of enrolled users.
                    $output .= html_writer::start_tag('div', array('class' => 'metadata'));
                        $output .= html_writer::tag('span', '', array('class' => 'icon-avatar', 'aria-hidden' => true));
                        $output .= html_writer::start_tag('span');
                            $output .= get_string("enrolledusers", 'block_orange_action', $translations);
                        $output .= html_writer::end_tag('span');
                    $output .= html_writer::end_tag('div');
                $output .= html_writer::end_tag('div');
                // Second cell.
                $output .= html_writer::start_tag('div', array('class' => 'col-xs-12 col-md-4 orange-action-banner-cell button-container'));
                    $output .= $extendedcourse->displaybutton;
                    // If next session link should be display.
                    if ($extendedcourse->registrationstatus == utilities_course::MOOCREGISTRATIONCOMPLETE) {
                                $output .= html_writer::tag('a', get_string('nextsessionlink', 'block_orange_action'),
                            array('class' => '', 'href' => $extendedcourse->newsessionurl ));
                    }
                $output .= html_writer::end_tag('div');
            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        return $output;
    }

}
