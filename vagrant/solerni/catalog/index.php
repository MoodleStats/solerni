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
 * My Moodle -- a user's personal dashboard
 *
 * - each user can currently have their own page (cloned from system and then customised)
 * - only the user can see their own dashboard
 * - users can add any blocks they want
 * - the administrators can define a default site dashboard for users who have
 *   not created their own dashboard
 *
 * This script implements the user's view of the dashboard, and allows editing
 * of the dashboard.
 *
 * @package    moodlecore
 * @subpackage my
 * @copyright  2010 Remote-Learner.net
 * @author     Hubert Chathi <hubert@remote-learner.net>
 * @author     Olav Jordan <olav.jordan@remote-learner.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../config.php');
//require_once($CFG->dirroot . '/my/lib.php');

redirect_if_major_upgrade_required();

$filter = new stdclass();
$filter->thematicsid = optional_param('thematicid', 0, PARAM_RAW); // Thematic Id.
$filter->statusid = optional_param('statusid', 0, PARAM_RAW); // Course status Id.
$filter->durationsid = optional_param('durationid', 0, PARAM_RAW); // Course duration Id.
$filter->categoriesid = optional_param_array('categoryid', array(), PARAM_INT); // Category id

//print_r($filter);
if ($CFG->forcelogin) {
    require_login();
}

$strcatalog = get_string('configtitle', 'theme_solerni');

if (isguestuser()) {  
    // guests are not allowed, send them to front page.
    if (empty($CFG->allowguestmymoodle)) {
        redirect(new moodle_url('/', array('redirect' => 0)));
    }

    $userid = null;
    $header = "$SITE->shortname: $strmymoodle (GUEST)";

} else {        
    $userid = $USER->id;  // Owner of the page
    $header = "$SITE->shortname: $strcatalog";
}

$context = context_system::instance();  // So we even see non-sticky blocks

// Start setting up the page
$params = array();
$PAGE->set_context($context);
$PAGE->set_url('/catalog/index.php', $params);
$PAGE->set_pagelayout('mydashboard');
$PAGE->set_pagetype('catalog-index');
$PAGE->blocks->add_region('content');
$PAGE->set_title($header);
$PAGE->set_heading($header);
$PAGE->requires->js('/lib/jquery/jquery-1.11.0.min.js');
$PAGE->requires->js('/catalog/catalog.js?a='.rand());

$USER->editing = FALSE;


echo $OUTPUT->header();

//echo $OUTPUT->custom_block_region('content');
    $courserenderer = $PAGE->get_renderer('core', 'course');

    echo $courserenderer->course_catalog_filter_form($filter);
                $availablecourseshtml = $courserenderer->catalog_available_courses($filter);
                if (!empty($availablecourseshtml)) {

                    //wrap frontpage course list in div container
                    echo html_writer::start_tag('div', array('id'=>'frontpage-course-list'));

                    echo $OUTPUT->heading(get_string('availablecourses'));
                    echo $availablecourseshtml;

                    //end frontpage course list div container
                    echo html_writer::end_tag('div');

                }

echo $OUTPUT->footer();
