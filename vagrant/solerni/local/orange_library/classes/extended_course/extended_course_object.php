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
 * @subpackage extended_course_object
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_orange_library\extended_course;

use local_orange_library\utilities\utilities_object;
use local_orange_library\utilities\utilities_course;
use local_orange_library\enrollment\enrollment_object;
require_once($CFG->dirroot.'/local/orange_customers/lib.php');

defined('MOODLE_INTERNAL') || die();


class extended_course_object {

    /**
     * The database table this grade object is stored in
     * @var string $table
     */
    public $table = 'course_format_options';

    /**
     * The end date of a course.
     * @var int $enddate
     */
    public $enddate;

    /**
     * The status of a course.
     * @var int $status
     */
    public $status;

    /**
     * The picture of a course.
     * @var file $picture
     */
    public $picture;

    /**
     * The replay value of a course.
     * @var string $replay
     */
    public $replay;

    /**
     * The duration value of a course.
     * @var int $duration
     */
    public $duration;

    /**
     * The duration value of a course.
     * @var int $workingtime
     */
    public $workingtime;

    /**
     * The badge value of a course.
     * @var boolean $badge
     */
    public $badge;

    /**
     * The certification of a course.
     * @var boolean $certification
     */
    public $certification;

    /**
     * The  price of a course.
     * @var int $price
     */
    public $price;

    /**
     * The language of a course.
     * @var int $language
     */
    public $language;

    /**
     * The video of a course.
     * @var boolean $video
     */
    public $video;

    /**
     * The subtitle of a course.
     * @var boolean $subtitle
     */
    public $subtitle;

    /**
     * The registration of a course.
     * @var string $registration
     */
    public $registration;

    /**
     * The $registrationcompany of a course.
     * @var string $$registrationcompany
     */
    public $registrationcompany;

    /**
     * The $maxregisteredusers of a course.
     * @var int $maxregisteredusers
     */
    public $maxregisteredusers;

    /**
     * The registration start date of a course.
     * @var int $registrationstartdate
     */
    public $registrationstartdate;

    /**
     * The registration end date of a course.
     * @var int $registrationenddate
     */
    public $registrationenddate;

    /**
     * The prerequesites of a course.
     * @var string $prerequesites
     */
    public $prerequesites;

    /**
     * The teachingteam of a course.
     * @var string $teachingteam
     */
    public $teachingteam;

    /**
     * The registration end date of a course.
     * @var int $enrolledusers
     */
    public $enrolledusers;

    /**
     * The contact email of a course.
     * @var int $contactemail
     */
    public $contactemail;

    /**
     *  Get the extended course values from the extended course flexpage values.
     *
     * @param optionnal object $context
     * @param object $course
     * @return object $this->extendedcourse
     */
    public function get_extended_course($course, $context = null) {
        global $DB;

        $utilitiescourse = new utilities_course();
        $categoryid = $utilitiescourse->get_categoryid_by_courseid($course->id);
        $customer = customer_get_customerbycategoryid($categoryid);
        $selfenrolment = new enrollment_object();
        $instance = $selfenrolment->get_self_enrolment($course);

        $extendedcourseflexpagevalues = $DB->get_records('course_format_options',
                array('courseid' => $course->id));
        foreach ($extendedcourseflexpagevalues as $extendedcourseflexpagevalue) {
            if ($extendedcourseflexpagevalue->format == "flexpage") {
                $this->set_extended_course($extendedcourseflexpagevalue);
            }
        }
        if (!$context) {
            $context = context_course::instance($course->id);
        }
        $this->enrolledusers = count_enrolled_users($context);
        if ($customer) {
            $this->registrationcompany = $customer->name;
        }
        $this->enrolledusers = count_enrolled_users($context);
        if (isset($instance->enrolstartdate)) {
            $this->enrolstartdate = $instance->enrolstartdate;
        }
        if (isset($instance->enrolenddate)) {
            $this->enrolenddate = $instance->enrolenddate;
        }
        if (isset($instance->customint3)) {
            $this->maxregisteredusers = $instance->customint3;
        }

    }

    /**
     *  Set the extended course values from the extended course flexpage values.
     *
     * @param object $extendedcourseflexpagevalue
     * @return object $this->extendedcourse
     */
    private function set_extended_course ($extendedcourseflexpagevalue) {

        switch ($extendedcourseflexpagevalue->name) {
            case 'coursereplay':
                if ($extendedcourseflexpagevalue->value == 0) {
                    $this->replay = get_string('replay', 'format_flexpage');
                } else {
                    $this->replay = get_string('notreplay', 'format_flexpage');
                }
                break;
            case 'coursestatus':
                if ($extendedcourseflexpagevalue->value == 0) {
                    $this->status = get_string('current', 'format_flexpage');
                } else if ($extendedcourseflexpagevalue->value == 1) {
                    $this->status = get_string('startingsoon', 'format_flexpage');
                } else {
                    $this->status = get_string('closed', 'format_flexpage');
                }
                break;
            case 'coursepicture':
                $this->picture = $extendedcourseflexpagevalue->value;
                break;
            case 'courseenddate':
                $this->enddate = $extendedcourseflexpagevalue->value;
                break;
            case 'courseworkingtime':
                    $this->workingtime = utilities_object::duration_to_time($extendedcourseflexpagevalue->value);
                break;

            case 'courselanguage':
                if ($extendedcourseflexpagevalue->value == 0) {
                    $this->language = get_string('french', 'format_flexpage');
                } else {
                    $this->language = get_string('english', 'local_orange_library');
                }
                break;
            case 'coursebadge':
                    $this->badge = $extendedcourseflexpagevalue->value;
                break;
            case 'courseprice':
                if ($extendedcourseflexpagevalue->value == 0) {
                    $this->price = get_string('price_case1', 'format_flexpage');
                } else if ($extendedcourseflexpagevalue->value == 1) {
                    $this->price = get_string('price_case2', 'format_flexpage');
                } else {
                    $this->price = get_string('price_case3', 'format_flexpage');
                }
                break;
            case 'coursecertification':
                   $this->certification = $extendedcourseflexpagevalue->value;
                break;
            case 'coursevideo':
                    $this->video = $extendedcourseflexpagevalue->value;
                break;
            case 'coursesubtitle':
                     $this->subtitle = $extendedcourseflexpagevalue->value;
                break;
            case 'courseteachingteam':
                $this->teachingteam = $extendedcourseflexpagevalue->value;
                break;
            case 'courseprerequesites':
                $this->prerequesites = $extendedcourseflexpagevalue->value;
                break;
            case 'courseduration':
                $this->duration =  utilities_object::duration_to_time($extendedcourseflexpagevalue->value);
                break;
            case 'courseregistration':
                $this->registration = $extendedcourseflexpagevalue->value;
                break;
            case 'coursecontactemail':
                $this->contactemail = $extendedcourseflexpagevalue->value;
                break;
        }
    }

    /**
     *  Get the extended course language from the extended course flexpage values.
     *
     * @param object $extendedcourseflexpagevalue
     * @return string $this->extendedcourse->language
     */
    private function get_language ($extendedcourseflexpagevalue) {
        $this->extendedcourse->language = get_string('french', 'local_orange_library');
        if ($extendedcourseflexpagevalue->value == 0) {
            $this->extendedcourse->language = get_string('french', 'local_orange_library');
        } else {
            $this->extendedcourse->language = get_string('english', 'local_orange_library');
        }
        return $this->extendedcourse->language;
    }

}
