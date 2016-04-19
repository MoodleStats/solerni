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
 * Orange Separator Line renderer
 *
 * @package    blocks
 * @subpackage orange_separator_line
 * @copyright  2016 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use local_orange_library\utilities\utilities_array;

defined('MOODLE_INTERNAL') || die();


class block_orange_separator_line_renderer extends plugin_renderer_base {

    /**
     *  Set the displayed text in the block.
     *
     * @global none
     * @param none
     * @return string $text
     */
    public function get_text() {

        $text = html_writer::start_tag('div', array('class' => "col-xs-12 fullwidth-line"));
        $text .= html_writer::end_tag('div');

        return $text;

    }
}
