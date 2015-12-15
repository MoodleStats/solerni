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

use local_orange_library\extended_course\extended_course_object;
use local_orange_library\enrollment\enrollment_object;
use local_orange_library\utilities\utilities_course;
use local_orange_library\utilities\utilities_user;
use html_writer;
use DateTime;
use moodle_url;
use context_course;
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

/*        global $CFG;
        if ($course) {
            $context = context_course::instance($course->id);
            $this->course = $course;
            $this->context = $context;
            $this->date = new DateTime();
            $this->extendedcourse = new extended_course_object();
            $this->extendedcourse->get_extended_course($course, $context);
            $selfenrolment = new enrollment_object();
            $this->enrolenddate = $selfenrolment->get_enrolment_enddate($course);
            $this->unenrolurl = "#";
            $this->moocurl = new moodle_url('/course/view.php', array('id' => $this->course->id));
            $this->urlregistration = new moodle_url('/login/signup.php', array('id' => $this->course->id));

            $this->enrolmenturl = "";

            $this->urlmoocsubscription = $this->moocurl;
            if ($orangeinvitation = $selfenrolment->get_orangeinvitation_enrolment($course)) {
                $this->urlregistration = $orangeinvitation->customtext2;
                $this->urlmoocsubscription = $orangeinvitation->customtext2;
            }

        } else {
            throw new moodle_exception( 'missing_course_in_construct', 'local_orange_library');
        }
 * */
 
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
     * Display text
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
    private function display_button($text, $url, $classbutton, $statuslink, $course) {
         return html_writer::tag('a', get_string($text, 'local_orange_library'),
            array('class' => $classbutton, 'href' => $url, 'data-mooc-name' => $course->fullname));
    }
}
