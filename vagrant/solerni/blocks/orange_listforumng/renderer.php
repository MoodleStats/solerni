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

        $table->head = array(get_string('headtablename', 'listforumng'));
        $table->head[] = get_string('headtablenbposts', 'listforumng');
        $table->head[] = get_string('headtablelastpost', 'listforumng');

        $table->data = array();

        foreach ($listforumngdisplay as $forumng) {
            $row = array();

            $row[] = "<a class='text-bold' href=" . $CFG->wwwroot. "/mod/forumng/view.php?&id=" . $forumng['instance'] . ">"
            .  $forumng['name'] . "</a>"
            . "<br>". $forumng['intro']
            . '<span class="listforumng-date text-italic">'
            . get_string('created', 'block_orange_listforumng') . userdate($forumng['createddate']) . '</span>';
            $row[] = $forumng['nbposts'];
            $row[] = $forumng['usernamelastpost']. "<br>". $forumng['datelastpost'];

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
