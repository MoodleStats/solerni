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

class block_orange_emerging_messages_renderer extends plugin_renderer_base {

    /**
     * Display list of lasts posts of user
     *
     * @param $listpost array contains posts
     * @return string html 
     */
    public function display_emerging_messages_by_user($listpost) {
        global $CFG;
        $output = "";
        foreach ($listpost as $post) {
            $link = $CFG->wwwroot . "/mod/forumng/discuss.php?d=" . $post->discussionid . "#p" . $post->id;
            $output .= html_writer::start_tag('div', array('class' => 'boxmessage'));
            $output  .= html_writer::start_tag('a', array('class' => 'linkboxmessage',  'href' => $link));
            $output .= "<b>" . $post->discussionname . "</b><br>";
            $output .= "<i>" . cut_message($post->message) . "</i><br>";
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
    public function display_emerging_messages_by_user_no_result($listpost) {
        $output = html_writer::start_tag('div');
        $output .= get_string('nouserposts', 'block_orange_emerging_messages');
        $output .= html_writer::end_tag('div');

        return $output;
    }


    /**
     * Display lasts discussions list
     *
     * @param $listpost array contains posts
     * @return string html
     */
    public function display_emerging_discussions_last($listpost) {
        global $CFG;
        $output = "";
        foreach ($listpost as $post) {
            $link = $CFG->wwwroot . "/mod/forumng/discuss.php?d=" . $post->discussionid;
            $output .= html_writer::start_tag('div', array('class' => 'boxdiscus'));
            $output  .= html_writer::start_tag('a', array('class' => 'linkboxmessage',  'href' => $link));
            $output .= html_writer::start_tag('b', array('class' => 'valign'));
            $output .= $post->discussionname;
            // $output .= "<i>" . $post->message . "</i>";
            $output .= html_writer::end_tag('b');
            $output .= html_writer::end_tag('a');
            $output .= html_writer::end_tag('div');
        }
        return $output;
    }


    /**
     * Display message when no lasts messages
     *
     * @return message
     */
    public function display_emerging_discussions_last_no_result($listpost) {
        $output = html_writer::start_tag('div');
        $output .= get_string('nodiscussions', 'block_orange_emerging_messages');
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
        global $CFG;
        $output = "";
        foreach ($listpost as $post) {
            $link = $CFG->wwwroot . '/mod/forumng/discuss.php?d='.$post->discussionid . '#p' . $post->id;
            $output .= html_writer::start_tag('div', array('class' => 'boxmessage'));
            $output  .= html_writer::start_tag('a', array('class' => 'linkboxmessage',  'href' => $link));
            $output .= "<b>" . $post->discussionname . "</b><br>";
            $output .= "<i>" . cut_message($post->message) . "</i><br>";
            $output .= "<i> Note : " . $post->rate . "</i><br>";
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
    public function display_emerging_best_messages_no_results($listpost) {
        $output = html_writer::start_tag('div');
        $output .= get_string('nobestposts', 'block_orange_emerging_messages');
        $output .= html_writer::end_tag('div');

        return $output;
    }

}
