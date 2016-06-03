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
 * Orange Icons Map
 *
 *
 * @package    block_orange_iconsmap
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

class block_orange_iconsmap_renderer extends plugin_renderer_base {

    /**
     * Display for "Find out more" page
     *
     * @return string $output
     */
    public function display_on_course_page($course, $extendedcourse) {

        $output = html_writer::start_tag('div', array('class' => 'icons-map-rows'));
            // Display first line.
            $output .= html_writer::start_tag('div', array('class' => 'row icons-map-row'));
                // Display begin and end date.
                $output .= $this->display_iconmap('calendar', $extendedcourse, $course);
                // Display sequences number.
                $output .= $this->display_iconmap('sequence', $extendedcourse);
                // Display working time.
                $output .= $this->display_iconmap('time', $extendedcourse);
                // Display certification.
                $customcss = (!$extendedcourse->certification) ? ' inactive' : '';
                $output .= $this->display_iconmap('certificate', $extendedcourse, null, $customcss);
                // Display Badges.
                $customcss = (!$extendedcourse->badge) ? ' inactive' : '';
                $output .= $this->display_iconmap('badge', $extendedcourse, null, $customcss);
                // Display price.
                $customcss = (!$extendedcourse->price) ? ' inactive' : '';
                $output .= $this->display_iconmap('price', $extendedcourse, null, $customcss);
            $output .= html_writer::end_tag('div');

        $output .= html_writer::end_tag('div');

        return $output;
    }

    public function display_iconmap($name, $extendedcourse, $course = null, $customcss = '') {

        if (!$name) {
            return false;
        }

        $output = html_writer::start_tag('div', array('class' => 'col-xs-12 col-sm-6 col-md-4 ' . $customcss));
            $output .= html_writer::start_tag('div', array('class' => 'icon-map'));

                $output .= html_writer::tag('span', '',
                        array('class' => 'icon-halloween icon-halloween--small
                            icon-halloween--' . $name . ' icon-map-media'));

                $output .= html_writer::start_tag('div', array('class' => 'icon-map-body bold'));

        switch ($name) {
            case 'calendar':
                $output .= html_writer::tag('div',
                    date("d-m-Y", $course->startdate) . get_string('to', 'block_orange_iconsmap'),
                    array());
                $output .= html_writer::tag('div', date("d-m-Y", $extendedcourse->enddate), array('class' => 'movetext'));
            break;
            case 'sequence':
                $output .= html_writer::tag('span', $extendedcourse->duration, array('class' => 'h2 orange-typical-line-height'));
                $output .= get_string('weeks', 'block_orange_iconsmap');
            break;
            case 'time':
                $output .= html_writer::tag('span', $extendedcourse->workingtime . "H",
                        array('class' => 'h2 orange-typical-line-height'));
                $output .= get_string('weeks', 'block_orange_iconsmap');
            break;
            case 'certificate':
                $output .= html_writer::tag('span', get_string("certification", 'local_orange_library'),
                        array('class' => 'orange-typical-line-height'));
            break;
            case 'badge':
                $output .= html_writer::tag('span', get_string("badge", 'local_orange_library'),
                        array('class' => 'orange-typical-line-height'));
            break;
            case 'price':
                $content = ($extendedcourse->price) ?
                    $extendedcourse->price :
                    get_string("price_default", 'local_orange_library');
                $output .= html_writer::tag('span', $content,
                        array('class' => 'orange-typical-line-height'));
            break;
        }

                $output .= html_writer::end_tag('div');

            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        return $output;
    }
}
