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
 * Displays user my moocs page
 *
 * @package    core
 * @subpackage moocs
 * @copyright  Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use local_orange_library\utilities\utilities_course;
use local_orange_library\extended_course\extended_course_object;
use theme_halloween\tools\theme_utilities;

require_once(dirname(dirname(__FILE__)) . '/config.php');
require_once($CFG->dirroot.'/blocks/course_overview/locallib.php');
require_once($CFG->dirroot.'/blocks/orange_action/block_orange_action.php');
require_once($CFG->dirroot.'/blocks/orange_social_sharing/block_orange_social_sharing.php');
require_once($CFG->dirroot.'/blocks/orange_iconsmap/block_orange_iconsmap.php');
require_once($CFG->dirroot.'/blocks/orange_separator_line/block_orange_separator_line.php');
require_once($CFG->dirroot.'/blocks/orange_action/renderer.php');
require_once($CFG->dirroot.'/blocks/orange_paragraph_list/block_orange_paragraph_list.php');

$filter = optional_param('filter', utilities_course::MOOCRUNNING, PARAM_INT);

$url = new moodle_url('/mooc/view.php');
$courseid = optional_param('courseid', 0, PARAM_INT); // Course Module ID.
// TODO Add sesskey check to edit
$edit   = optional_param('edit', null, PARAM_BOOL);    // Turn editing on and off.

//$PAGE->set_context($context);
$PAGE->set_url($url);
$PAGE->set_pagelayout('course');
$PAGE->set_pagetype('mooc-view');
$PAGE->blocks->add_region('content');
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$PAGE->set_course($course);
$context = \context_course::instance($course->id);
$PAGE->set_context($context);
//$extendedcourse = new extended_course_object();
//$extendedcourse->get_extended_course($course, $context);
$themeutilities = new theme_utilities();

echo $OUTPUT->header();
echo $OUTPUT->custom_block_region('content');
echo $themeutilities->display_button('page_mooc_block', 'bottom-space', $courseid);
echo $themeutilities->display_line('bottom-line-space');
echo '<div class = "bottom-space">';
echo '<span>'.get_string('more_info', 'theme_halloween').'  </span>';
echo '<a href= '.$CFG->wwwroot . '/contact/'.'>'.get_string('contact_us', 'theme_halloween').'</a>';
echo '</div>';

echo $OUTPUT->footer();
