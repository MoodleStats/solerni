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

defined('MOODLE_INTERNAL') || die();

class block_orange_separator_line_renderer extends plugin_renderer_base {

    /**
     * Display for "Find out more" page
     *
     * @return string $output
     */
    public function display_on_course_page ($course, $context) {

        // Display first line.
        $output = html_writer::tag('div', '', array('class' => "col-xs-12 fullwidth-line"));

        return $output;
    }
}
