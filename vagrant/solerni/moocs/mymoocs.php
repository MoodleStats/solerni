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

require_once(dirname(dirname(__FILE__)) . '/config.php');
require_once($CFG->dirroot.'/blocks/course_overview/locallib.php');

$filter = optional_param('filter', utilities_course::MOOCRUNNING, PARAM_INT);

require_login();

$url = new moodle_url('/moocs/mymoocs.php');
$PAGE->set_url($url);

$context = context_user::instance($USER->id);

$PAGE->set_context($context);

$title = get_string('titlefollowedcourses', 'block_orange_course_dashboard');
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_pagelayout('mydashboard');
$PAGE->set_pagetype('moocs-mymoocs');

echo $OUTPUT->header();

$courserenderer = $PAGE->get_renderer('core', 'course');
echo $courserenderer->print_my_moocs($filter);

echo $OUTPUT->footer();
