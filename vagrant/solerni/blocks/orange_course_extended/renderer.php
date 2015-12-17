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
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use local_orange_library\extended_course\extended_course_object;
use local_orange_library\subscription_button\subscription_button_object;


require_once($CFG->dirroot . '/local/orange_customers/lib.php');

defined('MOODLE_INTERNAL') || die();


class block_orange_course_extended_renderer extends plugin_renderer_base {

    /**
     *  Set the dicplayed text in the block.
     *
     * @param moodle_url $imgurl
     * @param object $course
     * @param object $context
     * @return string $text
     */
    public function get_text($imgurl, $course, $context) {

        $extendedcourse = new extended_course_object();
        $extendedcourse->get_extended_course($course, $context);

        $subscriptionbutton = new subscription_button_object($course);
        $text = html_writer::start_tag('div', array('class' => 'row '));
        
        if ($imgurl) {
            $text .= html_writer::empty_tag('img', array('src' => $imgurl, 'class' => 'col-xs-12 essentiels-image'));
        }
            $text .= $this->display_extendedcourse_dates($extendedcourse, $course);
            $text .= $this->display_duration_workingtime($extendedcourse);
            $text .= $this->display_price($extendedcourse);
        if (!empty($extendedcourse->badge) || !empty($extendedcourse->certification)) {
            $text .= $this->display_badge_certif($extendedcourse);
        }
            $text .= $this->display_language($extendedcourse);

            $text .= $this->display_video($extendedcourse);

            $text .= $this->display_registration($extendedcourse);
            $text .= $this->display_enrolledusers($extendedcourse);
        $text .= html_writer::end_tag('div');

        $text .= html_writer::start_tag('div', array('class' => 'row '));
            $text .= html_writer::start_tag('div', array('class' => 'col-xs-12 col-md-12'));
                    $text .= $subscriptionbutton->set_button($extendedcourse);
            $text .= html_writer::end_tag('div');
        $text .= html_writer::end_tag('div');

        $text .= html_writer::start_tag('div', array('class' => 'row center-block'));
            $text .= $this->display_prerequesites($extendedcourse);
        $text .= html_writer::end_tag('div');

        $text .= html_writer::start_tag('div', array('class' => 'row center-block'));
           $text .= $this->display_teachingteam($extendedcourse);
        $text .= html_writer::end_tag('div');

        return $text;

    }

    /**
     * Display teaching zone
     * @param type $extendedcourse
     * @return html_writer::tag
     */
    private function display_teachingteam($extendedcourse) {

        $text = html_writer::start_tag('div', array('class' => 'header'));
            $text .= html_writer::tag('h2', get_string('teachingteam', 'format_flexpage'));
        $text .= html_writer::end_tag('div');

        $text .= html_writer::start_tag('div', array('class' => 'content'));
            $text .= html_writer::start_tag('div', array('class' => 'col-xs-1'));
                $text .= html_writer::tag('span', '');
            $text .= html_writer::end_tag('div');
            $teachingteam = $extendedcourse->teachingteam;
            $text .= html_writer::tag('span', $teachingteam, array('class' => 'center-block'));
        $text .= html_writer::end_tag('div');
        return $text;

    }

    /**
     * Display prerequesites zone
     * @param type $extendedcourse
     * @return html_writer::tag
     */
    private function display_prerequesites($extendedcourse) {

        $text = html_writer::start_tag('div', array('class' => 'header'));
            $text .= html_writer::tag('h2', get_string('prerequesites', 'format_flexpage'));
        $text .= html_writer::end_tag('div');

        $text .= html_writer::start_tag('div', array('class' => 'content'));
            $text .= html_writer::start_tag('div', array('class' => 'col-xs-1'));
                $text .= html_writer::tag('span', '');
            $text .= html_writer::end_tag('div');
            $prerequesites = $extendedcourse->prerequesites;
            $text .= html_writer::tag('span', $prerequesites, array('class' => 'center-block'));
        $text .= html_writer::end_tag('div');
        return $text;
    }

    /**
     * Display enrolledusers zone
     * @param type $extendedcourse
     * @return html_writer::tag
     */
    private function display_enrolledusers($extendedcourse) {

        $text = html_writer::start_tag('div', array('class' => 'col-xs-2 col-md-2'));
            $text .= html_writer::tag('span', '', array('class' => 'col-xs-2 glyphicon glyphicon-user '));
        $text .= html_writer::end_tag('div');

        $text .= html_writer::start_tag('div', array('class' => 'col-xs-10 col-md-10'));
            $text .= html_writer::tag('span', get_string('registeredusers', 'format_flexpage'), array('class' => 'h6'));
            $text .= html_writer::tag('span', $extendedcourse->enrolledusers.' ', array('class' => 'center-block'));
        $text .= html_writer::end_tag('div');
        return $text;
    }

    /**
     * Display registration zone
     * @param type $extendedcourse
     * @return html_writer::tag
     */
    private function display_registration($extendedcourse) {

        $text = html_writer::start_tag('div', array('class' => 'col-xs-2 col-md-2'));
            $text .= html_writer::tag('span', '', array('class' => 'col-xs-2 glyphicon glyphicon-lock'));
        $text .= html_writer::end_tag('div');
        $text .= html_writer::start_tag('div', array('class' => 'col-xs-10 col-md-10'));
            $text .= html_writer::tag('span', get_string('registration', 'format_flexpage'), array('class' => 'h6'));
            $text .= html_writer::tag('span', $this->get_registration($extendedcourse).' ', array('class' => 'center-block'));
        $text .= html_writer::end_tag('div');
        return $text;
    }

    /**
     * Display startdate and  enddate
     * @param type $extendedcourse
     * @param type $course
     * @return html_writer::tag
     */
    private function display_extendedcourse_dates($extendedcourse, $course) {

        $text = html_writer::start_tag('div', array('class' => 'col-xs-2 col-md-2'));
            $text .= html_writer::tag('span', '', array('class' => 'col-xs-2 glyphicon glyphicon-calendar'));
        $text .= html_writer::end_tag('div');

        $text .= html_writer::start_tag('div', array('class' => 'col-xs-10 col-md-10'));
            $text .= html_writer::tag('span', get_string('startdate', 'format_flexpage'), array('class' => 'h6'));
            $text .= html_writer::tag('span', date("d-m-Y", $course->startdate), array('class' => 'center-block'));
            $text .= html_writer::tag('span', get_string('enddate', 'format_flexpage'), array('class' => 'h6'));
            $enddate = $extendedcourse->enddate;
            $text .= html_writer::tag('span', date("d-m-Y", $enddate), array('class' => 'center-block'));
        $text .= html_writer::end_tag('div');
        return $text;
    }

    /**
     * Display duration and  workingtime
     * @param type $extendedcourse
     * @return html_writer::tag
     */
    private function display_duration_workingtime($extendedcourse) {

        $text = html_writer::start_tag('div', array('class' => 'col-xs-2 col-md-2'));
            $text .= html_writer::tag('span', '', array('class' => 'col-xs-2 glyphicon glyphicon-time'));
        $text .= html_writer::end_tag('div');

        $text .= html_writer::start_tag('div', array('class' => 'col-xs-10 col-md-10'));
            $text .= html_writer::tag('span', get_string('duration', 'format_flexpage'), array('class' => 'h6'));
            $text .= html_writer::tag('span', $extendedcourse->duration.' ', array('class' => 'center-block'));
            $text .= html_writer::tag('span', get_string('workingtime', 'format_flexpage'), array('class' => 'h6'));
            $text .= html_writer::tag('span', $extendedcourse->workingtime, array('class' => 'center-block'));
        $text .= html_writer::end_tag('div');
        return $text;
    }

    /**
     * Display price
     * @param type $extendedcourse
     * @return html_writer::tag
     */
    private function display_price($extendedcourse) {

        $text = html_writer::start_tag('div', array('class' => 'col-xs-2 col-md-2'));
            $text .= html_writer::tag('span', '', array('class' => 'col-xs-2 glyphicon glyphicon-euro'));
        $text .= html_writer::end_tag('div');

        $text .= html_writer::start_tag('div', array('class' => 'col-xs-10 col-md-10'));
            $text .= html_writer::tag('span', get_string('price', 'format_flexpage'), array('class' => 'h6'));
            $text .= html_writer::tag('span', $extendedcourse->price.' ', array('class' => 'center-block'));
        $text .= html_writer::end_tag('div');
        return $text;
    }

    /**
     * Display certification and  badges
     * @param type $extendedcourse
     * @return html_writer::tag
     */
    private function display_badge_certif($extendedcourse) {

        $text = html_writer::start_tag('div', array('class' => 'col-xs-2 col-md-2'));
            $text .= html_writer::tag('span', '', array('class' => 'col-xs-2 glyphicon glyphicon-education'));
        $text .= html_writer::end_tag('div');

        $text .= html_writer::start_tag('div', array('class' => 'col-xs-10 col-md-10'));
            $text .= html_writer::tag('span', get_string('certification', 'format_flexpage'), array('class' => 'h6'));
            $text .= html_writer::tag('span', $extendedcourse->badge.' ',
                array('class' => 'center-block'));
            $text .= html_writer::tag('span', $extendedcourse->certification.' ',
                array('class' => 'center-block'));
        $text .= html_writer::end_tag('div');
        return $text;
    }

    /**
     * Display language
     * @param type $extendedcourse
     * @return html_writer::tag
     */
    private function display_language($extendedcourse) {

        $text = html_writer::start_tag('div', array('class' => 'col-xs-2 col-md-2'));
            $text .= html_writer::tag('span', '', array('class' => 'col-xs-2 glyphicon glyphicon-globe'));
        $text .= html_writer::end_tag('div');

        $text .= html_writer::start_tag('div', array('class' => 'col-xs-10 col-md-10'));
            $text .= html_writer::tag('span', get_string('language', 'format_flexpage'), array('class' => 'h6'));
            $text .= html_writer::tag('span', $extendedcourse->language.' ', array('class' => 'center-block'));
        $text .= html_writer::end_tag('div');
        return $text;
    }

    /**
     * Display video and subtitle
     * @param type $extendedcourse
     * @return html_writer::tag
     */
    private function display_video($extendedcourse) {
        global $USER;

        $text = html_writer::start_tag('div', array('class' => 'col-xs-2 col-md-2'));
            $text .= html_writer::tag('span', '', array('class' => 'col-xs-2 glyphicon glyphicon-film'));
        $text .= html_writer::end_tag('div');

        $text .= html_writer::start_tag('div', array('class' => 'col-xs-10 col-md-10'));
            $text .= html_writer::tag('span', get_string('video', 'format_flexpage'), array('class' => 'h6'));
        if ($extendedcourse->subtitle != 0) {
            $language = $extendedcourse->language;
            if ($USER->lang == 'fr') {
                $text .= html_writer::tag('span', get_string('subtitle', 'block_orange_course_extended').' '.$language,
                    array('class' => 'center-block'));
            } else {
                $text .= html_writer::tag('span', $language . ' '. get_string('subtitle', 'block_orange_course_extended'),
                    array('class' => 'center-block'));
            }
        }
        $text .= html_writer::end_tag('div');
        return $text;
    }

    /**
     *  Set the extended course registration values from the extended course registration.
     *
     * @param object $extendedcourse
     * @return object $this->extendedcourse
     */
    private function get_registration ($extendedcourse) {
        global $course;

        $enrols = enrol_get_plugins(true);
        $enrolinstances = enrol_get_instances($course->id, true);
        $instance = null;
        $registrationstring = "";

        foreach ($enrolinstances as $instance) {
            if (!isset($enrols[$instance->enrol])) {
                continue;
            }
        }
        if ($instance != null) {
            if ($instance->enrolstartdate == 0) {
                $registrationstring = "";
                $extendedcourse->enrolstartdate = time();
                $extendedcourse->enrolenddate = time();
            } else {
                $extendedcourse->enrolstartdate = $instance->enrolstartdate;
                $extendedcourse->enrolenddate = $instance->enrolenddate;
                $registrationstring = get_string('registration_from', 'block_orange_course_extended').
                        date("d-m-Y", $extendedcourse->enrolstartdate).get_string('registration_to',
                                'block_orange_course_extended').
                        date("d-m-Y", $extendedcourse->enrolenddate);
            }
        } else {
            $registrationstring = "";
        }
        switch ($extendedcourse->registration) {
            case '0':
                $registrationvalue = get_string('registration_case1', 'block_orange_course_extended').$registrationstring;
            break;
            case '1':
                $registrationvalue = get_string('registration_case2', 'block_orange_course_extended').
                $extendedcourse->maxregisteredusers.' '.
                get_string('registration_case2_2', 'block_orange_course_extended').$registrationstring;
            break;
            case '2':
                $registrationvalue = get_string('registration_case3', 'block_orange_course_extended').
                $extendedcourse->registrationcompany.$registrationstring;
            break;
        }
        return $registrationvalue;
    }
}