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

use theme_halloween\tools\theme_utilities;

require_once(dirname(dirname(__FILE__)) . '/config.php');
use local_orange_library\extended_course\extended_course_object;

$courseid = optional_param('courseid', 0, PARAM_INT); // Course ID.
$url = new moodle_url('/mooc/view.php');
$PAGE->set_url($url);
$PAGE->set_pagelayout('course');
$PAGE->set_pagetype('mooc-view');
$PAGE->blocks->add_region('content');
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$PAGE->set_course($course);
$PAGE->set_context(\context_course::instance($course->id));
$PAGE->set_title(get_string('pagetitle', 'block_orange_iconsmap') . $course->fullname);

$extendedcourse = new extended_course_object();
$extendedcourse->get_extended_course($course);

$themeutilities = new theme_utilities();

echo $OUTPUT->header();
echo $OUTPUT->custom_block_region('content');
echo theme_utilities::display_subscription_button($course, 'block_orange_subscription_button');
echo theme_utilities::display_line('block_orange_line');

if (theme_utilities::is_theme_settings_exists_and_nonempty(array('footerlistscolumn2anchor2', 'footerlistscolumn2link2'), 'all')) {
    echo theme_utilities::display_need_more_infos('page_view_more_contact');
}

echo $OUTPUT->footer();
