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
 * @package    blocks
 * @subpackage course_extended
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_orange_library\subscription_button;

use html_writer;
use moodle_exception;

defined('MOODLE_INTERNAL') || die();

class subscription_button_object {

    protected $course;
    protected $context;
    protected $extendedcourse;
    protected $date;
    protected $enrolenddate;
    protected $coursestatus;

    /**
     *  Subscription button object constructor
     * Initialization of :
     * exented course with course id
     * redirection urls etc...
     *
     * @param type $course
     * @throws moodle_exception
     *
     */
    public function __construct($course) {

    }

    /**
     * Display text
     *
     * @param $text
     * @return string html_writer::tag
     * */
    private function display_text($text, $classtext) {

        return  html_writer::tag('span', get_string($text, 'local_orange_library'),
            array('class' => $classtext));

    }

    /**
     * Display link
     *
     * @param $text
     * @return string html_writer::tag
     * */
    private function display_link($text, $url, $classtext) {

        return  html_writer::tag('link', get_string($text, 'local_orange_library'),
            array('class' => $classtext));

    }

    /**
     * Display button
     *
     * @param $text
     * @param $url
     * @return string html_writer::tag
     * */
    private function display_button($text, $url, $classbutton, $course) {
         return html_writer::tag('a', get_string($text, 'local_orange_library'),
            array('class' => $classbutton, 'href' => $url, 'data-mooc-name' => $course->fullname));
    }
}
