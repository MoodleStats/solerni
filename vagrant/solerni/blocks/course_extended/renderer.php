<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of block_course_extended_renderer
 *
 * @author ajby6350
 */
class block_course_extended_renderer extends plugin_renderer_base {

        /**
     *  Set the dicplayed text in the block.
     *
     * @param object $extendedcourse
     * @param moodle_url $imgurl
     * @param object $course
     * @return string $text
     */
    public function set_button($course){

        $url_mooc_subsription = new moodle_url('/course/view.php', array('id' => $course->id));
        if (!isloggedin()) {
            return html_writer::tag('a', get_string('subscribe_to_mooc', 'block_course_extended'), array('class'=>'btn btn-primary', 'href'=>$url_mooc_subsription));
        } else {
            return html_writer::tag('a', get_string('access_to_mooc', 'block_course_extended'), array('class'=>'btn btn-access', 'href'=>'http://10.194.54.155/login/index.php'));
        }
    }

        /**
     *  Set the dicplayed text in the block.
     *
     * @param object $extendedcourse
     * @param moodle_url $imgurl
     * @param object $course
     * @return string $text
     */
        public function text_configuration($imgurl, $course, $extendedcourse) {
        $text = html_writer::start_tag('div', array('class' => 'sider'));
        if ($imgurl){
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
                        $text .= html_writer::tag('span', date("d-m-Y", $extendedcourse->enddate), array('class' => 'slrn-bold'));
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
                        if (!empty($extendedcourse->badge)||!empty($extendedcourse->certification)){
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__certification'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('certification', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        if (!empty($extendedcourse->badge)){
                        $text .= html_writer::tag('span', get_badges_string().' ', array('class' => 'slrn-bold'));

                        }
                        if (!empty($extendedcourse->certification)){
                        $text .= html_writer::tag('span', $extendedcourse->certification.' ', array('class' => 'slrn-bold'));

                        }
                    $text .= html_writer::end_tag('li');
                        }
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__language'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('language').':');
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', $extendedcourse->language.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                        if (!empty($extendedcourse->video)){
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__video'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('video', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');

                        if (!empty($extendedcourse->subtitle)){
                        $text .= html_writer::tag('span', $extendedcourse->language.' '.$extendedcourse->subtitle.' ', array('class' => 'slrn-bold'));

                        }
                    $text .= html_writer::end_tag('li');
                        }
                        $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__subscription'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('registration', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', $extendedcourse->registrationvalue.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__subscribers'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('registeredusers', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', $extendedcourse->enrolledusers.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                    $text .= $this->set_button($course);
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
     *  Set the extended course values from the extended course flexpage values.
     *
     * @param object $extendedcourseflexpagevalue
     * @param object $context
     * @return string Section title
     */
    public function set_extendedcourse ($extendedcourseflexpagevalue, $context, $extendedcourse) {
        switch ($extendedcourseflexpagevalue->name) {
            case 'coursestatus':
                $extendedcourse->status = $extendedcourseflexpagevalue->value;
                break;
            case 'coursepicture':
                $extendedcourse->picture = $extendedcourseflexpagevalue->value;
                break;
            case 'courseenddate':
                $extendedcourse->enddate = $extendedcourseflexpagevalue->value;
                break;

            case 'courselanguage':
                if ($extendedcourseflexpagevalue->value==0){
                    $extendedcourse->language = get_string('french', 'block_course_extended');
                }
                elseif ($extendedcourseflexpagevalue->value==1) {
                   $extendedcourse->language = get_string('english', 'block_course_extended');
                }
                break;
            case 'courseworkingtime':
                $this->get_workingtime($extendedcourseflexpagevalue, $extendedcourse);
                break;
            case 'courseprice':
                if ($extendedcourseflexpagevalue->value==0){
                    $extendedcourse->price = get_string('price_case1', 'block_course_extended');
                }
                elseif ($extendedcourseflexpagevalue->value==1) {
                   $extendedcourse->price = get_string('price_case2', 'block_course_extended');
                }
                else
                {
                    $extendedcourse->price = get_string('price_case3', 'block_course_extended');
                }
                break;
            case 'coursebadge':
                if (!empty($extendedcourseflexpagevalue->value)){
                    $extendedcourse->badge = get_string('badges', 'block_course_extended');
                }
                break;
            case 'coursecertification':
                if (!empty($extendedcourseflexpagevalue->value)){
                    $extendedcourse->certification = get_string('certification_default', 'block_course_extended');
                }
                break;
            case 'coursevideo':
                if (!empty($extendedcourseflexpagevalue->value)){
                    $extendedcourse->video = $extendedcourseflexpagevalue->value;
                }
                break;
            case 'coursesubtitle':
                if (!empty($extendedcourseflexpagevalue->value)){
                    $extendedcourse->subtitle = get_string('subtitle', 'block_course_extended');
                }
                break;
            case 'courseteachingteam':
                $extendedcourse->teachingteam = $extendedcourseflexpagevalue->value;
                break;
            case 'courseprerequesites':
                $extendedcourse->prerequesites = $extendedcourseflexpagevalue->value;
                break;
            case 'duration':
                $this->get_duration($extendedcourseflexpagevalue, $extendedcourse);
                break;
            case 'registrationcompany':
                if (!empty($extendedcourseflexpagevalue->value)){
                    $extendedcourse->registrationcompany = $extendedcourseflexpagevalue->value;
                }
                break;
            case 'registeredusers':
                if (!empty($extendedcourseflexpagevalue->value)){
                    $extendedcourse->registeredusers = $extendedcourseflexpagevalue->value;
                }
                break;
            case 'registration_startdate':
                $extendedcourse->registration_startdate = date("d-m-Y", $extendedcourseflexpagevalue->value);
                break;
            case 'registration_enddate':
                $extendedcourse->registration_enddate = date("d-m-Y", $extendedcourseflexpagevalue->value);
                break;
            case 'registration':
                $extendedcourse->registration = $extendedcourseflexpagevalue->value;
                break;
        }
        $extendedcourse->enrolledusers = count_enrolled_users($context);
        return $extendedcourse;
    }

    /**
     *  Set the extended course values from the extended course flexpage values.
     *
     * @param object $extendedcourseflexpagevalue
     * @param object $context
     * @return string Section title
     */
    public function getregistration ($extendedcourse) {
        switch ($extendedcourse->registration) {
            case '0':
                $extendedcourse->registrationvalue = get_string('registration_case1', 'block_course_extended').
                    get_string('registration_from', 'block_course_extended').
                    $extendedcourse->registration_startdate.
                    get_string('registration_to', 'block_course_extended').
                    $extendedcourse->registration_enddate;
                break;
            case '1':
                $extendedcourse->registrationvalue = get_string('registration_case2', 'block_course_extended').
                    $extendedcourse->registeredusers.
                    get_string('registration_case2_2', 'block_course_extended').
                    get_string('registration_from', 'block_course_extended').
                    $extendedcourse->registration_startdate.
                    get_string('registration_to', 'block_course_extended').
                    $extendedcourse->registration_enddate;
                break;
            case '2':

                $extendedcourse->registrationvalue = get_string('registration_case3', 'block_course_extended').
                    $extendedcourse->registrationcompany.
                    get_string('registration_from', 'block_course_extended').
                    $extendedcourse->registration_startdate.
                    get_string('registration_to', 'block_course_extended').
                    $extendedcourse->registration_enddate;
                break;
        }
        return $extendedcourse;
    }

    /**
     *  Set the extended course values from the extended course flexpage values.
     *
     * @param object $extendedcourseflexpagevalue
     * @param object $context
     * @return string Section title
     */
    public function get_workingtime ($extendedcourseflexpagevalue, $extendedcourse) {
        switch ($extendedcourseflexpagevalue->value) {
            case '0':
                $extendedcourse->workingtime = get_string('workingtime0', 'format_flexpage');
                break;
            case '1':
                $extendedcourse->workingtime = get_string('workingtime1', 'format_flexpage');
                break;
            case '2':
                $extendedcourse->workingtime = get_string('workingtime2', 'format_flexpage');
                break;
        }
        return $extendedcourse;
    }

    /**
     *  Set the extended course values from the extended course flexpage values.
     *
     * @param object $extendedcourseflexpagevalue
     * @param object $context
     * @return string Section title
     */
    public function get_duration ($extendedcourseflexpagevalue, $extendedcourse) {
        switch ($extendedcourseflexpagevalue->value) {
            case '0':
                $extendedcourse->duration = get_string('duration0', 'format_flexpage');
                break;
            case '1':
                $extendedcourse->duration = get_string('duration1', 'format_flexpage');
                break;
            case '2':
                $extendedcourse->duration = get_string('duration2', 'format_flexpage');
                break;
        }
            return $extendedcourse;
    }

    /**
     * Set the extended course values from config.
     *
     * @param object $context
     * @return object $extendedcourse
     */
    public function set_extendedcourse_from_config($context, $extendedcourse) {
        $format = 'd-m-Y';
        $timestamp = time();
        $extendedcourse->status = get_string('moocstatus_default', 'block_course_extended');
        $extendedcourse->picture = get_string('picture', 'block_course_extended');
        $extendedcourse->enddate = $timestamp;
        $extendedcourse->workingtime = get_string('workingtime_default', 'block_course_extended');
        $extendedcourse->price = get_string('price_case1', 'block_course_extended');
        $extendedcourse->video = get_string('video_default', 'block_course_extended');
        $extendedcourse->teachingteam = get_string('teachingteam', 'block_course_extended');
        $extendedcourse->prerequesites = get_string('prerequesites', 'block_course_extended');
        $extendedcourse->duration = get_string('duration_default', 'block_course_extended');
        $extendedcourse->enrolledusers = count_enrolled_users($context);
        $extendedcourse->registration_startdate = date($format, $timestamp);
        $extendedcourse->registration_enddate = date($format, $timestamp);
        return $extendedcourse;
    }

}
