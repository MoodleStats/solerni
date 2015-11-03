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
use html_writer;
use DateTime;
use moodle_url;
use context_course;
use moodle_exception;

defined('MOODLE_INTERNAL') || die();

class subscription_button_object {
    const MOOCCOMPLETE     = 0;
    const MOOCCLOSED       = 1;
    const MOOCNOTSTARTED   = 2;
    const MOOCRUNNING      = 3;
    const USERLOGGED        = 4;
    const USERENROLLED      = 5;

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
     * @param object $course
     */
    public function __construct($course) {

        if ($course) {
            $context = context_course::instance($course->id);
            $this->course = $course;
            $this->context = $context;
            $this->date = new DateTime();
            $this->extendedcourse = new extended_course_object();
            $this->extendedcourse->get_extended_course($course, $context);
            $selfenrolment = new enrollment_object();
            $this->enrolenddate = $selfenrolment->get_enrolment_enddate($course);
            $utilitiescourse = new utilities_course();
            $this->coursestatus = $utilitiescourse->get_course_status($this->course);
            $this->urlregistration = new moodle_url('/login/signup.php', array('id' => $this->course->id));
            $this->urlmoocsubscription = new moodle_url('/enrol/index.php', array('id' => $this->course->id));
            $this->moocurl = new moodle_url('/course/view.php', array('id' => $this->course->id));
        } else {
            throw new moodle_exception( 'missing_course_in_construct', 'local_orange_library');
        }
    }

    /**
     * Return the status of the user
     * Status could be : USERENROLLED
     *                          USERLOGGED
     *                          USERENROLLED
     *
     * @param type $context
     * @param type $course
     */
    private function get_user_status() {

        $userstatus = self::USERENROLLED;

        if (isloggedin()) {
            $userstatus = self::USERLOGGED;
        }
        if (is_enrolled($this->context)) {
            $userstatus = self::USERENROLLED;
        }
        return $userstatus;

    }

    /**
     * Display the subscription button
     *
     * @param type $url
     * @return type
     */
    private function display_subscribe_to_mooc($url) {

        return html_writer::tag('a', get_string('subscribe_to_mooc', 'local_orange_library'),
                array('class' => 'btn btn-primary', 'href' => $url));

    }

    /**
     * Display the access button
     *
     *
     * */
    private function display_access_to_mooc() {

        return html_writer::tag('a', get_string('access_to_mooc', 'local_orange_library'),
                array('class' => 'btn btn-secondary', 'href' => $this->moocurl));
    }

    /**
     * Display closed status
     *
     *
     * */
    private function display_status_closed() {

        return  html_writer::tag('span', get_string('status_closed', 'local_orange_library'),
            array('class' => 'presentation__mooc__text__subtitle'));

    }

    /**
     * Display status closed with alert me button
     *
     *
     * */
    private function display_status_closed_alert() {

        $text = "";
        $text .= html_writer::tag('span', get_string('status_closed', 'local_orange_library'));
        $text .= html_writer::empty_tag('br');
        $text .= html_writer::tag('a', get_string('alert_mooc', 'local_orange_library'),
                array('class' => 'btn btn-primary', 'href' => $this->moocurl));
        return $text;

    }

    /**
     * Display registration stopped
     *
     *
     * */
    private function display_registration_stopped() {

        return  html_writer::tag('span', get_string('registration_stopped', 'local_orange_library'),
                array('class' => 'presentation__mooc__text__subtitle'));

    }

    /**
     * Display the open date of the mooc
     *
     *
     * */
    private function display_mooc_open_date() {

        $text = "";
        $text = get_string('mooc_open_date', 'local_orange_library') . date("d-m-Y", $this->course->startdate);
        return html_writer::tag('a', $text, array('class' => 'btn btn-unavailable btn-disabled'));

    }

    /**
     * Closed status display redirection
     *
     *
     * */
    private function controller_mooc_closed() {

        if ($this->extendedcourse->replay == get_string('replay', 'format_flexpage')) {
            //  Mooc could be replayed";.
            //  CASE E: MOOC STOPPED AND COULD BE REPLAYED - USER LOGGED OR NOT.
            return $this->display_status_closed_alert();

        } else {
            //   Mooc could not be replayed".
            //   CASE D : MOOC STOPPED - USER LOGGED OR NOT.
            return $this->display_status_closed();

        }

    }

    /**
     * Mooc not started display controller
     *
     *
     * */
    private function controller_mooc_not_started() {
        if (!isloggedin()) {
            //   User not logged.
            //   user not registered.
            //   CASE A : NOT LOGGED TO THE MOOC - USER LOGGED OR NOT.
            return $this->display_subscribe_to_mooc($this->urlregistration);

        } else {
            // User logged to Solerni.
            if (!is_enrolled($this->context)) {
                // User not subscribed to the mooc.
                // CASE A : NOT LOGGED TO THE MOOC - USER LOGGED OR NOT.
                return $this->display_subscribe_to_mooc($this->urlmoocsubscription);

            } else {
                // User not subscribed to the mooc.
                // CASE C : LOGGED TO A FUTUR MOOC - USER REGISTERED.
                return $this->display_mooc_open_date();
            }
        }
    }


    /**
     *
     *
     *
     * */
    private function controller_mooc_running() {

        if ($this->enrolenddate < $this->date->getTimestamp()) {
            // Mooc's running and registration date passed.
            if (!isloggedin()) {
                // User not logged to solerni.
                // User not registered to the mooc.
                // CASE F : Subscription closed -  USER LOGGED OR NOT.
                return $this->display_registration_stopped();
            } else {
                //   User logged to solerni.
                if (!is_enrolled($this->context)) {
                    // User not registered to the mooc.
                    // CASE F : Subscription closed -  USER LOGGED OR NOT.
                    return $this->display_registration_stopped();
                } else {
                    // User registered to the mooc.
                    // // CASE B :  LOGGED TO A RUNNIG MOOC - USER LOGGED.
                    return $this->display_access_to_mooc();
                }
            }
        } else {
            if (!isloggedin()) {
                // User not logged to solerni.
                // User not registered to the mooc.
                //   CASE A : NOT LOGGED TO THE MOOC - USER LOGGED OR NOT.
                return $this->display_subscribe_to_mooc($this->urlregistration);
            } else {
                //   User logged to solerni.
                if (!is_enrolled($this->context)) {
                    // User not registered to the mooc.
                    //   CASE A : NOT LOGGED TO THE MOOC - USER LOGGED OR NOT.
                    return $this->display_subscribe_to_mooc($this->urlmoocsubscription);
                } else {
                    // User registered to the mooc.
                    // // CASE B :  LOGGED TO A RUNNIG MOOC - USER LOGGED.
                    return $this->display_access_to_mooc();
                }
            }
        }
    }

    /**
     *  Set and display the button describing the status of a course.
     *
     * @param object $context
     * @param object $course
     * @return string html_writer::tag
     */
    public function set_button($course) {

        switch ($this->coursestatus) {

            case self::MOOCCLOSED:
                return $this->controller_mooc_closed();
                break;
            case self::MOOCNOTSTARTED:
                return $this->controller_mooc_not_started();
                break;
            default:
                return $this->controller_mooc_running();
                break;
        }
    }

}
