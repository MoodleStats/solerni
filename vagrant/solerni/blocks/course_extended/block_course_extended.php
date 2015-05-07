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

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/course/lib.php');
require_once($CFG->dirroot.'/course/format/lib.php');
require_once($CFG->dirroot.'/blocks/course_extended/locallib.php');

/**
 * Course contents block generates a table of course contents based on the
 * section descriptions
 */
class block_course_extended extends block_base {

    private $extendedcourse;

    public function has_config() {
        return true;
    }

    /**
     * Initializes the block, called by the constructor
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_course_extended');
        $this->extendedcourse = new stdClass();

    }

    public function hide_header() {
        return true;
    }
    public function applicable_formats() {
        return array(
                 'site-index' => false,
                'course-view' => true,
         'course-view-social' => true,
                        'mod' => true,
                   'mod-quiz' => true
        );
    }

    public function html_attributes() {
        $attributes = parent::html_attributes(); // Get default values.
        $attributes['class'] .= ' block_'. $this->name(); // Append our class to class attribute.
        return $attributes;
    }

    public function instance_allow_multiple() {
        return false;
    }

    public function instance_config_save($data, $nolongerused = false) {
        return parent::instance_config_save($data, $nolongerused);
    }

    /**
     * Amend the block instance after it is loaded
     */
    public function specialization() {

        if (!empty($this->config->config_userfile)) {
            $this->title = $this->config->config_userfile;
        } else {
            $this->title = get_string('userfile_default', 'block_course_extended');
        }
        if (!empty($this->config->blocktitle)) {
            $this->title = $this->config->blocktitle;
        } else {
            $this->title = get_string('blocktitle_default', 'block_course_extended');
        }
        if (!empty($this->config->enddate)) {
            $this->enddate = date($this->config->enddate);
        } else {
            $this->enddate = date("Y-m-d");
        }
        if (!empty($this->config->startdate)) {
            $this->startdate = date($this->config->startdate);
        } else {
            $this->startdate = date("Y-m-d");
        }
        if (!empty($this->config->duration)) {
            $this->duration = date($this->config->duration);
        } else {
            $this->duration = "in_four_weeks";
        }
        if (!empty($this->config->workingtime)) {
            $this->workingtime = date($this->config->workingtime);
        } else {
            $this->workingtime = "inf_one";
        }
        if (!empty($this->config->price)) {
            $this->price = $this->config->price;
        } else {
            $this->price = 0;
        }
        if (!empty($this->config->certification)) {
            $this->certification = $this->config->certification;
        } else {
            $this->certification = 0;
        }
        if (!empty($this->config->language)) {
            $this->language = $this->config->language;
        } else {
            $this->language = $this->page->course->lang;
        }
        if (!empty($this->config->video)) {
            $this->video = $this->config->video;
        } else {
            $this->video = false;
        }
        if (!empty($this->config->registration_startdate)) {
            $this->registration_startdate = date($this->config->registration_startdate);
        } else {
            $this->registration_startdate = date("d-m-Y");
        }
        if (!empty($this->config->registration_enddate)) {
            $this->registration_enddate = date($this->config->registration_enddate);
        } else {
            $this->registration_enddate = date("d-m-Y");
        }
        if (!empty($this->config->registredusers)) {
            $this->registredusers = $this->config->registredusers;
        } else {
            $this->registredusers = get_string('registeredusers_default', 'block_course_extended');
        }
        if (!empty($this->config->prerequesites)) {
            $this->prerequesites = $this->config->prerequesites;
        } else {
            $this->prerequesites = get_string('prerequesites_default', 'block_course_extended');
        }
        if (!empty($this->config->teachingteam)) {
            $this->teachingteam = $this->config->teachingteam;
        } else {
            $this->teachingteam = get_string('teachingteam_default', 'block_course_extended');
        }
        if (!empty($this->config->userfile)) {
            $this->userfile = $this->config->userfile;
        } else {
            $this->userfile = get_string('userfile_default', 'block_course_extended');
        }

    }

    /**
     * Populate this block's content object
     * @return stdClass block content info
     */
    public function get_content() {

        global $DB;
        if (!is_null($this->content)) {
            return $this->content;
        }
        $this->content = new stdClass();
        $this->content->text   = '';

        if (empty($this->instance)) {
            return $this->content;
        }

        $course = $this->page->course; // Needed to have numsections property available.
        $courseid = $course->id;
        $context = context_course::instance($course->id);
        $fs = get_file_storage();
        $files = $fs->get_area_files($context->id, 'format_flexpage', 'coursepicture', 0);
        $imgurl = '';
        foreach ($files as $file) {
            $ctxid = $file->get_contextid();
            $cmpnt = $file->get_component();
            $filearea = $file->get_filearea();
            $itemid = $file->get_itemid();
            $filepath = $file->get_filepath();
            $filename = $file->get_filename();
            $imgurl = moodle_url::make_pluginfile_url($ctxid, $cmpnt, $filearea, $itemid, $filepath, $filename);
        }

        // This is the new code.
        if ($courseid) {
            $extendedcourseflexpagevalues = $DB->get_records('course_format_options', array('courseid' => $courseid));
           foreach ($extendedcourseflexpagevalues as $extendedcourseflexpagevalue) {
                if ($extendedcourseflexpagevalue->format== "flexpage"){
                    $this->set_extendedcourse($extendedcourseflexpagevalue, $context);
                }
                else {
                    $this->set_extendedcourse_from_config($context);
                    $imgurl = "/pix/spacer.gif";
                }


            }
        }

        $this->content->text .= html_writer::start_tag('ul');
        $this->content->text .= html_writer::start_tag('li');
        $this->content->text .= html_writer::link('span', $course->fullname);
        $this->content->text .= html_writer::end_tag('li');
        $this->content->text .= html_writer::end_tag('ul');

        $text = $this->text_configuration($imgurl, $course);
        $this->content->text = $text;
        return $this->content;

    }

    /**
     *  Set the dicplayed text in the block.
     *
     * @param object $extendedcourse
     * @param moodle_url $imgurl
     * @param object $course
     * @return string $text
     */
    private function text_configuration($imgurl, $course) {
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
                        $text .= html_writer::tag('span', date("d-m-Y", $this->extendedcourse->enddate), array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__duration'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('duration', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', $this->extendedcourse->duration.' ', array('class' => 'slrn-bold'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', get_string('workingtime', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', $this->extendedcourse->workingtime, array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__price'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('price', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', $this->extendedcourse->price.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__certification'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('certification', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', get_badges_string().' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__language'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('language').':');
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', $course->lang.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__video'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('video', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', $this->extendedcourse->video.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__subscription'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('registration', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', get_string('registration_startdate', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $extcourseregdate = $this->extendedcourse->registration_startdate;
                        $text .= html_writer::tag('span', $extcourseregdate.' ', array('class' => 'slrn-bold'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', get_string('registration_enddate', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $extcourseregenddate = $this->extendedcourse->registration_enddate;
                        $text .= html_writer::tag('span', $extcourseregenddate.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__subscribers'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('registeredusers', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', $this->extendedcourse->enrolledusers.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::tag('span', get_string('status', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', $this->extendedcourse->status.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                $text .= html_writer::end_tag('ul');
            $text .= html_writer::end_tag('div');

        $text .= html_writer::tag('h2', get_string('prerequesites', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
            $text .= html_writer::start_tag('div', array('class' => 'sider__content'));
                $text .= html_writer::start_tag('ul', array('class' => 'essentiels'));
                    $text .= html_writer::start_tag('li');
                    $prerequesites = $this->extendedcourse->prerequesites;
                    $text .= html_writer::tag('span', $prerequesites.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                $text .= html_writer::end_tag('ul');
            $text .= html_writer::end_tag('div');

        $text .= html_writer::tag('h2', get_string('teachingteam', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
            $text .= html_writer::start_tag('div', array('class' => 'sider__content'));
                $text .= html_writer::start_tag('ul', array('class' => 'essentiels'));
                    $text .= html_writer::start_tag('li');
                    $teachingteam = $this->extendedcourse->teachingteam;
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
    private function set_extendedcourse ($extendedcourseflexpagevalue, $context) {

        switch ($extendedcourseflexpagevalue->name) {
            case 'coursestatus':
                $this->extendedcourse->status = $extendedcourseflexpagevalue->value;
                break;
            case 'coursepicture':
                $this->extendedcourse->picture = $extendedcourseflexpagevalue->value;
                break;
            case 'courseenddate':
                $this->extendedcourse->enddate = $extendedcourseflexpagevalue->value;
                break;
            case 'courseworkingtime':
                $this->get_workingtime($extendedcourseflexpagevalue);
                break;
            case 'courseprice':
                $this->extendedcourse->price = $extendedcourseflexpagevalue->value;
                break;
            case 'coursevideo':
                $this->extendedcourse->video = $extendedcourseflexpagevalue->value;
                break;
            case 'courseteachingteam':
                $this->extendedcourse->teachingteam = $extendedcourseflexpagevalue->value;
                break;
            case 'courseprerequesites':
                $this->extendedcourse->prerequesites = $extendedcourseflexpagevalue->value;
                break;
            case 'duration':
                $this->get_duration($extendedcourseflexpagevalue);
                break;
            case 'registration_startdate':
                $this->extendedcourse->registration_startdate = date("Y-m-d", $extendedcourseflexpagevalue->value);
                break;
            case 'registration_enddate':
                $this->extendedcourse->registration_enddate = date("Y-m-d", $extendedcourseflexpagevalue->value);
                break;
        }
        $this->extendedcourse->enrolledusers = count_enrolled_users($context);
    }

    /**
     *  Set the extended course values from the extended course flexpage values.
     *
     * @param object $extendedcourseflexpagevalue
     * @param object $context
     * @return string Section title
     */
    private function get_workingtime ($extendedcourseflexpagevalue) {
        switch ($extendedcourseflexpagevalue->value) {
            case '0':
                $this->extendedcourse->workingtime = get_string('workingtime0', 'format_flexpage');
                break;
            case '1':
                $this->extendedcourse->workingtime = get_string('workingtime1', 'format_flexpage');
                break;
            case '2':
                $this->extendedcourse->workingtime = get_string('workingtime2', 'format_flexpage');
                break;
        }
    }

        /**
     *  Set the extended course values from the extended course flexpage values.
     *
     * @param object $extendedcourseflexpagevalue
     * @param object $context
     * @return string Section title
     */
    private function get_duration ($extendedcourseflexpagevalue) {
        switch ($extendedcourseflexpagevalue->value) {
            case '0':
                $this->extendedcourse->duration = get_string('duration0', 'format_flexpage');
                break;
            case '1':
                $this->extendedcourse->duration = get_string('duration1', 'format_flexpage');
                break;
            case '2':
                $this->extendedcourse->duration = get_string('duration2', 'format_flexpage');
                break;
        }
    }

    /**
     * Set the extended course values from config.
     *
     * @param object $context
     * @return object $extendedcourse
     */
    private function set_extendedcourse_from_config($context) {
            $format = 'd-m-Y';
            $timestamp = time();
        $this->extendedcourse->status = get_string('moocstatus_default', 'block_course_extended');
        $this->extendedcourse->picture = get_string('picture', 'block_course_extended');
        $this->extendedcourse->enddate = $timestamp;
        $this->extendedcourse->workingtime = get_string('workingtime_default', 'block_course_extended');
        $this->extendedcourse->price = get_string('price_default', 'block_course_extended');
        $this->extendedcourse->video = get_string('video_default', 'block_course_extended');
        $this->extendedcourse->teachingteam = get_string('teachingteam', 'block_course_extended');
        $this->extendedcourse->prerequesites = get_string('prerequesites', 'block_course_extended');
        $this->extendedcourse->duration = get_string('duration_default', 'block_course_extended');
        $this->extendedcourse->enrolledusers = count_enrolled_users($context);
        $this->extendedcourse->registration_startdate = date($format, $timestamp);
        $this->extendedcourse->registration_enddate = date($format, $timestamp);
    }

}