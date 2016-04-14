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
 * Orange listforumng block renderer
 *
 * @package    block_orange_listforumng
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

use local_orange_library\utilities\utilities_object;

class block_orange_listforumng_renderer extends plugin_renderer_base {

    /**
     * Construct listforumng
     *
     * @param nbactivities in the course
     * @param nbactivitiescompleted completed in the course
     * @param details of all activities
     * @return string html of the simple progress bar
     */
    public function display_listforumng($listforumngdisplay, $title) {

        global $CFG;

        $output = "";

        if ($title != "") {
            $output .= html_writer::start_tag('div', array('class' => 'row'));
                $output .= html_writer::start_tag('div', array('class' => 'col-md-12 text-left'));
                    $output .= html_writer::tag('h2', $title);
                $output .= html_writer::end_tag('div');
            $output .= html_writer::end_tag('div');

        }

        foreach ($listforumngdisplay as $forumng) {
            $output .= html_writer::start_tag('div', array('class' => 'row boxhover', 'style' => 'padding-top:20px;'));
                // Read / unread.

                $output .= html_writer::start_tag('div', array('class' => 'col-md-6 text-left'));

                    $output .= html_writer::start_tag('div', array('class' => 'row'));
                        $output .= html_writer::start_tag('div',
                                array('class' => 'col-md-1 text-left', 'style' => 'padding-right:20px;'));

                        if ($forumng['postunread']) {
                            $output .= html_writer::start_tag('span',
                                    array('class' => 'text-left glyphicon glyphicon-arrow-right'));
                        } else {
                            $output .= html_writer::start_tag('span',
                                    array('class' => 'text-left glyphicon glyphicon-arrow-right', 'style' => 'opacity:0.2;'));
                        }
                            $output .= html_writer::end_tag('span');

                        $output .= html_writer::end_tag('div');

                        // Forum : Title, description and date created.
                        $output .= html_writer::start_tag('div',
                                array('class' => 'col-md-11 text-left', 'style' => 'padding-right:20px;'));
                            $output .= html_writer::link($CFG->wwwroot. "/mod/forumng/view.php?&id=" . $forumng['instance'],
                                    '<strong>' . $forumng['name'] . '</strong>');
                            $output .= html_writer::empty_tag('br');
                            $output .= html_writer::tag('span', utilities_object::trim_text($forumng['intro'], 100));
                            $output .= html_writer::end_tag('span');
                        $output .= html_writer::end_tag('div');

                    $output .= html_writer::end_tag('div');
                $output .= html_writer::end_tag('div');

                // Nb disucssions and nb posts.
                $output .= html_writer::start_tag('div', array('class' => 'col-md-2 text-left'));

            $strdiscus = get_string('discussions', 'block_orange_listforumng');
            if ($forumng['nbdiscus'] > 1) {
                $strdiscus .= "s";
            }
            $strmsg = get_string('messages', 'block_orange_listforumng');
            if ($forumng['nbposts'] > 1) {
                $strmsg .= "s";
            }

                $output .= html_writer::tag('span', '<strong>' . $forumng['nbdiscus'] . ' </strong>',
                        array('class' => 'text-orange'));
                $output .= html_writer::end_tag('span');
                $output .= html_writer::tag('span', '<strong>' . $strdiscus . ' </strong>');
                $output .= html_writer::end_tag('span');
                $output .= html_writer::empty_tag('br');
                $output .= html_writer::tag('span', '<strong>' . $forumng['nbposts'] . ' </strong>',
                        array('class' => 'text-orange'));
                $output .= html_writer::end_tag('span');
                $output .= html_writer::tag('span', '<strong>' . $strmsg . ' </strong>');
                $output .= html_writer::end_tag('span');
                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'col-md-4 text-left'));
                    $output .= html_writer::start_tag('div', array('class' => 'row'));
                        // User picture.
                        $output .= html_writer::start_tag('div', array('class' => 'col-md-2 text-left'));
                            $output .= html_writer::tag('span', $forumng['picture']);
                            $output .= html_writer::end_tag('span');
                        $output .= html_writer::end_tag('div');

                        // Last post : name of discusssion, name of user, date created.
                        $output .= html_writer::start_tag('div', array('class' => 'col-md-10 text-left'));
                            $output .= html_writer::tag('span', '<strong>'
                                    . utilities_object::trim_text($forumng['discussionname'], 30) . ' </strong>');
                            $output .= html_writer::end_tag('span');
                            $output .= html_writer::empty_tag('br');
                            $output .= html_writer::tag('span',
                                    get_string('from', 'block_orange_listforumng') . $forumng['usernamelastpost']);
                            $output .= html_writer::end_tag('span');
                            $output .= html_writer::empty_tag('br');
                            $output .= html_writer::tag('span', $forumng['datelastpost']);
                            $output .= html_writer::end_tag('span');
                            $output .= html_writer::empty_tag('br');
                        $output .= html_writer::end_tag('div');

                    $output .= html_writer::end_tag('div');
                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'col-md-12 fullwidth-line', 'style' => 'height:20px'));
                $output .= html_writer::end_tag('div');

            $output .= html_writer::end_tag('div');
        }

        return $output;
    }

    /**
     * Display message when no activy is monitored
     *
     * @return message
     */
    public function display_noforumng_affected () {
        $output = html_writer::start_tag('div');
        $output .= get_string('no_forumng_affected', 'block_orange_listforumng');
        $output .= html_writer::end_tag('div');

        return $output;
    }

}
