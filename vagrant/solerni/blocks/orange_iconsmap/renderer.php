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
 * Orange Icons Map
 *
 * @package    block_orange_iconsmap
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
use local_orange_library\utilities\utilities_course;
use local_orange_library\utilities\utilities_image;
use local_orange_library\extended_course\extended_course_object;

class block_orange_iconsmap_renderer extends plugin_renderer_base {

    /**
     * Display for "Find out more" page
     *
     * @return string $output
     */
    public function display_on_course_page ($course, $context) {

        $extendedcourse = new extended_course_object();
        $extendedcourse->get_extended_course($course, $context);

        // Display first line.
        $output = html_writer::start_tag('div', array('class' => 'row'));
            // Display begin and end date.
            $output .= $this->display_date($course, $extendedcourse);
            // Display sequences number.
            $output .= $this->display_duration($extendedcourse);
            // Display working time.
            $output .= $this->display_working_time($extendedcourse);
        $output .= html_writer::end_tag('div');
        $output .= html_writer::start_tag('div', array('class' => 'row'));
            // Display certification.
            $output .= $this->display_certificate($extendedcourse);
            // Display Badges.
            $output .= $this->display_badge($extendedcourse);
            // Display price.
            $output .= $this->display_price($extendedcourse);
        $output .= html_writer::end_tag('div');

        return $output;
    }

    /**
     * Display begin and end date
     *
     * @return $output
     */
    public function display_date ($course, $extendedcourse) {

        $output = html_writer::start_tag('div', array('class' => 'col-xs-12 col-md-4'));
            $output .= html_writer::start_tag('div', array('class' => 'icon-map'));
                $output .= html_writer::tag('span', "", array('class' => 'icon-halloween icon-halloween--calendar'));
                    $output .= html_writer::start_tag('div', array('style' => 'float:right'));
                        $output .= html_writer::tag('span',
                                date("d-m-Y", $course->startdate).get_string('to', 'block_orange_iconsmap'),
                                array('class' => 'center-block'));
                        $enddate = $extendedcourse->enddate;
                        $output .= html_writer::tag('span', date("d-m-Y", $enddate), array('class' => 'center-block'));
                    $output .= html_writer::end_tag('div');
            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        return $output;
    }

    /**
     * Display number of sequences
     *
     * @return $output
     */
    public function display_duration ($extendedcourse) {

        $output = html_writer::start_tag('div', array('class' => 'col-xs-12 col-md-4'));
            $output .= html_writer::start_tag('div', array('class' => 'icon-map'));
                $output .= html_writer::tag('span', "", array('class' => 'icon-halloween icon-halloween--sequence'));
                    $output .= html_writer::start_tag('div', array('style' => 'float:right'));
                        $output .= html_writer::tag('span', $extendedcourse->duration, array('class' => 'h2'));
                        $output .= html_writer::tag('span', get_string('weeks', 'block_orange_iconsmap'));
                    $output .= html_writer::end_tag('div');
            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        return $output;
    }


    /**
     * Display the working time
     *
     * @return $output
     */
    public function display_working_time ($extendedcourse) {

        $output = html_writer::start_tag('div', array('class' => 'col-xs-12 col-md-4'));
            $output .= html_writer::start_tag('div', array('class' => 'icon-map'));
                $output .= html_writer::tag('span', "", array('class' => 'icon-halloween icon-halloween--time'));
                    $output .= html_writer::start_tag('div', array('style' => 'float:right'));
                        $output .= html_writer::tag('span', $extendedcourse->workingtime."H", array('class' => 'h2'));
                        $output .= html_writer::tag('span', get_string('week', 'block_orange_iconsmap'));
                    $output .= html_writer::end_tag('div');
            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        return $output;
    }

    /**
     * Display certificate
     *
     * @return $output
     */
    public function display_certificate ($extendedcourse) {

        $display = " inactive";
        $certifitatetext = get_string("certification_default", 'local_orange_library');
        if ($extendedcourse->badge) {
            $certifitatetext = get_string("certification", 'local_orange_library');
            $display = "";
        }
        $output = html_writer::start_tag('div', array('class' => 'col-xs-12 col-md-4'.$display));
            $output .= html_writer::start_tag('div', array('class' => 'icon-map'));
                $output .= html_writer::tag('span', "", array('class' => 'icon-halloween icon-halloween--certificate'));
                    $output .= html_writer::start_tag('div', array('style' => 'float:right'));
                        $output .= html_writer::tag('span', $certifitatetext);
                    $output .= html_writer::end_tag('div');
            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        return $output;
    }

    /**
     * Display badge
     *
     * @return $output
     */
    public function display_badge ($extendedcourse) {

        $display = " inactive";
        if ($extendedcourse->badge) {
            $display = "";
        }
        $output = html_writer::start_tag('div', array('class' => 'col-xs-12 col-md-4'.$display));
            $output .= html_writer::start_tag('div', array('class' => 'icon-map'));
                $output .= html_writer::tag('span', "", array('class' => 'icon-halloween icon-halloween--badge'));
                    $output .= html_writer::start_tag('div', array('style' => 'float:right'));
                        $output .= html_writer::tag('span', get_string("badge", 'local_orange_library'));
                    $output .= html_writer::end_tag('div');
            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        return $output;
    }

    /**
     * Display price
     *
     * @return $output
     */
    public function display_price ($extendedcourse) {

        $textprice = get_string("price_default", 'local_orange_library');
        if ($extendedcourse->price) {
            $textprice = $extendedcourse->price;
        }
        $output = html_writer::start_tag('div', array('class' => 'col-xs-12 col-md-4'));
            $output .= html_writer::start_tag('div', array('class' => 'icon-map'));
                $output .= html_writer::tag('span', "", array('class' => 'icon-halloween icon-halloween--price'));
                    $output .= html_writer::start_tag('div', array('style' => 'float:right'));
                        $output .= html_writer::tag('span', $textprice);
                    $output .= html_writer::end_tag('div');
            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        return $output;
    }

}