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
namespace local_orangelibrary\extendedcourse;


defined('MOODLE_INTERNAL') || die();


class extendedcourse_object {

    /**
     * The database table this grade object is stored in
     * @var string $table
     */
    public $table = 'course_format_options';

    /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */
    //public $required_fields = array('id', 'name', 'value');

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
     *  Get the extended course values from the extended course flexpage values.
     *
     * @param object $context
     * @param object $course
     * @param moodle_url $imgurl
     * @return object $this->extendedcourse
     */
    public function get_extendedcourse ($courseid, $context) {
        global $DB;
        //$data = new extendedcourse_object();

        if ($courseid) {
            $extendedcourseflexpagevalues = $DB->get_records('course_format_options', array('courseid' => $courseid));
            foreach ($extendedcourseflexpagevalues as $extendedcourseflexpagevalue) {
                if ($extendedcourseflexpagevalue->format == "flexpage") {
                    $this->set_extendedcourse($extendedcourseflexpagevalue);
                }
            }
            $this->enrolledusers = count_enrolled_users($context);
        }
    }


    /**
     *  Set the extended course values from the extended course flexpage values.
     *
     * @param object $extendedcourseflexpagevalue
     * @param object $context
     * @param object $extendedcourse
     * @return object $this->extendedcourse
     */
    private function set_extendedcourse ($extendedcourseflexpagevalue) {
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
                    $this->workingtime = $this->durationtotime($extendedcourseflexpagevalue->value);
                break;

            case 'courselanguage':
                if ($extendedcourseflexpagevalue->value == 0) {
                    $this->language = get_string('french', 'format_flexpage');
                } else {
                    $this->language = get_string('english', 'block_course_extended');
                }
                break;
            case 'coursebadge':
                    $this->badge=$extendedcourseflexpagevalue->value;
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
                $this->duration = $this->durationtotime($extendedcourseflexpagevalue->value);
                break;
            case 'courseregistrationcompany':
                    $this->registrationcompany = $extendedcourseflexpagevalue->value;
                break;
            case 'coursemaxregisteredusers':
                    $this->maxregisteredusers = $extendedcourseflexpagevalue->value;
                break;
            case 'courseregistrationstartdate':
                $this->registrationstartdate = $extendedcourseflexpagevalue->value;
                break;
            case 'courseregistrationenddate':
                $this->registrationenddate = $extendedcourseflexpagevalue->value;
                break;
            case 'courseregistration':
                $this->registration = $extendedcourseflexpagevalue->value;
                break;
        }
        //$this->enrolledusers = count_enrolled_users($context);
        //return $this->extendedcourse;
    }
    /**
     *  Set the extended course language from the extended course flexpage values.
     *
     * @param object $extendedcourseflexpagevalue
     * @param object $extendedcourse
     * @return string $this->extendedcourse->language
     */
    private function get_language ($extendedcourseflexpagevalue) {
        $this->extendedcourse->language = get_string('french', 'block_course_extended');
        if ($extendedcourseflexpagevalue->value == 0) {
            $this->extendedcourse->language = get_string('french', 'block_course_extended');
        } else {
            $this->extendedcourse->language = get_string('english', 'block_course_extended');
        }
        return $this->extendedcourse->language;
    }

    public function durationtotime($duration) {
        $secondsinaminute = 60;
        $secondsinanhour = 60 * $secondsinaminute;
        $secondsinaday = 24 * $secondsinanhour;
        $secondsinaweek = 7 * $secondsinaday;

        $weeks = floor($duration / $secondsinaweek);
        // Extract days.
        $dayseconds = $duration % $secondsinaweek;
        $days = floor($dayseconds / $secondsinaday);

        // Extract hours.
        $hourseconds = $duration % $secondsinaday;
        $hours = floor($hourseconds / $secondsinanhour);

        // Extract minutes.
        $minuteseconds = $duration % $secondsinanhour;
        $minutes = floor($minuteseconds / $secondsinaminute);

        // Extract the remaining seconds.
        $remainingseconds = $duration % $secondsinaminute;
        $seconds = ceil($remainingseconds);

        $text = "";

        if ($weeks > 0) {
            $text = $weeks." ".get_string('week', 'block_course_extended'). " ".$text;
        } else if ($days > 0) {
            $text = $days." ".get_string('day', 'block_course_extended'). " ".$text;
        }
        if ($hours > 0) {
            $text = $hours." ".get_string('hour', 'block_course_extended'). " ".$text;
        }
        if ($minutes > 0) {
            $text = $minutes." ".get_string('minute', 'block_course_extended'). " ".$text;
        }
        if ($seconds > 0) {
            $text = $seconds." ".get_string('second', 'block_course_extended'). " ".$text;
        }
        return $text;
    }



}
