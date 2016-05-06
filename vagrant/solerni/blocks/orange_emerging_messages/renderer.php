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
 * Orange Emerging Messages block renderer
 *
 * @package    block_orange_emerging_messages
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
use local_orange_library\utilities\utilities_course;

class block_orange_emerging_messages_renderer extends plugin_renderer_base {

    /**
     * Display list of lasts posts of user
     *
     * @param $listpost array contains posts
     * @return string html
     */
    public function display_emerging_messages($course, $listposts, $listdiscussions, $listbestposts) {
        $output = "";

        // Get link acces forum of course.
        $courselinkforum = utilities_course::get_course_url_page_forum($course->id);

        $output .= html_writer::start_tag('div', array('class' => 'row'));

            $output .= html_writer::start_tag('div', array('class' => 'col-md-8 text-left'));
                $output .= html_writer::tag('h2', get_string('title', 'block_orange_emerging_messages'));
            $output .= html_writer::end_tag('div');

            $output .= html_writer::start_tag('div', array('class' => 'col-md-4 text-right'));
                if (!is_null($courselinkforum)) {
                    $output .= html_writer::link($courselinkforum, get_string('linkdiscus', 'block_orange_emerging_messages'),
                        array('class' => 'btn btn-default'));
                }
            $output .= html_writer::end_tag('div');

         $output .= html_writer::end_tag('div');

        $output .= html_writer::start_tag('div', array('class' => 'row'));
            $output .= html_writer::start_tag('div', array('class' => 'col-md-4'));

                $output .= html_writer::start_tag('div', array('class' => 'u-inverse'));
                    $output .= html_writer::tag('h4', get_string('mylastposts', 'block_orange_emerging_messages'));
                $output .= html_writer::end_tag('div');

        if (count($listposts) != 0) {
                    $output .= $this->display_emerging_discus_and_post($listposts);
        } else {
                    $output .= $this->display_emerging_messages_by_user_no_result();
        }

            $output .= html_writer::end_tag('div');

            $output .= html_writer::start_tag('div', array('class' => 'col-md-4'));
                $output .= html_writer::start_tag('div', array('class' => 'u-inverse'));
                    $output .= html_writer::tag('h4', get_string('lastdiscussions', 'block_orange_emerging_messages'));
                $output .= html_writer::end_tag('div');

        if (count($listdiscussions) != 0) {
                    $output .= $this->display_emerging_discus_and_post($listdiscussions);
        } else {
                    $output .= $this->display_emerging_discussions_last_no_result();
        }
            $output .= html_writer::end_tag('div');

            $output .= html_writer::start_tag('div', array('class' => 'col-md-4'));
                $output .= html_writer::start_tag('div', array('class' => 'u-inverse'));
                    $output .= html_writer::tag('h4', get_string('bestposts', 'block_orange_emerging_messages'));
                $output .= html_writer::end_tag('div');

        if (count($listbestposts) != 0) {
                    $output .= $this->display_emerging_best_messages($listbestposts);
        } else {
                    $output .= $this->display_emerging_best_messages_no_result();
        }
            $output .= html_writer::end_tag('div');

        $output .= html_writer::end_tag('div');

        return $output;
    }


    /**
     * Display list of lasts posts of user
     *
     * @param $listpost array contains posts
     * @return string html
     */
    public function display_emerging_discus_and_post($listpost) {
        $output = "";

        foreach ($listpost as $post) {
            $link = new moodle_url('/mod/forumng/discuss.php', array('d' => $post->discussionid . "#p" . $post->id));
            $output .= html_writer::start_tag('div', array('class' => 'boxmessage'));
                $output .= html_writer::start_tag('a', array('class' => 'linkboxmessage',  'href' => $link));
                    $output .= html_writer::tag('span', "<strong>" . $post->discussionname . "</strong>");
                    $output .= html_writer::empty_tag('br');
                    $output .= html_writer::tag('span', "<em>" . cut_message($post->message) . "</em>");
                $output .= html_writer::end_tag('a');
            $output .= html_writer::end_tag('div');
        }
        return $output;
    }

    /**
     * Display message when the user has not posted message
     *
     * @return message
     */
    public function display_emerging_messages_by_user_no_result() {
        $output = html_writer::start_tag('div');
            $output .= html_writer::tag('span', get_string('nouserposts', 'block_orange_emerging_messages'));
        $output .= html_writer::end_tag('div');

        return $output;
    }


    /**
     * Display message when no lasts messages
     *
     * @return message
     */
    public function display_emerging_discussions_last_no_result() {
        $output = html_writer::start_tag('div');
            $output .= html_writer::tag('span', get_string('nodiscussions', 'block_orange_emerging_messages'));
        $output .= html_writer::end_tag('div');

        return $output;
    }


    /**
     * Display list of best posts
     *
     * @param $listpost array contains posts
     * @return string html
     */
    public function display_emerging_best_messages($listpost) {
        $output = "";
        foreach ($listpost as $post) {
            $link = new moodle_url('/mod/forumng/discuss.php', array('d' => $post->discussionid . "#p" . $post->id));
            $output .= html_writer::start_tag('div', array('class' => 'boxmessage'));
                $output  .= html_writer::start_tag('a', array('class' => 'linkboxmessage',  'href' => $link));
                    $output .= html_writer::tag('span', "<strong>" . $post->discussionname . "</strong>");
                    $output .= html_writer::empty_tag('br');
                    $output .= html_writer::tag('span', "<em>" . cut_message($post->message) . "</em>");
                    $output .= html_writer::empty_tag('br');
                    $output .= html_writer::tag('span', get_string('rate', 'block_orange_emerging_messages') . $post->rate);
                $output .= html_writer::end_tag('a');
            $output .= html_writer::end_tag('div');
        }
        return $output;
    }

    /**
     * Display message When there is no better message
     *
     * @return message
     */
    public function display_emerging_best_messages_no_result() {
        $output = html_writer::start_tag('div');
            $output .= html_writer::tag('span', get_string('nobestposts', 'block_orange_emerging_messages'));
        $output .= html_writer::end_tag('div');

        return $output;
    }

}
