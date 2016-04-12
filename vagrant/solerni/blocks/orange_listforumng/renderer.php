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
    public function display_listforumng($listforumngdisplay) {

        global $CFG;

        $table = new html_table;

        $table->data = array();

        foreach ($listforumngdisplay as $forumng) {
            $row = array();

            // Read / unread.
            if ($forumng['postunread']) {
                $row[] = '<span class="glyphicon glyphicon-arrow-right""></span>';
            } else {
                $row[] = '<span class="glyphicon glyphicon-arrow-right" style="opacity:0.2";></span>';
            }

            // Forum : Title, description and date created.
            $row[] = "<a class='text-bold' href=" . $CFG->wwwroot. "/mod/forumng/view.php?&id=" . $forumng['instance'] . "><b>"
            . $forumng['name'] . "</b></a>"
            . "<br>". utilities_object::trim_text($forumng['intro'], 100);

            // Nb disucssions and nb posts.
            $strdiscus = get_string('discussions', 'block_orange_listforumng');
            if ($forumng['nbdiscus'] > 1) {
                $strdiscus .= "s";
            }
            $strmsg = get_string('messages', 'block_orange_listforumng');
            if ($forumng['nbposts'] > 1) {
                $strmsg .= "s";
            }
            $row[] = "<font color='orange'><b>". $forumng['nbdiscus'] . "</b></font> "
                    . $strdiscus
                    . "<br>"
                    . "<font color='orange'><b>" . $forumng['nbposts']. "</b></font> "
                    . $strmsg;

            // User picture.
            $row[] = $forumng['picture'];

            // Last post : name of discusssion, name of user, date created.
            $row[] = "<b>" . utilities_object::trim_text($forumng['discussionname'], 30). "</b><br>"
                    . get_string('from', 'block_orange_listforumng') . $forumng['usernamelastpost']
                    . "<br>". $forumng['datelastpost'];

            $table->data[] = $row;
        }

           $output = html_writer::table($table);
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
