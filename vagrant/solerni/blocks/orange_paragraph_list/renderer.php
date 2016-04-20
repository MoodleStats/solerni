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

class block_orange_paragraph_list_renderer extends plugin_renderer_base {

    /**
     * Display for "Find out more" page
     *
     * @return message
     */
    public function display_on_course_page ($course, $findoutmore, $imgurl) {

        $output = html_writer::start_tag('div', array('class' => 'zigzag'));
        $i=0;
        if($findoutmore->paragraphtitle){
            foreach ($findoutmore->paragraphtitle as $value) {
                if ($findoutmore->paragraphtitle[$i] != '') {
                    if ($i%2 ==1) {
                        $output .= $this->display_left_text($findoutmore->paragraphtitle[$i], $findoutmore->paragraphdescription[$i], $imgurl[$i], $findoutmore->paragraphbgcolor[$i]);
                    } else {
                        $output .= $this->display_right_text($findoutmore->paragraphtitle[$i], $findoutmore->paragraphdescription[$i], $imgurl[$i], $findoutmore->paragraphbgcolor[$i]);
                    }
                }

                $i++;
            }
        }
        $output .= html_writer::end_tag('div');

        return $output;
    }

    /**
     * Display for "Find out more" page
     *
     * @return message
     */
    public function display_right_text ($paragraphtitle, $paragraphdescription, $imgurl, $bgcolor) {

        $output = html_writer::start_tag('div', array('class' => 'row '.$bgcolor));

            $output .= html_writer::start_tag('div', array('class' => 'col-xs-12 col-md-5'));
                $output .= html_writer::empty_tag('img', array('src' => $imgurl, 'class' => 'img-responsive'));
            $output .= html_writer::end_tag('div');

            $output .= html_writer::start_tag('div', array('class' => 'col-xs-12 col-md-5 col-md-offset-1'));
                $output .= html_writer::start_tag('p', array('class' => 'h2'));
                    $output .= $paragraphtitle;
                $output .= html_writer::end_tag('p');
                $output .= html_writer::start_tag('p', array('class' => 'h7 thumbnail-text'));
                    $output .= $paragraphdescription;
                $output .= html_writer::end_tag('p');
            $output .= html_writer::end_tag('div');

        $output .= html_writer::end_tag('div');

        return $output;
    }

        /**
     * Display for "Find out more" page
     *
     * @return message
     */
    public function display_left_text ($paragraphtitle, $paragraphdescription, $imgurl, $bgcolor) {

        $output = html_writer::start_tag('div', array('class' => 'row '.$bgcolor));

            $output .= html_writer::start_tag('div', array('class' => 'col-xs-12 col-md-5'));
                $output .= html_writer::start_tag('p', array('class' => 'h2'));
                    $output .= $paragraphtitle;
                $output .= html_writer::end_tag('p');
                $output .= html_writer::start_tag('p', array('class' => 'h7 thumbnail-text'));
                    $output .= $paragraphdescription;
                $output .= html_writer::end_tag('p');
            $output .= html_writer::end_tag('div');

            $output .= html_writer::start_tag('div', array('class' => 'col-xs-12 col-md-5 col-md-offset-1'));
                $output .= html_writer::empty_tag('img', array('src' => $imgurl, 'class' => 'img-responsive'));
            $output .= html_writer::end_tag('div');

        $output .= html_writer::end_tag('div');

        return $output;
    }
}