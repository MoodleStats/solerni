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
 * Orange Opinion block renderer
 *
 * @package    block_orange_opinion
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

class block_orange_opinion_renderer extends plugin_renderer_base {

    /**
     * Display carousel with opinions of users
     *
     * @param $discussion
     * @return string html 
     */
    public function display_carousel($opinions) {

        $nbslides = count($opinions);

        global $CFG, $OUTPUT;

        $output = "";

        $output .= html_writer::start_tag('div', array('class' => 'row orange-opinion-header'));
            $output .= html_writer::start_tag('div');
                $output .= html_writer::tag('h2', get_string('title', 'block_orange_opinion'));
            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        $output .= html_writer::start_tag('div', array('class' => 'row'));
            $output .= html_writer::start_tag('div', array('class' => 'u-row-table  orange-opinion-carousel'));

                $output .= html_writer::start_tag('div', array('class' => 'col-xs-1 u-vertical-align'));
                    $output .= html_writer::link("#carousel-opinion",
                        "<span class='glyphicon glyphicon-chevron-left'></span>",
                        array('class' => 'left carousel-control', 'data-slide' => 'prev'));
                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'col-xs-10 orange-opinion-carousel-outline'));

                    $output .= html_writer::start_tag('div', array('id' => 'carousel-opinion', 'class' => 'carousel slide', 'data-ride' => 'carousel'));

                        // Dots.
                        $output .= $this->display_dots($nbslides);

                        $output .= html_writer::start_tag('div', array('class' => 'carousel-inner', 'role' => 'listbox'));

                            $ind = 1;
                            foreach ($opinions as $key => $opinion) {
                                if ($ind == 1) {
                                    $output .= html_writer::start_tag('div', array('class' => 'item active'));
                                } else {
                                    $output .= html_writer::start_tag('div', array('class' => 'item'));
                                }

                                $output .= $this->display_slide($opinion, $ind, $nbslides);

                                $output .= html_writer::end_tag('div');

                                $ind++;
                            }

                        $output .= html_writer::end_tag('div');

                    $output .= html_writer::end_tag('div');

                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'col-xs-1 u-vertical-align'));
                    $output .= html_writer::link("#carousel-opinion",
                        "<span class='glyphicon glyphicon-chevron-right'></span>",
                        array('class' => 'right carousel-control', 'data-slide' => 'next'));
                $output .= html_writer::end_tag('div');

            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        return $output;
    }


    /**
     * Display slide for carousel
     *
     * @param $opinion
     * @return string html 
     */
    public function display_slide($opinion, $ind, $total) {

        $output = "";

        $output .= html_writer::start_tag('div', array('id' => 'toto', 'class' => 'orange-opinion-carousel-content'));

            $output .= html_writer::start_tag('div', array('class' => 'orange-opinion-text'));

                $output .= html_writer::start_tag('div', array('class' => 'orange-opinion-title'));
                    $output .= html_writer::tag('span', format_text($opinion->title . ' (slide ' . $ind . '/' . $total . ')'));
                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'orange-opinion-ident'));
                    $output .= html_writer::tag('span', format_text($opinion->username));
                    $output .= html_writer::tag('span', format_text($opinion->dateopinion));
                    $output .= html_writer::tag('span', format_text(get_string('followedmooc', 'block_orange_opinion', $opinion->moocname)));
                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'orange-opinion-content'));
                    $output .= html_writer::tag('span', format_text($opinion->content));
                $output .= html_writer::end_tag('div');

            $output .= html_writer::end_tag('div');

        $output .= html_writer::end_tag('div');

        return $output;
    }

    /**
     * Display bulle for carousel
     *
     * @param $opinion
     * @return string html 
     */
    public function display_dots($nbslides) {

        $output = "";

        $output .= html_writer::start_tag('ol', array('class' => 'carousel-indicators'));

        for ($number = 0; $number < $nbslides; $number++) {
            if ($number == 0) {
                $output .= html_writer::start_tag('li', array('class' => 'active', 'data-target' => '#carousel-opinion', 'data-slide-to' => '0'));
            } else {
                $output .= html_writer::start_tag('li', array('data-target' => '#carousel-opinion', 'data-slide-to' => $number));
            }

            $output .= html_writer::end_tag('li');
        }

        $output .= html_writer::end_tag('ol');

        return $output;
    }

}
