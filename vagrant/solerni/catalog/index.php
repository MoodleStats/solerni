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
 * @package    moodlecore
 * @subpackage catalogue
 * @copyright  Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../config.php');

redirect_if_major_upgrade_required();

$filter = new stdclass();
$filter->thematicsid = optional_param_array('thematicid', array(), PARAM_RAW); // Thematic Id.
$filter->statusid = optional_param_array('statusid', array(), PARAM_RAW); // Course status Id.
$filter->durationsid = optional_param_array('durationid', array(), PARAM_RAW); // Course duration Id.
$filter->categoriesid = optional_param_array('categoryid', array(), PARAM_INT); // Category id.

if ($CFG->forcelogin) {
    require_login();
}

$strcatalog = get_string('configtitle', 'theme_solerni');

if (isguestuser()) {
    // Guests are not allowed, send them to front page.
    if (empty($CFG->allowguestmymoodle)) {
        redirect(new moodle_url('/', array('redirect' => 0)));
    }

    $userid = null;
    $header = "$SITE->shortname: $strmymoodle (GUEST)";

} else {
    $userid = $USER->id;  // Owner of the page.
    $header = "$SITE->shortname: $strcatalog";
}

$context = context_system::instance();  // So we even see non-sticky blocks.

// Start setting up the page.
$params = array();
$PAGE->set_context($context);
$PAGE->set_url('/catalog/index.php', $params);
$PAGE->set_pagelayout('base');
$PAGE->blocks->add_region('side-post');
$PAGE->set_title($header);
$PAGE->requires->js('/lib/jquery/jquery-1.11.0.min.js');
// TODO.
$PAGE->requires->js('/catalog/catalog.js?a='.rand());

$USER->editing = false;


echo $OUTPUT->header();

$courserenderer = $PAGE->get_renderer('core', 'course');

$filters = new block_contents();
$filters->content = $courserenderer->course_catalog_filter_form($filter);
$filters->footer = '';
$filters->skiptitle = true;
echo $OUTPUT->block($filters, 'side-post');

$availablecourseshtml = $courserenderer->catalog_available_courses($filter);
if (!empty($availablecourseshtml)) {

    // TODO-SLP : supprimer l'id.
    echo html_writer::start_tag('div', array('id' => 'frontpage-course-list'));

    echo $OUTPUT->heading(get_string('availablecourses'));
    echo $availablecourseshtml;

    echo html_writer::end_tag('div');
}

echo $OUTPUT->footer();