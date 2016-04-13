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
 * Orange Horizontal Numbers block renderer
 *
 * @package    block_orange_horizontal_numbers
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

class block_orange_horizontal_numbers_renderer extends plugin_renderer_base {

    /**
     * Display horizontal bar with numbers
     *
     * @param $nbuserssonnected int nb users connected
     * @param $nbposts int nb posts
     * @param $nbusers int nb users enrolled in pf
     * @param $lastusers object user last user conected
     * @return string html 
     */
    public function display_horizontal_numbers($nbuserssonnected = 0, $nbposts = 0, $nbusers = 0, $lastuser = null) {
        global $CFG;
        $output = "";

        $output .= html_writer::start_tag('div', array('class' => 'row text-center'));
            $output .= html_writer::empty_tag('img', array(
                'src' => $CFG->wwwroot. '/blocks/orange_horizontal_numbers/pix/image-tmp-forum.png'));
        $output .= html_writer::end_tag('div');

        $output .= html_writer::start_tag('div', array('class' => 'row', 'style' => 'height:60px'));
        $output .= html_writer::end_tag('div');

        $output .= html_writer::start_tag('div', array('class' => 'row'));
            $output .= html_writer::start_tag('div', array('class' => 'col-md-12 text-left'));
                $output .= html_writer::tag('h1', get_string('title', 'block_orange_horizontal_numbers', $CFG->solerni_thematic));
                $output .= html_writer::tag('span', get_string('intro', 'block_orange_horizontal_numbers'));
            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        $output .= html_writer::start_tag('div', array('class' => 'col-md-12 fullwidth-line', 'style' => 'height:50px'));
        $output .= html_writer::end_tag('div');

        $output .= html_writer::start_tag('div', array('class' => 'row', 'style' => 'height:50px'));
        $output .= html_writer::end_tag('div');

        $output .= html_writer::start_tag('div', array('class' => 'row'));

            $output .= html_writer::start_tag('div', array('class' => 'col-md-3 text-left'));
                $output .= html_writer::tag('h2', $nbposts, array('class' => 'text-orange'));
                $output .= html_writer::tag('h6', get_string('nbposts', 'block_orange_horizontal_numbers'));
            $output .= html_writer::end_tag('div');

            $output .= html_writer::start_tag('div', array('class' => 'col-md-3 text-left'));
                $output .= html_writer::tag('h2', $nbusers, array('class' => 'text-orange'));
                $output .= html_writer::tag('h6', get_string('nbusers', 'block_orange_horizontal_numbers'));
            $output .= html_writer::end_tag('div');

            $output .= html_writer::start_tag('div', array('class' => 'col-md-3 text-left'));
                $output .= html_writer::tag('h2', $nbuserssonnected, array('class' => 'text-orange'));
                $output .= html_writer::tag('h6', get_string('nbusersconnected', 'block_orange_horizontal_numbers'));
            $output .= html_writer::end_tag('div');

            $output .= html_writer::start_tag('div', array('class' => 'col-md-3 text-left'));
                $output .= html_writer::tag('h3', fullname($lastuser), array('class' => 'text-orange'));
                $output .= html_writer::tag('h6', get_string('lastuserregistered', 'block_orange_horizontal_numbers'));
            $output .= html_writer::end_tag('div');

        $output .= html_writer::end_tag('div');

        $output .= html_writer::start_tag('div', array('class' => 'row', 'style' => 'height:50px'));

            $output .= html_writer::start_tag('div', array('class' => 'col-md-12 fullwidth-line', 'style' => 'height:50px'));
            $output .= html_writer::end_tag('div');
            $output .= html_writer::start_tag('div', array('class' => 'col-md-12', 'style' => 'height:50px'));
            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        $output .= html_writer::start_tag('div', array('class' => 'row'));
            $output .= html_writer::start_tag('div', array('class' => 'col-md-12 text-left'));
                $output .= html_writer::tag('span',
                        get_string('tofaq', 'block_orange_horizontal_numbers', $CFG->wwwroot . '/static/faq.html'));
            $output .= html_writer::end_tag('div');
            $output .= html_writer::start_tag('div', array('class' => 'col-md-12', 'style' => 'height:50px'));
            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        return $output;
    }
}