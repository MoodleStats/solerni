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
    const PRIVATEPF     = 6;

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
        global $CFG;
        if ($course) {
            $context = context_course::instance($course->id);
            $this->course = $course;
            $this->context = $context;
            $this->date = new DateTime();
            $this->extendedcourse = new extended_course_object();
            $this->extendedcourse->get_extended_course($course, $context);
            $selfenrolment = new enrollment_object();
            $this->enrolenddate = $selfenrolment->get_enrolment_enddate($course);
            $this->enrolmenturl = "";
            if ($CFG->solerni_isprivate && !empty($selfenrolment->get_orangeinvitation_enrolment($course))) {

                $this->urlregistration = $selfenrolment->get_orangeinvitation_enrolment($course)->customtext2;
                $this->urlmoocsubscription = $selfenrolment->get_orangeinvitation_enrolment($course)->customtext2;
            }

            $this->coursestatus = $this->get_course_status($course);

            $this->urlregistration = new moodle_url('/login/signup.php', array('id' => $this->course->id));
            $this->urlmoocsubscription = new moodle_url('/enrol/index.php', array('id' => $this->course->id));
            $this->moocurl = new moodle_url('/course/view.php', array('id' => $this->course->id));
        } else {
            throw new moodle_exception( 'missing_course_in_construct', 'local_orange_library');
        }
    }

    /**
     * Return the status of the course
     * Status could be : MOOCRUNNING
     *                          MOOCCLOSED
     *                          MOOCNOTSTARTED
     *                          MOOCCOMPLETE
     *                          PRIVATECOURSE
     *
     * @param $course
     * @return $coursestatus
     */

    private function get_course_status($course) {

        $coursestatus = self::MOOCRUNNING;

        if ($this->extendedcourse->enrolledusers == $this->get_max_enrolled_users($course)) {
            $coursestatus = self::MOOCCOMPLETE;
        } else if ($this->extendedcourse->enddate < $this->date->getTimestamp()) {
            $coursestatus = self::MOOCCLOSED;
        } else if ($this->course->startdate > $this->date->getTimestamp()) {
            $coursestatus = self::MOOCNOTSTARTED;
        }
        return $coursestatus;
    }

    /**
     * Return the status of the user
     * Status could be : USERENROLLED
     *                          USERLOGGED
     *                          USERENROLLED
     *
     * @param none
     * @return $userstatus
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
     *  Set and display the button describing the status of a course.
     *
     * @param object $course
     * @return string html_writer::tag
     */
    public function set_button($course) {

        switch ($this->coursestatus) {

            case self::MOOCCLOSED:
                return $this->controller_mooc_closed();
                break;
            case self::MOOCCOMPLETE:
                return $this->controller_mooc_complete();
                break;
            case self::MOOCNOTSTARTED:
                return $this->controller_mooc_not_started();
                break;
            default:
                return $this->controller_mooc_running();
                break;
        }
    }

    /**
     * Return the max number of enrolled users
     *
     * @param $course
     * @return $instance->customint3 (max enrolledusers)
     */
    private function get_max_enrolled_users($course) {

        $enrols = enrol_get_plugins(true);

        $enrolinstances = enrol_get_instances($course->id, true);
        $instance = null;

        foreach ($enrolinstances as $instance) {
            if (!isset($enrols[$instance->enrol])) {
                continue;
            }
        }
        if ($instance != null) {
            return $instance->customint3;
        }
    }

    /**
     * Display text
     *
     * @param $text
     * @return string html_writer::tag
     * */
    private function display_text($text) {

        return  html_writer::tag('span', get_string($text, 'local_orange_library'),
            array('class' => 'center-block'));

    }

    /**
     * Display button
     *
     * @param $text
     * @param $url
     * @return string html_writer::tag
     * */
    private function display_button($text, $url) {

            return html_writer::tag('a', get_string($text, 'local_orange_library'),
                array('class' => 'btn btn-secondary', 'href' => $url));
    }


    /**
     * Display the access button for archive
     *
     * @param none
     * @return $text
     * */
    private function display_access_to_archive() {

        $text = "";
        $text .= $this->display_text('acces_to_archive');
        $text .= $this->display_button('alert_mooc', $this->moocurl);
        return $text;
    }

    /**
     * Display status closed with alert me button
     *
     * @param none
     * @return $text
     * */
    private function display_status_closed_alert() {

        $text = "";
        $text .= $this->display_text('status_closed');
        $text .= $this->display_button('alert_mooc', $this->moocurl);
        return $text;

    }

    /**
     * Display the open date of the mooc
     *
     * @param none
     * @return string html_writer::tag
     * */
    private function display_mooc_open_date() {

        $text = "";
        $text = get_string('mooc_open_date', 'local_orange_library') . date("d-m-Y", $this->course->startdate);
        return html_writer::tag('a', $text, array('class' => 'btn btn-unavailable btn-disabled'));

    }

    /**
     * Closed status display redirection
     *
     * @param none
     * @return call to another function
     * */
    private function controller_mooc_closed() {

        if ($this->extendedcourse->replay == get_string('replay', 'format_flexpage')) {
            //  Mooc could be replayed";.
            //  CASE E: MOOC STOPPED AND COULD BE REPLAYED - USER LOGGED OR NOT.
            return $this->display_status_closed_alert();

        } else {
            //   Mooc could not be replayed".
            //   CASE D : MOOC STOPPED - USER LOGGED OR NOT.
            return $this->display_text('status_closed');

        }

    }

    /**
     * Closed status display redirection
     *
     * @param none
     * @return call to display_text()
     * */
    private function controller_mooc_complete() {

            return $this->display_text('registration_stopped');

    }

    /**
     * Closed status display redirection
     *
     * @param none
     * @return call to display_button()
     * */
    private function controller_mooc_private() {

            return $this->display_button('subscribe_to_mooc', $this->enrolmenturl);

    }

    /**
     * Mooc not started display controller
     *
     * @param none
     * @return call to display_button() or display_mooc_open_date()
     * */
    private function controller_mooc_not_started() {

        if (!isloggedin()) {
            //   User not logged.
            //   user not registered.
            //   CASE A : NOT LOGGED TO THE MOOC - USER LOGGED OR NOT.
            return $this->display_button('subscribe_to_mooc', $this->urlregistration);

        } else {
            // User logged to Solerni.
            if (!is_enrolled($this->context)) {
                // User not subscribed to the mooc.
                // CASE A : NOT LOGGED TO THE MOOC - USER LOGGED OR NOT.
                return $this->display_button('subscribe_to_mooc', $this->urlmoocsubscription);

            } else {
                // User not subscribed to the mooc.
                // CASE C : LOGGED TO A FUTUR MOOC - USER REGISTERED.
                return $this->display_mooc_open_date();
            }
        }
    }


    /**
     * Display subscription button when  mooc is running
     * Gestion de l'affichage du bouton quand un mooc est en cours
     *
     *
     * */
    private function controller_mooc_running() {

        if (($this->enrolenddate < $this->date->getTimestamp())||
            ($this->extendedcourse->enrolledusers = $this->extendedcourse->maxregisteredusers)) {
            // Mooc's running and registration date passed.
            if (!isloggedin()) {
                // User not logged to solerni.
                // User not registered to the mooc.
                // CASE F : Subscription closed -  USER LOGGED OR NOT.
                return $this->display_text('registration_stopped');
            } else {
                //   User logged to solerni.
                if (!is_enrolled($this->context)) {
                    // User not registered to the mooc.
                    // CASE F : Subscription closed -  USER LOGGED OR NOT.
                    return $this->display_text('registration_stopped');
                } else {
                    // User registered to the mooc.
                    // // CASE B :  LOGGED TO A RUNNIG MOOC - USER LOGGED.
                    return $this->display_button('access_to_mooc', $this->moocurl);
                }
            }
        } else {
            if (!isloggedin()) {
                // User not logged to solerni.
                // User not registered to the mooc.
                //   CASE A : NOT LOGGED TO THE MOOC - USER LOGGED OR NOT.
                return $this->display_button('subscribe_to_mooc', $this->urlregistration);
            } else {
                //   User logged to solerni.
                if (!is_enrolled($this->context)) {
                    // User not registered to the mooc.
                    //   CASE A : NOT LOGGED TO THE MOOC - USER LOGGED OR NOT.
                    return $this->display_button('subscribe_to_mooc', $this->urlmoocsubscription);
                } else {
                    // User registered to the mooc.
                    // // CASE B :  LOGGED TO A RUNNIG MOOC - USER LOGGED.
                    return $this->display_button('access_to_mooc', $this->moocurl);
                }
            }
        }
    }


}
