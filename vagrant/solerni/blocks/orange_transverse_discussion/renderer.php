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
use local_orange_library\utilities\utilities_image;

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

        $output = html_writer::start_tag('div', array('class' => 'row'));

            $output .= html_writer::start_tag('div', array('class' => 'col-md-8 orange-transverse-discussion-title'));
                $output .= html_writer::start_tag('div');
                    $output .= html_writer::tag('span', get_string('title', 'block_orange_transverse_discussion'), array('class' => 'h2'));
                    $output .= html_writer::end_tag('span');
                $output .= html_writer::end_tag('div');
                $output .= html_writer::start_tag('div');
                    $output .= html_writer::tag('span', get_string('intro', 'block_orange_transverse_discussion'), array('class' => 'h3'));
                    $output .= html_writer::end_tag('span');
                $output .= html_writer::end_tag('div');
            $output .= html_writer::end_tag('div');

            $output .= html_writer::start_tag('div', array('class' => 'col-md-4 text-right'));
                $output .= html_writer::link($CFG->wwwroot."/forum",
                        get_string('linkforum', 'block_orange_transverse_discussion', $CFG->solerni_thematic),
                        array('class' => 'btn btn-default'));
            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        $output .= html_writer::start_tag('div', array('class' => 'row orange-transverse-discussion-box'));
            $output .= html_writer::start_tag('div', array('class' => 'col-md-5'));
                // TODO : image à modifier.
                $imgurl = $CFG->wwwroot. '/blocks/orange_transverse_discussion/pix/tmp-partie-forum.png';
                $output .= html_writer::empty_tag('img', array('src' => $imgurl, 'class' => 'essentiels-image img-responsive'));
            $output .= html_writer::end_tag('div');

            $output .= html_writer::start_tag('div', array('class' => 'col-md-7 orange-transverse-discussion-info'));

                $output .= html_writer::start_tag('div', array('class' => 'row u-inverse info-titlebanner'));
                    $output .= html_writer::tag('span', get_string('titlebanner', 'block_orange_transverse_discussion', $CFG->solerni_thematic), array('class' => 'h5'));
                    $output .= html_writer::end_tag('span');
                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'row info-item'));
                    $output .= html_writer::start_tag('div');
                        $output .= html_writer::tag('span', '<strong>' . get_string('forumname', 'block_orange_transverse_discussion') . '</strong>');
                        $output .= html_writer::tag('span', $discussion->get_forum()->get_name());
                    $output .= html_writer::end_tag('div');
                    $output .= html_writer::start_tag('div');
                        $output .= html_writer::tag('span', '<strong>' . get_string('discussionname', 'block_orange_transverse_discussion') . '</strong>');
                        $output .= html_writer::tag('span', $discussion->get_subject());
                    $output .= html_writer::end_tag('div');
                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'row info-separator'));
                    $output .= html_writer::start_tag('div', array('class' => 'fullwidth-line'));
                    $output .= html_writer::end_tag('div');
                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'row info-item'));
                    $output .= html_writer::start_tag('div', array('class' => 'col-md-1 info-picture'));
                        $output .= $OUTPUT->user_picture($firstposter, array('class' => ''));
                    $output .= html_writer::end_tag('div');

                    $output .= html_writer::start_tag('div', array('class' => 'col-md-11'));
                        $output .= html_writer::start_tag('div');
                            $output .= html_writer::tag('span', get_string('createdby', 'block_orange_transverse_discussion'));
                            $output .= html_writer::link(new moodle_url('/user/profile.php', array('id' => $firstposter->id)),
                                '<strong>' . fullname($firstposter) . '</strong>');
                        $output .= html_writer::end_tag('div');

                        $output .= html_writer::start_tag('div');
                            $output .= html_writer::tag('span', get_string('lineresponsebegin', 'block_orange_transverse_discussion'));
                            $output .= html_writer::tag('span', '<strong>' . $discussion->get_num_posts() . '</strong>', array('class' => 'text-orange'));
                            $output .= html_writer::tag('span', '<strong>' . utilities_object::get_string_plural($discussion->get_num_posts(), 'block_orange_transverse_discussion', 'response', 'responseplural') . '</strong>');
                        $output .= html_writer::end_tag('div');
                    $output .= html_writer::end_tag('div');
                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'row info-separator'));
                    $output .= html_writer::start_tag('div', array('class' => 'fullwidth-line'));
                    $output .= html_writer::end_tag('div');
                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'row info-item'));
                $output .= html_writer::link($CFG->wwwroot."/mod/forumng/discuss.php?d=" . $discussion->get_id(),
                        get_string('linkdiscuss', 'block_orange_transverse_discussion'),
                        array('class' => 'btn btn-default'));
                $output .= html_writer::end_tag('div');

            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        return $output;
    }

}