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
 * Orange Transverse Discussion block renderer
 *
 * @package    block_orange_transverse_discussion
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
use local_orange_library\utilities\utilities_object;
use local_orange_library\utilities\utilities_course;

class block_orange_transverse_discussion_renderer extends plugin_renderer_base {

    /**
     * Display all blocks with data of transverse discussion in thematic
     *
     * @param $discussion
     * @return string html 
     */
    public function display_transverse_discussion($discussion) {

        global $CFG, $OUTPUT;
        $firstposter = $discussion->get_poster();

        $output = html_writer::start_tag('div', array('class' => 'row', 'style' => 'height:30px'));
        $output .= html_writer::end_tag('div');

        $output .= html_writer::start_tag('div', array('class' => 'row'));
            $output .= html_writer::start_tag('div', array('class' => 'col-md-8 text-left'));
                $output .= html_writer::tag('h2', get_string('title', 'block_orange_transverse_discussion'));
            $output .= html_writer::end_tag('div');
            $output .= html_writer::start_tag('div', array('class' => 'col-md-4 text-right'));
                $output .= html_writer::link($CFG->wwwroot."/forum",
                        get_string('linkforum', 'block_orange_transverse_discussion', $CFG->solerni_thematic),
                        array('class' => 'btn btn-default'));
            $output .= html_writer::end_tag('div');
            $output .= html_writer::start_tag('div', array('class' => 'col-md-12 text-left'));
                $output .= html_writer::tag('h3', get_string('intro', 'block_orange_transverse_discussion'));
            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        $output .= html_writer::start_tag('div', array('class' => 'row', 'style' => 'height:30px'));
        $output .= html_writer::end_tag('div');

        $output .= html_writer::start_tag('div', array('class' => 'row'));
            $output .= html_writer::start_tag('div', array('class' => 'col-md-5 text-left'));

                // TODO : image à modifier

                $imgurl = $CFG->wwwroot. '/blocks/orange_transverse_discussion/pix/tmp-partie-forum.png';
                $output .= html_writer::empty_tag('img', array('src' => $imgurl, 'class' => 'col-xs-12 essentiels-image img-responsive'));
            $output .= html_writer::end_tag('div');

            $output .= html_writer::start_tag('div', array('class' => 'col-md-7 text-left'));
                $output .= html_writer::start_tag('div', array('class' => 'row u-inverse', 'style' => 'padding-left:10px'));
                    $output .= html_writer::tag('h5', get_string('titlebanner', 'block_orange_transverse_discussion', $CFG->solerni_thematic));
                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'row', 'style' => 'padding:15px'));
                    $output .= html_writer::tag('span', '<strong>' . get_string('forumname', 'block_orange_transverse_discussion') . '</strong>');
                    $output .= html_writer::tag('span', $discussion->get_forum()->get_name());
                    $output .= html_writer::empty_tag('br');
                    $output .= html_writer::tag('span', '<strong>' . get_string('discussionname', 'block_orange_transverse_discussion') . '</strong>');
                    $output .= html_writer::tag('span', $discussion->get_subject());
                    $output .= html_writer::empty_tag('br');
                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'fullwidth-line'));
                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'row', 'style' => 'padding:15px;'));
                    $output .= html_writer::start_tag('div', array('class' => 'col-md-1 text-left', 'style' => 'padding-left:0px;'));
                        $output .= $OUTPUT->user_picture($firstposter, array('class' => ''));
                    $output .= html_writer::end_tag('div');
                    $output .= html_writer::start_tag('div', array('class' => 'col-md-11 text-left'));
                        $output .= html_writer::tag('span', get_string('createdby', 'block_orange_transverse_discussion'));
                        $output .= html_writer::link(new moodle_url('/user/profile.php', array('id' => $firstposter->id)),
                                '<strong>' . fullname($firstposter) . '</strong>');

                        $output .= html_writer::empty_tag('br');

                        $plural = ($discussion->get_num_posts() > 1) ? 's':'';

                        $output .= html_writer::tag('span', get_string('lineresponsebegin', 'block_orange_transverse_discussion'));
                        $output .= html_writer::tag('span', '<strong>' . $discussion->get_num_posts() . '</strong>', array('class' => 'text-orange'));
                        $output .= html_writer::tag('span', '<strong>' . get_string('lineresponseend', 'block_orange_transverse_discussion', $plural) . '</strong>');

                    $output .= html_writer::end_tag('div');
                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'fullwidth-line'));
                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'row', 'style' => 'padding:15px;'));
                $output .= html_writer::link($CFG->wwwroot."/mod/forumng/discuss.php?d=" . $discussion->get_id(),
                        get_string('linkdiscuss', 'block_orange_transverse_discussion'),
                        array('class' => 'btn btn-default'));
                $output .= html_writer::end_tag('div');

                $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        return $output;
    }

}