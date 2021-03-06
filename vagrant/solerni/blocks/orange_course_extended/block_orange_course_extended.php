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
require_once($CFG->dirroot.'/blocks/orange_course_extended/locallib.php');
require_once($CFG->dirroot.'/config.php');

use local_orange_library\enrollment;
use local_orange_library\utilities\utilities_image;


/**
 * Course contents block generates a table of course contents based on the
 * section descriptions
 */
class block_orange_course_extended extends block_base {

    public function has_config() {
        return false;
    }

    /**
     * Initializes the block, called by the constructor
     */
    public function init() {
        Global $PAGE;
        $this->title = get_string('pluginname', 'block_orange_course_extended');
        $this->extendedcourse = new stdClass();
        $this->renderer = $PAGE->get_renderer('block_orange_course_extended');
    }

    public function hide_header() {
        return false;
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
        $attributes['class'] .= '';// Append our class to class attribute.
        return $attributes;
    }

    public function instance_allow_multiple() {
        return false;
    }

    /**
     * Amend the block instance after it is loaded
     */
    public function specialization() {
        global $course;

        if (!empty($this->config->config_userfile)) {
            $this->title = $this->config->config_userfile;
        } else {
            $this->title = get_string('userfile_default', 'block_orange_course_extended');
        }
        if (!empty($course->fullname)) {
            $this->title = $course->fullname;
        } else {
            $this->title = get_string('blocktitle_default', 'block_orange_course_extended');
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
            $this->duration = get_string('duration_default', 'block_orange_course_extended');
        }
        if (!empty($this->config->workingtime)) {
            $this->workingtime = date($this->config->workingtime);
        } else {
            $this->workingtime = get_string('workingtime_default', 'block_orange_course_extended');
        }
        if (!empty($this->config->price)) {
            $this->price = $this->config->price;
        } else {
            $this->price = get_string('price_default', 'block_orange_course_extended');
        }
        if (!empty($this->config->badge)) {
            $this->badge = $this->config->badge;
        } else {
            $this->badge = get_string('badge_default', 'block_orange_course_extended');
        }
        if (!empty($this->config->certification)) {
            $this->certification = $this->config->certification;
        } else {
            $this->certification = get_string('certification_default', 'block_orange_course_extended');
        }
        if (!empty($this->config->language)) {
            $this->language = $this->config->language;
        } else {
            $this->language = $this->page->course->lang;
        }
        if (!empty($this->config->subtitle)) {
            $this->subtitle = $this->config->subtitle;
        } else {
            $this->subtitle = false;
        }
        if (!empty($this->config->registration_startdate)) {
            $this->registration_startdate = date($this->config->registration_startdate);
        } else {
            $this->registration_startdate = date("d-m-Y");
        }
        if (!empty($this->config->registrationcompany)) {
            $this->registrationcompany = $this->config->registrationcompany;
        } else {
            $this->registration_startdate = get_string('registrationcompany', 'block_orange_course_extended');
        }
        if (!empty($this->config->registration_enddate)) {
            $this->registration_enddate = date($this->config->registration_enddate);
        } else {
            $this->registration_enddate = date("d-m-Y");
        }
        if (!empty($this->config->registredusers)) {
            $this->registredusers = $this->config->registredusers;
        } else {
            $this->registredusers = get_string('registeredusers_default', 'block_orange_course_extended');
        }
        if (!empty($this->config->prerequesites)) {
            $this->prerequesites = $this->config->prerequesites;
        } else {
            $this->prerequesites = get_string('prerequesites_default', 'block_orange_course_extended');
        }
        if (!empty($this->config->teachingteam)) {
            $this->teachingteam = $this->config->teachingteam;
        } else {
            $this->teachingteam = get_string('teachingteam_default', 'block_orange_course_extended');
        }
        if (!empty($this->config->userfile)) {
            $this->userfile = $this->config->userfile;
        } else {
            $this->userfile = get_string('userfile_default', 'block_orange_course_extended');
        }

    }

    /**
     * Populate this block's content object
     * @return stdClass block content info
     */
    public function get_content() {

        if (!is_null($this->content)) {
            return $this->content;
        }
        $this->content = new stdClass();
        $this->content->text   = '';

        if (empty($this->instance)) {
            return $this->content;
        }

        $course = $this->page->course; // Needed to have numsections property available.
        $context = context_course::instance($course->id);
        $file = utilities_image::get_moodle_stored_file($context, 'format_flexpage', 'coursepicture');
        $imgurl = utilities_image::get_moodle_url_from_stored_file($file);

        $text = $this->renderer->get_text($imgurl, $course, $context);
        $this->content->text = $text;
        return $this->content;

    }


}