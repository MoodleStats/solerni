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
if ($CFG->forcelogin) {
    require_login();
}

if (isguestuser() && empty($CFG->allowguestmymoodle)) {
    redirect(new moodle_url('/', array('redirect' => 0)));
}

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/catalog/index.php');
$PAGE->set_pagelayout('base');
$PAGE->blocks->add_region('side-pre');
$PAGE->set_title($SITE->shortname . ' : ' . get_string('catalog_page_title', 'theme_halloween'));
$PAGE->requires->js('/catalog/catalog.js');
$USER->editing = false;

$courserenderer = $PAGE->get_renderer('core', 'course');
$filters = new stdclass();
$filters->thematicsid = optional_param_array('thematicsid', array(), PARAM_RAW);
$filters->statusid = optional_param_array('statusid', array(), PARAM_RAW);
$filters->durationsid = optional_param_array('durationid', array(), PARAM_RAW);
$filters->categoriesid = optional_param_array('categoryid', array(), PARAM_INT);

$filtersblock = new block_contents();
$filtersblock->content = '<form id="coursecatalog" method="POST" class="catalog-filters-form js-catalog-filters">';
$filtersblock->content .= $courserenderer->render_course_catalog_filter_status($filters->statusid);
$filtersblock->content .= $courserenderer->render_course_catalog_filter_thematics($filters->thematicsid);
$filtersblock->content .= $courserenderer->render_course_catalog_filter_duration($filters->durationsid);
$filtersblock->content .= $courserenderer->render_course_catalog_filter_categories($filters->categoriesid);
$filtersblock->content .= '<button class="btn btn-primary btn-block" type="submit">submit</button>';
$filtersblock->content .= '</form>';
$filtersblock->footer = '';
$filtersblock->skiptitle = true;
$PAGE->blocks->add_fake_block($filtersblock, 'side-pre');

echo $OUTPUT->header();
echo html_writer::start_tag('section', array('class' => 'courses-list'));
echo $OUTPUT->heading(get_string('availablecourses'));
echo $courserenderer->catalog_available_courses($filters);
echo html_writer::end_tag('section');
echo $OUTPUT->footer();
