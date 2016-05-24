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
use local_orange_library\utilities\utilities_object;

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
            $output .= '<a href="' . $host->url . '">';

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
                    if (!empty($host->available)) {
                        $output .= html_writer::start_tag('div', array('class' => 'orange-thematics-menu-numbers'));
                            $output .= html_writer::start_tag('div', array('class' => 'row'));
                                $output .= html_writer::start_tag('div', array('class' => 'col-xs-12 icon-thematic'));
                                    $output .= html_writer::start_tag('div');
                                        $output .= html_writer::tag('span', $host->nbuser);
                                        $output .= utilities_object::get_string_plural($host->nbuser, 'block_orange_thematics_menu', 'registereduser', 'registereduserplurial');
                                    $output .= html_writer::end_tag('div');
                                    $output .= html_writer::start_tag('div');
                                        $output .= html_writer::tag('span', $host->nbconnected);
                                        $output .= utilities_object::get_string_plural($host->nbconnected, 'block_orange_thematics_menu', 'connecteduser', 'connecteduserplurial');
                                    $output .= html_writer::end_tag('div');
                                    $output .= html_writer::start_tag('div');
                                        $output .= html_writer::tag('span', $host->nbinprogressmooc);
                                        $output .= utilities_object::get_string_plural($host->nbinprogressmooc, 'block_orange_thematics_menu', 'moocinprogress', 'moocinprogressplurial');
                                    $output .= html_writer::end_tag('div');
                                    $output .= html_writer::start_tag('div');
                                        $output .= html_writer::tag('span', $host->nbfuturemooc);
                                        $output .= utilities_object::get_string_plural($host->nbfuturemooc, 'block_orange_thematics_menu', 'moocfuture', 'moocfutureplural');
                                    $output .= html_writer::end_tag('div');
                                $output .= html_writer::end_tag('div');
                        $output .= html_writer::end_tag('div');
                    $output .= html_writer::end_tag('div');
                    }
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
                            $output .= html_writer::tag('span', $host->nbmooc);
                            $output .= utilities_object::get_string_plural($host->nbmooc, 'block_orange_thematics_menu', 'mooc', 'moocplurial');
                        }
                        $output .= html_writer::end_tag('div');
                    $output .= html_writer::end_tag('div');
                $output .= html_writer::end_tag('div');

            $output .= '</a>';
        $output .= html_writer::end_tag('div');

        return $output;
    }
}
