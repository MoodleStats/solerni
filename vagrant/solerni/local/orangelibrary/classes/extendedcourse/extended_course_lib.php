<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('MOODLE_INTERNAL') || die();

/**
 * Description of extended_course_class
 *
 * @author ajby6350
 */
        /**
     *  Set the extended course values from the extended course flexpage values.
     *
     * @param object $extendedcourseflexpagevalue
     * @param object $context
     * @param object $extendedcourse
     * @return object $this->extendedcourse
     */
    function set_extendedcourse ($extendedcourseflexpagevalue, $context) {
        switch ($extendedcourseflexpagevalue->name) {
            case 'coursereplay':
                if ($extendedcourseflexpagevalue->value == 0) {
                    $this->extendedcourse->replay = get_string('replay', 'format_flexpage');
                } else {
                    $this->extendedcourse->replay = get_string('notreplay', 'format_flexpage');
                }
                break;
            case 'coursestatus':
                if ($extendedcourseflexpagevalue->value == 0) {
                    $this->extendedcourse->status = get_string('current', 'format_flexpage');
                } else if ($extendedcourseflexpagevalue->value == 1) {
                    $this->extendedcourse->status = get_string('startingsoon', 'format_flexpage');
                } else {
                    $this->extendedcourse->status = get_string('closed', 'format_flexpage');
                }
                break;
            case 'coursepicture':
                $this->extendedcourse->picture = $extendedcourseflexpagevalue->value;
                break;
            case 'courseenddate':
                $this->extendedcourse->enddate = $extendedcourseflexpagevalue->value;
                break;
            case 'courseworkingtime':
                    $this->extendedcourse->workingtime = $this->durationtotime($extendedcourseflexpagevalue->value);
                break;

            case 'courselanguage':
                if ($extendedcourseflexpagevalue->value == 0) {
                    $this->extendedcourse->language = get_string('french', 'format_flexpage');
                } else {
                    $this->extendedcourse->language = get_string('english', 'block_course_extended');
                }
                break;
            case 'coursebadge':
                    $this->extendedcourse->badge = $extendedcourseflexpagevalue->value;
                break;
            case 'courseprice':
                if ($extendedcourseflexpagevalue->value == 0) {
                    $this->extendedcourse->price = get_string('price_case1', 'format_flexpage');
                } else if ($extendedcourseflexpagevalue->value == 1) {
                    $this->extendedcourse->price = get_string('price_case2', 'format_flexpage');
                } else {
                    $this->extendedcourse->price = get_string('price_case3', 'format_flexpage');
                }
                break;
            case 'coursecertification':
                   $this->extendedcourse->certification = $extendedcourseflexpagevalue->value;
                break;
            case 'coursevideo':
                    $this->extendedcourse->video = $extendedcourseflexpagevalue->value;
                break;
            case 'coursesubtitle':
                     $this->extendedcourse->subtitle = $extendedcourseflexpagevalue->value;
                break;
            case 'courseteachingteam':
                $this->extendedcourse->teachingteam = $extendedcourseflexpagevalue->value;
                break;
            case 'courseprerequesites':
                $this->extendedcourse->prerequesites = $extendedcourseflexpagevalue->value;
                break;
            case 'courseduration':
                $this->extendedcourse->duration = $this->durationtotime($extendedcourseflexpagevalue->value);
                break;
            case 'courseregistrationcompany':
                    $this->extendedcourse->registrationcompany = $extendedcourseflexpagevalue->value;
                break;
            case 'coursemaxregisteredusers':
                    $this->extendedcourse->registeredusers = $extendedcourseflexpagevalue->value;
                break;
            case 'courseregistrationstartdate':
                $this->extendedcourse->registration_startdate = $extendedcourseflexpagevalue->value;
                break;
            case 'courseregistrationenddate':
                $this->extendedcourse->registration_enddate = $extendedcourseflexpagevalue->value;
                break;
            case 'courseregistration':
                $this->extendedcourse->registration = $extendedcourseflexpagevalue->value;
                break;
        }
        $this->extendedcourse->enrolledusers = count_enrolled_users($context);
        return $this->extendedcourse;
    }
    /**
     *  Set the extended course language from the extended course flexpage values.
     *
     * @param object $extendedcourseflexpagevalue
     * @param object $extendedcourse
     * @return string $this->extendedcourse->language
     */
    function get_language ($extendedcourseflexpagevalue) {
        $this->extendedcourse->language = get_string('french', 'block_course_extended');
        if ($extendedcourseflexpagevalue->value == 0) {
            $this->extendedcourse->language = get_string('french', 'block_course_extended');
        } else {
            $this->extendedcourse->language = get_string('english', 'block_course_extended');
        }
        return $this->extendedcourse->language;
    }

    /**
     *  Get the extended course values from the extended course flexpage values.
     *
     * @param object $context
     * @param object $course
     * @param moodle_url $imgurl
     * @return object $this->extendedcourse
     */
    function get_extendedcourse ($context, $course, $imgurl) {
        global $DB;
        $this->extendedcourse = new stdClass();
        $courseid = $course->id;
        // This is the new code.
        if ($courseid) {
            $extendedcourseflexpagevalues = $DB->get_records('course_format_options', array('courseid' => $courseid));
            foreach ($extendedcourseflexpagevalues as $extendedcourseflexpagevalue) {

                if ($extendedcourseflexpagevalue->format == "flexpage") {
                    $this->extendedcourse = $this->set_extendedcourse($extendedcourseflexpagevalue, $context);
                } else {
                    $this->extendedcourse = $this->set_extendedcourse_from_config($context);
                    $imgurl = "/pix/spacer.gif";
                }
            }
            $this->extendedcourse = $this->get_registration($this->extendedcourse);
        }
        return $this->extendedcourse;
    }

    /**
     *  Set the extended course registration values from the extended course registration.
     *
     * @param object $extendedcourse
     * @return object $this->extendedcourse
     */
    function get_registration () {
        if (!empty($this->extendedcourse->registration)) {
            switch ($this->extendedcourse->registration) {
                case '0':
                    $this->extendedcourse->registrationvalue = get_string('registration_case1', 'block_course_extended').
                    get_string('registration_from', 'block_course_extended').
                    date("d-m-Y", $this->extendedcourse->registration_startdate).
                    get_string('registration_to', 'block_course_extended').
                    date("d-m-Y", $this->extendedcourse->registration_enddate);
                break;
                case '1':
                    $this->extendedcourse->registrationvalue = get_string('registration_case2', 'block_course_extended').
                    $this->extendedcourse->registeredusers.' '.
                    get_string('registration_case2_2', 'block_course_extended').
                    get_string('registration_from', 'block_course_extended').
                    date("d-m-Y", $this->extendedcourse->registration_startdate).
                    get_string('registration_to', 'block_course_extended').
                    date("d-m-Y", $this->extendedcourse->registration_enddate);
                break;
                case '2':

                    $this->extendedcourse->registrationvalue = get_string('registration_case3', 'block_course_extended').
                    $this->extendedcourse->registrationcompany.
                    get_string('registration_from', 'block_course_extended').
                    date("d-m-Y", $this->extendedcourse->registration_startdate).
                    get_string('registration_to', 'block_course_extended').
                    date("d-m-Y", $this->extendedcourse->registration_enddate);
                break;
            }
        }
        return $this->extendedcourse;
    }

    /**
     * Set the extended course values from config.
     *
     * @param object $context
     * @return object $extendedcourse
     * @return object $this->extendedcourse
     */
    function set_extendedcourse_from_config($context) {
        $format = 'd-m-Y';
        $date = new DateTime();
        $timestamp = time();
        $this->extendedcourse->replay = get_string('course_replay_default', 'block_course_extended');
        $this->extendedcourse->status = get_string('moocstatus_default', 'block_course_extended');
        $this->extendedcourse->picture = get_string('picture', 'block_course_extended');
        $this->extendedcourse->enddate = $timestamp;
        $this->extendedcourse->workingtime = get_string('workingtime_default', 'block_course_extended');
        $this->extendedcourse->price = get_string('price_case1', 'block_course_extended');
        $this->extendedcourse->video = get_string('video_default', 'block_course_extended');
        $this->extendedcourse->teachingteam = get_string('teachingteam', 'block_course_extended');
        $this->extendedcourse->prerequesites = get_string('prerequesites', 'block_course_extended');
        $this->extendedcourse->duration = get_string('duration_default', 'block_course_extended');
        $this->extendedcourse->enrolledusers = count_enrolled_users($context);
        $this->extendedcourse->registration_startdate = $date->getTimestamp();
        $this->extendedcourse->registration_enddate = $date->getTimestamp();
        return $this->extendedcourse;
    }

    /**
     * Set the extended course values from config.
     *
     * @param object $context
     * @return object $this->extendedcourse
     */
    function get_nb_users_enrolled_in_course ($course) {
        global $DB;
        $courseid = $course->id;
        $sqlrequest = "SELECT DISTINCT u.id AS userid, c.id AS courseid
        FROM mdl_user u
        JOIN mdl_user_enrolments ue ON ue.userid = u.id
        JOIN mdl_enrol e ON e.id = ue.enrolid
        JOIN mdl_role_assignments ra ON ra.userid = u.id
        JOIN mdl_context ct ON ct.id = ra.contextid AND ct.contextlevel = 50
        JOIN mdl_course c ON c.id = ct.instanceid AND e.courseid = ". $courseid."
        JOIN mdl_role r ON r.id = ra.roleid AND r.shortname = 'student'
        WHERE e.status = 0 AND u.suspended = 0 AND u.deleted = 0
        AND (ue.timeend = 0 OR ue.timeend > NOW()) AND ue.status = 0";
        $enrolledusers = $DB->get_records_sql($sqlrequest);
        $nbenrolledusers = count ($enrolledusers);
        return $nbenrolledusers;

    }

