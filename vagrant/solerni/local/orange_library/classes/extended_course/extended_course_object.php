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
use moodle_url;
require_once($CFG->dirroot.'/local/orange_customers/lib.php');
require_once('course_lib.php');
require_once('registration_lib.php');
require_once('button_renderer.php');
require_once('status_controller.php');


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
     * The workingtime value of a course.
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
     * url enrolment.
     * @var text $enrolurl
     */
    public $enrolurl;

    /**
     * url unrollment.
     * @var text $unenrolurl
     */
    public $unenrolurl;

    /**
     * The $coursestatus of a course.
     * @var text $coursestatus
     */
    public $coursestatus;

    /**
     * The $statuslink of a course.
     * @var text $statuslink
     */
    public $statuslink;

    /**
     * The $statuslinktext of a course.
     * @var text $statuslinktext
     */
    public $statuslinktext;
    /**
     * The $statustext of a course.
     * @var text $statustext
     */
    public $statustext;

    /**
     * The $coursestatustext of a course.
     * @var text $coursestatustext
     */
    public $coursestatustext;

    /**
     * The $registrationstatus of a course.
     * @var text $registrationstatus
     */
    public $registrationstatus;

    /**
     * The $registrationstatustext of a course.
     * @var text $registrationstatustext
     */
    public $registrationstatustext;

    /**
     * The $thumbnailtext of a course.
     * @var int $thumbnailtext
     */
    public $thumbnailtext;

    /**
     * The $enrolledusers of a course.
     * @var int $enrolledusers
     */
    public $enrolledusers;

    /**
     * The $enrolstartdate of a course.
     * @var int $enrolstartdate
     */
    public $enrolstartdate;

    /**
     * The $enrolstartdate of a course.
     * @var int $enrolenddate
     */
    public $enrolenddate;

    /**
     * The $displaybutton of a course.
     * @var int $displaybutton
     */
    public $displaybutton;

    const USERLOGGED        = 4;
    const USERENROLLED      = 5;

    /**
     * The contact email of a course.
     * @var int $contactemail
     */
    public $contactemail;

    /**
     *  Get the extended course values from the extended course flexpage values.
     *
     * @param object $course
     * @param optionnal object $context
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
                $this->set_extended_course($extendedcourseflexpagevalue, $course, $context);
            }
        }
        if (!$context) {
            $context = context_course::instance($course->id);
        }
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
        if (isset($instance->customint2)) {
            $this->enrolurl = $instance->customint2;
        }
        $this->moocurl = new moodle_url('/course/view.php', array('id' => $course->id));
        $this->urlregistration = new moodle_url('/login/signup.php', array('id' => $course->id));
        $this->unenrolurl = $instance->customint2;
        $this->coursestatus = set_course_status($course, $context, $this);

    }

    /**
     *  Set the extended course values from the extended course flexpage values.
     *
     * @param object $extendedcourseflexpagevalue
     * @return object $this->extendedcourse
     */
    private function set_extended_course ($extendedcourseflexpagevalue, $course, $context) {
        switch ($extendedcourseflexpagevalue->name) {
            case 'coursereplay':
                $this->set_replay($extendedcourseflexpagevalue);
                break;
            case 'coursepicture':
                $this->picture = $extendedcourseflexpagevalue->value;
                break;
            case 'courseenddate':
                $this->enddate = $extendedcourseflexpagevalue->value;
                break;
            case 'courseduration':
                $this->set_duration($extendedcourseflexpagevalue);
                break;
            case 'courseworkingtime':
                $this->set_workingtime($extendedcourseflexpagevalue);
                break;
            case 'courselanguage':
                $this->set_language($extendedcourseflexpagevalue);
                break;
            case 'coursebadge':
                $this->set_badge($extendedcourseflexpagevalue);
                break;
            case 'courseprice':
                $this->set_price($extendedcourseflexpagevalue);
                break;
            case 'coursecertification':
                $this->set_certification($extendedcourseflexpagevalue);
                break;
            case 'coursesubtitle':
                $this->subtitle = $extendedcourseflexpagevalue->value;
                break;
            case 'courseteachingteam':
                $this->set_teachingteam($extendedcourseflexpagevalue);
                break;
            case 'courseprerequesites':
                $this->set_prerequisites($extendedcourseflexpagevalue);
                break;
            case 'courseregistration':
                $this->registration = $extendedcourseflexpagevalue->value;
                break;
            case 'coursecontactemail':
                $this->contactemail = trim($extendedcourseflexpagevalue->value);
                break;
            case 'coursethumbnailtext':
                $this->thumbnailtext = $extendedcourseflexpagevalue->value;
                break;
        }
    }

    /**
     * Set course replay parameter.
     *
     * @param object $extendedcourseflexpagevalue
     */
    private function set_replay($extendedcourseflexpagevalue) {
        if ($extendedcourseflexpagevalue->value == 0) {
            $this->replay = get_string('replay', 'local_orange_library');
        } else {
            $this->replay = get_string('notreplay', 'local_orange_library');
        }
    }

    /**
     * Set course duration parameter.
     *
     * @param object $extendedcourseflexpagevalue
     */
    private function set_duration($extendedcourseflexpagevalue) {
        $this->duration = get_string('duration_default', 'local_orange_library');
        if ($extendedcourseflexpagevalue->value != 0) {
            $this->duration = utilities_object::duration_to_time($extendedcourseflexpagevalue->value);
        }
    }

    /**
     * Set course workingtime parameter.
     *
     * @param object $extendedcourseflexpagevalue
     */
    private function set_workingtime($extendedcourseflexpagevalue) {
        $this->workingtime = get_string('workingtime_default', 'local_orange_library');
        if ($extendedcourseflexpagevalue->value != 0) {
            $this->workingtime = utilities_object::duration_to_time($extendedcourseflexpagevalue->value);
        }
    }

    /**
     * Set course language parameter.
     *
     * @param object $extendedcourseflexpagevalue
     */
    private function set_language($extendedcourseflexpagevalue) {
        $this->language = get_string('french', 'local_orange_library');
        if ($extendedcourseflexpagevalue->value == 0) {
            $this->language = get_string('french', 'local_orange_library');
        } else {
            $this->language = get_string('english', 'local_orange_library');
        }
    }

    /**
     * Set course badge parameter.
     *
     * @param object $extendedcourseflexpagevalue
     */
    private function set_badge($extendedcourseflexpagevalue) {
        if ($extendedcourseflexpagevalue->value == 1) {
            $this->badge = get_string('badges', 'local_orange_library');
        } else {
            $this->badge = get_string('badge_default', 'local_orange_library');
        }
    }

    /**
     * Set course price parameter.
     *
     * @param object $extendedcourseflexpagevalue
     */
    private function set_price($extendedcourseflexpagevalue) {
        if ($extendedcourseflexpagevalue->value == 0) {
            $this->price = get_string('price_case1', 'local_orange_library');
        } else if ($extendedcourseflexpagevalue->value == 1) {
            $this->price = get_string('price_case2', 'local_orange_library');
        } else {
            $this->price = get_string('price_case3', 'local_orange_library');
        }
    }

    /**
     * Set course certification parameter.
     *
     * @param object $extendedcourseflexpagevalue
     */
    private function set_certification($extendedcourseflexpagevalue) {
        if ($extendedcourseflexpagevalue->value == 1) {
            $this->certification = get_string('certification', 'local_orange_library');
        } else {
            $this->certification = get_string('certification_default', 'local_orange_library');
        }
    }

    /**
     * Set course teachingteam parameter.
     *
     * @param object $extendedcourseflexpagevalue
     */
    private function set_teachingteam($extendedcourseflexpagevalue) {
        $this->teachingteam = $extendedcourseflexpagevalue->value;
        if ($extendedcourseflexpagevalue->value == "") {
            $this->teachingteam = get_string('teachingteam_default', 'local_orange_library');
        }
    }

    /**
     * Set course prerequesites parameter.
     *
     * @param object $extendedcourseflexpagevalue
     */
    private function set_prerequisites($extendedcourseflexpagevalue) {
        $this->prerequesites = $extendedcourseflexpagevalue->value;
        if ($extendedcourseflexpagevalue->value == "") {
            $this->prerequesites = get_string('prerequesites_default', 'local_orange_library');
        }
    }
}
