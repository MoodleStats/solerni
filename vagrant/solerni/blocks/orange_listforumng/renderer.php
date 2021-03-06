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
            if (block_orange_listforumng_on_forum_index_page()) {
                $output .= html_writer::tag('h2', $title);
            } else {
                $output .= html_writer::start_tag('div', array('class' => 'u-row-table orange-listforumng-title-noforumpage'));
                    $output .= html_writer::tag('span', $title, array('class' => 'h4'));
                    $output .= html_writer::end_tag('span');
                $output .= html_writer::end_tag('div');
            }
        }

        $output .= html_writer::start_tag('div', array('class' => 'row orange-listforumng-content'));

        foreach ($listforumngdisplay as $forumng) {
            $output .= html_writer::start_tag('div', array('class' => 'row u-row-table orange-listforumng-item'));

                $output .= html_writer::start_tag('div', array('class' => 'col-md-6 text-left u-vertical-align'));
                    $output .= html_writer::start_tag('div', array('class' => 'row u-row-table'));
                        $output .= html_writer::start_tag('div', array('class' => 'col-md-1 text-right orange-listforumng-item-status u-vertical-align'));

                        // Read / unread.
                        if ($forumng['postunread']) {
                            $output .= html_writer::start_tag('span', array('class' => 'text-left glyphicon glyphicon-arrow-right'));
                        } else {
                            $output .= html_writer::start_tag('span', array('class' => 'text-left glyphicon glyphicon-arrow-right', 'style' => 'opacity:0.2;'));
                        }
                            $output .= html_writer::end_tag('span');

                        $output .= html_writer::end_tag('div');

                        // Forum : Title and description.
                        $output .= html_writer::start_tag('div', array('class' => 'col-md-11 text-left u-vertical-align'));
                            $output .= html_writer::start_tag('div');
                                $output .= html_writer::link($CFG->wwwroot. "/mod/forumng/view.php?&id=" . $forumng['instance'],
                                        '<strong>' . $forumng['name'] . '</strong>');
                            $output .= html_writer::end_tag('div');

                            $output .= html_writer::start_tag('div');
                                $output .= html_writer::tag('span', utilities_object::trim_text($forumng['intro'], 100));
                                $output .= html_writer::end_tag('span');
                            $output .= html_writer::end_tag('div');
                        $output .= html_writer::end_tag('div');

                    $output .= html_writer::end_tag('div');
                $output .= html_writer::end_tag('div');

                // Nb disucssions and nb posts.
                $output .= html_writer::start_tag('div', array('class' => 'col-md-2 text-left text-bold u-vertical-align'));

                    $output .= html_writer::start_tag('div');
                        $output .= html_writer::tag('span', $forumng['nbdiscus'], array('class' => 'text-orange'));
                        $output .= html_writer::end_tag('span');
                        $output .= html_writer::tag('span', utilities_object::get_string_plural($forumng['nbdiscus'], 'block_orange_listforumng', 'discussion', 'discussionplural'));
                        $output .= html_writer::end_tag('span');
                    $output .= html_writer::end_tag('div');

                    $output .= html_writer::start_tag('div');
                        $output .= html_writer::tag('span', $forumng['nbposts'], array('class' => 'text-orange'));
                        $output .= html_writer::end_tag('span');
                        $output .= html_writer::tag('span', utilities_object::get_string_plural($forumng['nbposts'], 'block_orange_listforumng', 'message', 'messageplural'));
                        $output .= html_writer::end_tag('span');
                    $output .= html_writer::end_tag('div');

                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'col-md-4 text-left u-vertical-align'));

                    $output .= html_writer::start_tag('div', array('class' => 'row'));
                        // User picture.
                        $output .= html_writer::start_tag('div', array('class' => 'col-md-2'));
                            $output .= html_writer::tag('span', $forumng['picture']);
                            $output .= html_writer::end_tag('span');
                        $output .= html_writer::end_tag('div');

                        // Last post : name of discusssion, name of user, date created.
                        if ($forumng['nbdiscus'] > 0) {
                            $output .= html_writer::start_tag('div', array('class' => 'col-md-12'));
                                $output .= html_writer::start_tag('div');
                                    $output .= html_writer::tag('span', utilities_object::trim_text($forumng['discussionname'], 30), array('class' => 'text-bold'));
                                    $output .= html_writer::end_tag('span');
                                $output .= html_writer::end_tag('div');

                                $output .= html_writer::start_tag('div');
                                    $output .= html_writer::tag('span',
                                            get_string('from', 'block_orange_listforumng') . $forumng['usernamelastpost']);
                                    $output .= html_writer::end_tag('span');
                                $output .= html_writer::end_tag('div');

                                $output .= html_writer::start_tag('div');
                                    $output .= html_writer::tag('span', $forumng['datelastpost']);
                                    $output .= html_writer::end_tag('span');
                                $output .= html_writer::end_tag('div');

                            $output .= html_writer::end_tag('div');
                        }

                    $output .= html_writer::end_tag('div');

                $output .= html_writer::end_tag('div');

            $output .= html_writer::end_tag('div');
        }
        $output .= html_writer::end_tag('div');

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
