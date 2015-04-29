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
 * @package    block_course_extended
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

    public function has_config() {
        return true;
    }

    /**
     * Initializes the block, called by the constructor
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_course_extended');
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
        return true;
    }

   public function instance_config_save($data, $nolongerused = false) {
        //if (get_config('block_course_extended', 'maxvisibility') == '1') {
        //    $data->text = strip_tags($data->text);
        //}
        // And now forward to the default implementation defined in the parent class.
        return parent::instance_config_save($data, $nolongerused);
    }

 /*       public function instance_config_commit($nolongerused = false){
            print_object($this->config);
            return set_field('block_course_extended','maxvisibility', base64_encode(serialize($this->config)), 'id', $this->instance->id);
        }
  * /
 
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
            $this->registration_startdate = date("Y-m-d");
        }
        if (!empty($this->config->registration_enddate)) {
            $this->registration_enddate = date($this->config->registration_enddate);
        } else {
            $this->registration_enddate = date("Y-m-d");
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

        global $COURSE, $DB;
        if (!is_null($this->content)) {
            return $this->content;
        }
        $this->content = new stdClass();
        $this->content->text   = '';

        if (empty($this->instance)) {
            return $this->content;
        }

        $extendedcourse = new stdClass();
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
                    case 'courseworkingtime':
                        $extendedcourse->workingtime = $extendedcourseflexpagevalue->value;
                        break;
                    case 'courseprice':
                        $extendedcourse->price = $extendedcourseflexpagevalue->value;
                        break;
                    case 'coursevideo':
                        $extendedcourse->video = $extendedcourseflexpagevalue->value;
                        break;
                    case 'courseteachingteam':
                        $extendedcourse->teachingteam = $extendedcourseflexpagevalue->value;
                        break;
                    case 'courseprerequesites':
                        $extendedcourse->prerequesites = $extendedcourseflexpagevalue->value;
                        break;
                    case 'duration':
                        $extendedcourse->duration = $extendedcourseflexpagevalue->value;
                        break;
                    case 'registration_startdate':
                        $extendedcourse->registration_startdate = $extendedcourseflexpagevalue->value;
                        break;
                    case 'registration_enddate':
                        $extendedcourse->registration_enddate = $extendedcourseflexpagevalue->value;
                        break;
                }
                $extendedcourse->enrolledusers = count_enrolled_users($context);

            }
        } else {
                    $extendedcourse->status = get_config('status', 'block_course_extended');
                    $extendedcourse->picture = get_config('picture', 'block_course_extended');
                    $extendedcourse->enddate = get_config('enddate', 'block_course_extended');
                    $extendedcourse->workingtime = get_config('workingtime', 'block_course_extended');
                    $extendedcourse->price = get_config('price', 'block_course_extended');
                    $extendedcourse->video = get_config('video', 'block_course_extended');
                    $extendedcourse->teachingteam = get_config('teachingteam', 'block_course_extended');
                    $extendedcourse->prerequesites = get_config('prerequesites', 'block_course_extended');
                    $extendedcourse->duration = get_config('duration', 'block_course_extended');
                    $extendedcourse->duration = get_config('registration_startdate', 'block_course_extended');
                    $extendedcourse->duration = get_config('registration_enddate', 'block_course_extended');
                    $extendedcourse->enrolledusers = count_enrolled_users($context);
        }

        $this->content->text .= html_writer::start_tag('ul');
        $this->content->text .= html_writer::start_tag('li');
        $this->content->text .= html_writer::link('span', $course->fullname);
        $this->content->text .= html_writer::end_tag('li');
        $this->content->text .= html_writer::end_tag('ul');

        $text = html_writer::start_tag('div', array('class' => 'sider'));
        $text .= html_writer::empty_tag('img', array('src' => $imgurl));

        $text .= html_writer::tag('h2', $course->fullname.' ');
            $text .= html_writer::start_tag('div', array('class' => 'sider__content'));
                $text .= html_writer::start_tag('ul', array('class' => 'essentiels'));
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__date'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('startdate', 'format_flexpage').' ');
                        $text .= html_writer::tag('span', $course->startdate.' ', array('class' => 'slrn-bold'));
                        $text .= html_writer::start_tag('br');
                        $text .= html_writer::end_tag('br');
                        $text .= html_writer::tag('span', get_string('enddate', 'format_flexpage').' ');
                        $text .= html_writer::tag('span', $extendedcourse->enddate.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__duration'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('duration', 'format_flexpage').' ');
                        $text .= html_writer::tag('span', $extendedcourse->duration.' ', array('class' => 'slrn-bold'));
                        $text .= html_writer::start_tag('br');
                        $text .= html_writer::end_tag('br');
                        $text .= html_writer::tag('span', get_string('workingtime', 'format_flexpage').' ');
                        $text .= html_writer::tag('span', $extendedcourse->workingtime.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__price'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('price', 'format_flexpage').' ');
                        $text .= html_writer::tag('span', $extendedcourse->price.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__certification'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('certification', 'format_flexpage').' ');
                        $text .= html_writer::tag('span', get_badges_string().' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__language'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('language'));
                        $text .= html_writer::tag('span', $course->lang.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__video'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('video', 'format_flexpage').' ');
                        $text .= html_writer::tag('span', $extendedcourse->video.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__subscription'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('registration', 'format_flexpage').' ');
                        $text .= html_writer::tag('span', get_string('registration_startdate', 'format_flexpage').' ');
                        $extcourseregdate = $extendedcourse->registration_startdate;
                        $text .= html_writer::tag('span', $extcourseregdate.' ', array('class' => 'slrn-bold'));
                        $text .= html_writer::start_tag('br');
                        $text .= html_writer::end_tag('br');
                        $text .= html_writer::tag('span', get_string('registration_enddate', 'format_flexpage').' ');
                        $text .= html_writer::tag('span', $extendedcourse->registration_enddate.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__subscribers'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('registeredusers', 'format_flexpage').' ');
                        $text .= html_writer::tag('span', $extendedcourse->enrolledusers.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::tag('span', get_string('status', 'format_flexpage').' ');
                        $text .= html_writer::tag('span', $extendedcourse->status.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                $text .= html_writer::end_tag('ul');
            $text .= html_writer::end_tag('div');
        $text .= html_writer::end_tag('h2');

        $text .= html_writer::tag('h2', get_string('prerequesites', 'format_flexpage').' ');
            $text .= html_writer::start_tag('div', array('class' => 'sider__content'));
                $text .= html_writer::start_tag('ul', array('class' => 'essentiels'));
                    $text .= html_writer::start_tag('li');
                    $prerequesites = $extendedcourse->prerequesites;
                    $text .= html_writer::tag('span', $prerequesites.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                     $text .= html_writer::end_tag('li');
                $text .= html_writer::end_tag('ul');
            $text .= html_writer::end_tag('div');
        $text .= html_writer::end_tag('h2');

        $text .= html_writer::tag('h2', get_string('teachingteam', 'format_flexpage').' ');
            $text .= html_writer::start_tag('div', array('class' => 'sider__content'));
                $text .= html_writer::start_tag('ul', array('class' => 'essentiels'));
                    $text .= html_writer::start_tag('li');
                    $teachingteam = $extendedcourse->teachingteam;
                        $text .= html_writer::tag('span', $teachingteam.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                $text .= html_writer::end_tag('ul');
            $text .= html_writer::end_tag('div');
        $text .= html_writer::end_tag('h2');

        $this->content->text = $text;
        return $this->content;

    }

    /**
     * Given a section summary, exctract a text suitable as a section title
     *
     * @param string $summary Section summary as returned from database (no slashes)
     * @return string Section title
     */
    private function extract_title($summary) {
        global $CFG;
        require_once(dirname(__FILE__).'/lib/simple_html_dom.php');

        $node = new simple_html_dom();
        $node->load($summary);
        return $this->node_plain_text($node);
    }


    /**
     * Recursively find the first suitable plaintext from the HTML DOM.
     *
     * Internal private function called only from {@link extract_title()}
     *
     * @param simple_html_dom $node Current root node
     * @return string
     */
    private function node_plain_text($node) {
        if ($node->nodetype == HDOM_TYPE_TEXT) {
            $t = trim($node->plaintext);
            if (!empty($t)) {
                return $t;
            }
        }
        $t = '';
        foreach ($node->nodes as $n) {
            $t = $this->node_plain_text($n);
            if (!empty($t)) {
                break;
            }
        }
        return $t;
    }
}