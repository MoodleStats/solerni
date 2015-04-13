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
 * This is built using the bootstrapbase template to allow for new theme's using
 * Moodle's new Bootstrap theme engine
 *
 * @package     theme_solerni
 * @copyright   2015 Orange
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->dirroot . '/course/renderer.php');
require_once($CFG->dirroot . '/cohort/lib.php');

class theme_solerni_core_course_renderer extends core_course_renderer
{
    protected function coursecat_coursebox(coursecat_helper $chelper, $course, $additionalclasses = '') {
        global $CFG;

        // Start code to display only allowed MOOC
        global $DB, $USER;
		
		// By defaut the course is not displayed
		$canview = false;
		// If user is loggedIn and has capability to create course then he can view all courses on the system
		if (isloggedin()) {
                    $usercontext = context_user::instance($USER->id);
                    if (has_capability('moodle/course:create', $usercontext)) {
                        $canview = true;
                    }
		}
		
		if (!$canview) {
                    // Read enrolment method which are active
                    $enrols = $DB->get_records('enrol', array('courseid' => $course->id, 'status'=>0));		
                    foreach ($enrols as $enrol) {
                        // Is self and user in the cohort => display the course, or no cohort set => display the course also
                        if ($enrol->enrol == 'self') {
                            // If a cohort is affected to the course, it is stored in parameter customint5
                            $cohortid = (int)$enrol->customint5;
                            if ($cohortid == 0) {
                                $canview = true;
                            } else {
                                $canview = cohort_is_member($cohortid, $USER->id);
                            }
                        }
                    }
		}
		
		// End code to display only allowed MOOC
		if ($canview) {
                    if (!isset($this->strings->summary)) {
                        $this->strings->summary = get_string('summary');
                    }
                    if ($chelper->get_show_courses() <= self::COURSECAT_SHOW_COURSES_COUNT) {
                        return '';
                    }
                    if ($course instanceof stdClass) {
                        require_once($CFG->libdir. '/coursecatlib.php');
                        $course = new course_in_list($course);
                    }
                    $content = '';
                    $classes = trim('coursebox clearfix '. $additionalclasses);
                    if ($chelper->get_show_courses() >= self::COURSECAT_SHOW_COURSES_EXPANDED) {
                        $nametag = 'h3';
                    } else {
                        $classes .= ' collapsed';
                        $nametag = 'div';
                    }

                    // .coursebox
                    $content .= html_writer::start_tag('div', array(
                                                            'class' => $classes,
                                                            'data-courseid' => $course->id,
                                                            'data-type' => self::COURSECAT_TYPE_COURSE,
                    ));

                    $content .= html_writer::start_tag('div', array('class' => 'info'));

                    // course name
                    $coursename = $chelper->get_course_formatted_name($course);
                    $coursenamelink = html_writer::link(new moodle_url('/course/view.php', array('id' => $course->id)),
                                                                                            $coursename, array('class' => $course->visible ? '' : 'dimmed'));
                    $content .= html_writer::tag($nametag, $coursenamelink, array('class' => 'coursename'));
                    // If we display course in collapsed form but the course has summary or course contacts, display the link to the info page.
                    $content .= html_writer::start_tag('div', array('class' => 'moreinfo'));
                    if ($chelper->get_show_courses() < self::COURSECAT_SHOW_COURSES_EXPANDED) {
                        if ($course->has_summary() || $course->has_course_contacts() || $course->has_course_overviewfiles()) {
                            $url = new moodle_url('/course/info.php', array('id' => $course->id));
                            $image = html_writer::empty_tag('img', array('src' => $this->output->pix_url('i/info'),
                                    'alt' => $this->strings->summary));
                            $content .= html_writer::link($url, $image, array('title' => $this->strings->summary));
                            // Make sure JS file to expand course content is included.
                            $this->coursecat_include_js();
                        }
                    }
                    $content .= html_writer::end_tag('div'); // .moreinfo

                    // print enrolmenticons
                    if ($icons = enrol_get_course_info_icons($course)) {
                        $content .= html_writer::start_tag('div', array('class' => 'enrolmenticons'));
                        foreach ($icons as $pix_icon) {
                                $content .= $this->render($pix_icon);
                        }
                        $content .= html_writer::end_tag('div'); // .enrolmenticons
                    }

                    $content .= html_writer::end_tag('div'); // .info

                    $content .= html_writer::start_tag('div', array('class' => 'content'));
                    $content .= $this->coursecat_coursebox_content($chelper, $course);
                    $content .= html_writer::end_tag('div'); // .content

                    $content .= html_writer::end_tag('div'); // .coursebox
		}
		else $content = '';

        return $content;
    }

}