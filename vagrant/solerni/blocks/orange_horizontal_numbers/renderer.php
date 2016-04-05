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
        $output = "";

        $el1 = new html_table_cell();
        $el1->text = $nbposts;
        $el1->attributes['class'] = 'tdvalue';

        $el2 = new html_table_cell();
        $el2->text = get_string('nbposts', 'block_orange_horizontal_numbers');
        $el2->attributes['class'] = 'tdtext';

        $el3 = new html_table_cell();
        $el3->text = $nbusers;
        $el3->attributes['class'] = 'tdvalue';

        $el4 = new html_table_cell();
        $el4->text = get_string('nbusers', 'block_orange_horizontal_numbers');
        $el4->attributes['class'] = 'tdtext';

        $el5 = new html_table_cell();
        $el5->text = fullname($lastuser);
        $el5->attributes['class'] = 'tdvalue';

        $el6 = new html_table_cell();
        $el6->text = get_string('lastuserregistered', 'block_orange_horizontal_numbers');
        $el6->attributes['class'] = 'tdtext';

        $el7 = new html_table_cell();
        $el7->text = $nbuserssonnected;
        $el7->attributes['class'] = 'tdvalue';

        $el8 = new html_table_cell();
        $el8->text = get_string('nbusersconnected', 'block_orange_horizontal_numbers');
        $el8->attributes['class'] = 'tdtext';

        $table = new html_table();
        $table->data = array(new html_table_row(array($el1, $el2, $el3, $el4, $el5, $el6, $el7, $el8)));
        $output .= html_writer::table($table);

        return $output;
    }
}