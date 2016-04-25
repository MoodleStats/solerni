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
 *
 * Orange Thematics Menu renderer.
 *
 * @package    block_orange_thematics_menu
 * @copyright  2016 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

use local_orange_library\utilities\utilities_image;

class block_orange_thematics_menu_renderer extends plugin_renderer_base {

    /**
     *  Set the displayed text for one thematic
     *
     * @param object $host 
     * @return string $output
     */
    public function menu_item($host) {

        $imgurl = utilities_image::get_resized_url($host->illustration, array('w' => 664, 'h' => 354, 'scale' => false));
        $output = html_writer::start_tag('div', array('class' => 'col-xs-12 col-sm-6 col-md-4 orange-thematics-menu-item'));

            // Title.
            $output .= html_writer::start_tag('div', array('class' => 'u-inverse'));
                $output .= html_writer::start_tag('div', array('class' => 'row orange-thematics-menu-top'));
                    $output .= html_writer::start_tag('div', array('class' => 'col-xs-12 icon-thematic'));
                        $output .= html_writer::empty_tag('img', array('src' => $host->logo, 'class' => 'essentiels-image'));
                        $output .= html_writer::tag('span', ucfirst($host->name));
                    $output .= html_writer::end_tag('div');
                $output .= html_writer::end_tag('div');
            $output .= html_writer::end_tag('div');

            // Image and numbers.
            $output .= html_writer::start_tag('div', array('class' => 'orange-thematics-middle'));
                $output .= html_writer::start_tag('div', array('class' => 'orange-thematics-menu-image'));
                    $output .= html_writer::empty_tag('img', array('src' => $imgurl, 'class' => 'img-responsive'));
                $output .= html_writer::end_tag('div');
                $output .= html_writer::start_tag('div', array('class' => 'orange-thematics-menu-numbers'));
                    $output .= html_writer::start_tag('div', array('class' => 'row'));
                        $output .= html_writer::start_tag('div', array('class' => 'col-xs-12 icon-thematic'));
                            $output .= html_writer::start_tag('div');
                                $output .= html_writer::tag('span', $host->nbusers);
                                $output .= get_string('registereduser', 'block_orange_thematics_menu',
                                        ($host->nbusers > 1) ? 's' : '');
                            $output .= html_writer::end_tag('div');
                            $output .= html_writer::start_tag('div');
                                $output .= html_writer::tag('span', $host->nbconnected);
                                $output .= get_string('connecteduser', 'block_orange_thematics_menu',
                                        ($host->nbconnected > 1) ? 's' : '');
                            $output .= html_writer::end_tag('div');
                            $output .= html_writer::start_tag('div');
                                $output .= html_writer::tag('span', $host->nbinprogressmooc);
                                $output .= get_string('moocinprogress', 'block_orange_thematics_menu',
                                        ($host->nbinprogressmooc > 1) ? 's' : '');
                            $output .= html_writer::end_tag('div');
                            $output .= html_writer::start_tag('div');
                                $output .= html_writer::tag('span', $host->nbfuturemooc);
                                $output .= get_string('moocfuture', 'block_orange_thematics_menu',
                                        ($host->nbfuturemooc > 1) ? 's' : '');
                            $output .= html_writer::end_tag('div');
                        $output .= html_writer::end_tag('div');
                    $output .= html_writer::end_tag('div');
                $output .= html_writer::end_tag('div');
            $output .= html_writer::end_tag('div');

            // Bottom.
            $output .= html_writer::start_tag('div', array('class' => 'orange-thematics-menu-bottom'));
                $output .= html_writer::start_tag('div', array('class' => 'row'));
                    $output .= html_writer::start_tag('div',
                            array('class' => 'col-xs-6 orange-thematics-menu-bottom-cell orange-thematics-menu-button text-left'));
                        (!empty($host->available)) ? $btnclass = "" : $btnclass = "disabled";
                        $output .= '<a class="btn btn-default '. $btnclass .'" href="' . $host->url . '">' . 
                                get_string('gotothematic', 'block_orange_thematics_menu').'</a>';
                    $output .= html_writer::end_tag('div');
                    $output .= html_writer::start_tag('div',
                            array('class' => 'col-xs-6 orange-thematics-menu-bottom-cell orange-thematics-menu-nbmoocs text-right'));
                    if (!empty($host->available)) {
                        $output .= html_writer::tag('span', $host->nbmoocs);
                        $output .= get_string('mooc', 'block_orange_thematics_menu', ($host->nbmoocs > 1) ? 's' : '');
                    }
                    $output .= html_writer::end_tag('div');
                $output .= html_writer::end_tag('div');
            $output .= html_writer::end_tag('div');

        $output .= html_writer::end_tag('div');

        return $output;
    }
}
