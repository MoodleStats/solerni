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

        $subscriptionbutton = new subscription_button_object();
        $text = html_writer::start_tag('div', array('class' => 'sider'));
        $language = get_string('french', 'format_flexpage');
        $registrationvalue = get_string('registration_case1', 'format_flexpage');
        if ($imgurl) {
            $text .= html_writer::empty_tag('img', array('src' => $imgurl));
        }
        $text .= html_writer::tag('h2', $course->fullname.' ');
            $text .= html_writer::start_tag('div', array('class' => 'sider__content'));
                $text .= html_writer::start_tag('ul', array('class' => 'essentiels'));
                   $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__date'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('startdate', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', date("d-m-Y", $course->startdate), array('class' => 'slrn-bold'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', get_string('enddate', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $enddate = $extendedcourse->enddate;
                        $text .= html_writer::tag('span', date("d-m-Y", $enddate), array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__duration'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('duration', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', $extendedcourse->duration.' ', array('class' => 'slrn-bold'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', get_string('workingtime', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', $extendedcourse->workingtime, array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__price'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('price', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', $extendedcourse->price.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
        if (!empty($extendedcourse->badge)||!empty($extendedcourse->certification)) {
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__certification'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('certification', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
            if ($extendedcourse->badge != 0) {
                        $text .= html_writer::tag('span',
                                get_string('badges', 'block_orange_course_extended').' ',
                                array('class' => 'slrn-bold'));
            }
            if ($extendedcourse->certification != 0) {
                        $text .= html_writer::tag('span',
                                get_string('certification_default', 'block_orange_course_extended').' ',
                                array('class' => 'slrn-bold'));
            }
                    $text .= html_writer::end_tag('li');
        }
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__language'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('language').':');
                        $text .= html_writer::empty_tag('br');
        if (!empty($extendedcourse->language)) {
                            $language = $extendedcourse->language;
        }
                        $text .= html_writer::tag('span', $language.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
        if (!empty($extendedcourse->video)) {
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__video'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('video', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
            if ($extendedcourse->subtitle != 0) {
                            $language = $extendedcourse->language;
                            $subtitle = $extendedcourse->subtitle;
                        $text .= html_writer::tag('span',
                                $language.' '.get_string('subtitle', 'block_orange_course_extended').' ',
                                array('class' => 'slrn-bold'));
            }
                    $text .= html_writer::end_tag('li');
        }
                        $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__subscription'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('registration', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $registrationvalue = $this->get_registration($extendedcourse);

                        $text .= html_writer::tag('span', $registrationvalue.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__subscribers'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('registeredusers', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', $extendedcourse->enrolledusers.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                    $text .= $subscriptionbutton->set_button($course);
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', get_string('status', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', $extendedcourse->status.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                $text .= html_writer::end_tag('ul');
            $text .= html_writer::end_tag('div');
        $text .= html_writer::tag('h2', get_string('prerequesites', 'format_flexpage'));
            $text .= html_writer::empty_tag('br');
            $text .= html_writer::start_tag('div', array('class' => 'sider__content'));
                $text .= html_writer::start_tag('ul', array('class' => 'essentiels'));
                    $text .= html_writer::start_tag('li');
                    $prerequesites = $extendedcourse->prerequesites;
                    $text .= html_writer::tag('span', $prerequesites.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                $text .= html_writer::end_tag('ul');
            $text .= html_writer::end_tag('div');
        $text .= html_writer::tag('h2', get_string('teachingteam', 'format_flexpage'));
            $text .= html_writer::empty_tag('br');
            $text .= html_writer::start_tag('div', array('class' => 'sider__content'));
                $text .= html_writer::start_tag('ul', array('class' => 'essentiels'));
                    $text .= html_writer::start_tag('li');
                    $teachingteam = $extendedcourse->teachingteam;
                    $text .= html_writer::tag('span', $teachingteam.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                $text .= html_writer::end_tag('ul');
            $text .= html_writer::end_tag('div');
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

        if (!empty($extendedcourse->registration)) {
            switch ($extendedcourse->registration) {
                case '0':
                    $registrationvalue = get_string('registration_case1', 'block_orange_course_extended').
                    get_string('registration_from', 'block_orange_course_extended').
                    date("d-m-Y", $extendedcourse->enrolstartdate).
                    get_string('registration_to', 'block_orange_course_extended').
                    date("d-m-Y", $extendedcourse->enrolenddate);
                break;
                case '1':
                    $registrationvalue = get_string('registration_case2', 'block_orange_course_extended').
                    $extendedcourse->maxregisteredusers.' '.
                    get_string('registration_case2_2', 'block_orange_course_extended').
                    get_string('registration_from', 'block_orange_course_extended').
                    date("d-m-Y", $extendedcourse->enrolstartdate).
                    get_string('registration_to', 'block_orange_course_extended').
                    date("d-m-Y", $extendedcourse->enrolenddate);
                break;
                case '2':

                    $registrationvalue = get_string('registration_case3', 'block_orange_course_extended').
                    $extendedcourse->registrationcompany.
                    get_string('registration_from', 'block_orange_course_extended').
                    date("d-m-Y", $extendedcourse->enrolstartdate).
                    get_string('registration_to', 'block_orange_course_extended').
                    date("d-m-Y", $extendedcourse->enrolenddate);
                break;
            }
            return $registrationvalue;
        }
    }



}
