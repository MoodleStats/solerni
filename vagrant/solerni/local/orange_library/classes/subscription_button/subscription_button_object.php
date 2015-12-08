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
    }

    /**
     *  Set and display the button describing the status of a course.
     *
     * @param object $extendedcourse
     * @return string html_writer::tag
     */
    public function set_button($extendedcourse) {

        $userstatus = utilities_user::get_user_status($this->context);

        if ($userstatus == utilities_user::USERENROLLED) {
            return $this->set_button_status($extendedcourse);
        }else {
            return $this->display_button('subscribe_to_mooc', '#', "btn btn-default disabled");
        }

    }

    /**
     * Display text
     *
     * @param $text
     * @return string html_writer::tag
     * */
    private function set_button_status($extendedcourse) {
        switch ($extendedcourse->coursestatus) {
            case utilities_course::MOOCCLOSED:
                return $this->controller_mooc_closed();
                break;
            case utilities_course::MOOCREGISTRATIONCOMPLETE:
                return $this->controller_mooc_complete();
                break;
            case utilities_course::MOOCNOTSTARTED:
                return $this->controller_mooc_not_started();
                break;
            default:
                return $this->controller_mooc_running();
                break;
        }

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
     * Display button
     *
     * @param $text
     * @param $url
     * @return string html_writer::tag
     * */
    private function display_button($text, $url, $classbutton) {

            return html_writer::tag('a', get_string($text, 'local_orange_library'),
                array('class' => $classbutton, 'href' => $url));
    }

    /**
     * Closed status display redirection
     *
     * @param none
     * @return call to another function
     * */
    private function controller_mooc_closed() {
        $userstatus = utilities_user::get_user_status($this->context);

        if ($userstatus == utilities_user::USERENROLLED) {
            //  CASE E: MOOC closed and USER unenrolled.
            return $this->display_button('acces_to_archive', '#', "btn btn-engage");

        } else {

            //   CASE D : MOOC STOPPED - USER LOGGED OR NOT.
            return $this->display_button('subscribe_to_mooc', '#', "btn btn-default disabled");

        }
    }

    /**
     * Closed status display redirection
     *
     * @param none
     * @return call to display_text()
     * */
    private function controller_mooc_complete() {

        return $this->display_button('subscribe_to_mooc', '#', "btn btn-default disabled");

    }

    /**
     * Closed status display redirection
     *
     * @param none
     * @return call to display_button()
     * */
    private function controller_mooc_private() {

            return $this->display_button('subscribe_to_mooc', $this->enrolmenturl, "btn btn-engage");

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
            return $this->display_button('subscribe_to_mooc', $this->urlregistration, "btn btn-engage");

        } else {
            // User logged to Solerni.
            if (!is_enrolled($this->context)) {
                // User not subscribed to the mooc.
                // CASE A : NOT LOGGED TO THE MOOC - USER LOGGED OR NOT.
                return $this->display_button('subscribe_to_mooc', $this->urlmoocsubscription, "btn btn-engage");

            } else {
                // User not subscribed to the mooc.
                // CASE C : LOGGED TO A FUTUR MOOC - USER REGISTERED.
                return $this->display_button('subscribe_to_mooc', '#', "btn btn-default disabled");
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
                return $this->display_button('subscribe_to_mooc', '#', "btn btn-default disabled");
            } else {
                //   User logged to solerni.
                if (!is_enrolled($this->context)) {
                    // User not registered to the mooc.
                    // CASE F : Subscription closed -  USER LOGGED OR NOT.
                    return $this->display_button('registration_stopped', '#', "btn btn-default disabled");
                } else {
                    // User registered to the mooc.
                    // // CASE B :  LOGGED TO A RUNNIG MOOC - USER LOGGED.
                    return $this->display_button('access_to_mooc', $this->moocurl, "btn btn-success");
                }
            }
        } else {
            if (!isloggedin()) {
                // User not logged to solerni.
                // User not registered to the mooc.
                //   CASE A : NOT LOGGED TO THE MOOC - USER LOGGED OR NOT.
                return $this->display_button('subscribe_to_mooc', $this->urlregistration, "btn btn-engage");
            } else {
                //   User logged to solerni.
                if (!is_enrolled($this->context)) {
                    // User not registered to the mooc.
                    //   CASE A : NOT LOGGED TO THE MOOC - USER LOGGED OR NOT.
                    return $this->display_button('subscribe_to_mooc', $this->urlmoocsubscription, "btn btn-engage");
                } else {
                    // User registered to the mooc.
                    // // CASE B :  LOGGED TO A RUNNIG MOOC - USER LOGGED.
                    return $this->display_button('access_to_mooc', $this->moocurl, "btn btn-success");
                }
            }
        }
    }


}
