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
 * Page module view
 *
 * @package mod
 * @subpackage descriptionpage
 * @copyright  2015 Orange based on mod_page plugin from 2009 Petr Skoda (http://skodak.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require('../../config.php');
require_once($CFG->dirroot.'/mod/descriptionpage/locallib.php');
require_once($CFG->libdir.'/completionlib.php');
use local_orange_library\subscription_button\subscription_button_object;
use local_orange_library\extended_course\extended_course_object;

$id      = optional_param('id', 0, PARAM_INT); // Course Module ID.
$courseid      = optional_param('courseid', 0, PARAM_INT); // Course Module ID.
$p       = optional_param('p', 0, PARAM_INT);  // Page instance ID.
$inpopup = optional_param('inpopup', 0, PARAM_BOOL);

if ($p) {
    if (!$descriptionpage = $DB->get_record('descriptionpage', array('id' => $p))) {
        print_error('invalidaccessparameter');
    }
    $cm = get_coursemodule_from_instance('descriptionpage', $descriptionpage->id, $descriptionpage->course, false, MUST_EXIST);
    $course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);

} else if ($courseid) {
    $course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
    $timestamp = 0;
    $descriptionpageid = null;
    $descriptionpages = $DB->get_records('descriptionpage', array('course' => $courseid));
    foreach ($descriptionpages as $descriptionpage) {
        if ($timestamp < $descriptionpage->timemodified) {
            $timestamp = $descriptionpage->timemodified;
            $descriptionpageid = $descriptionpage->id;
        }
    }
        $descriptionpage = $DB->get_record('descriptionpage', array('id' => $descriptionpageid), '*', MUST_EXIST);
        $cm = get_coursemodule_from_instance('descriptionpage', $descriptionpage->id, $descriptionpage->course, false, MUST_EXIST);
} else {
    if (!$cm = get_coursemodule_from_id('descriptionpage', $id)) {
        print_error('invalidcoursemodule');
    }
    $descriptionpage = $DB->get_record('descriptionpage', array('id' => $cm->instance), '*', MUST_EXIST);
    $course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
}

// Require_course_login($course, true, $cm);.
$subscriptionbutton = new subscription_button_object($course);

// ...$page = $PAGE->get_renderer('mod_page');.
$context = context_module::instance($cm->id);
descriptionpage_check_view_permissions($descriptionpage, $context, $cm);

// ...$context = context_module::instance($cm->id);.
require_capability('mod/descriptionpage:view', $context);

// Update 'viewed' state if required by completion system.
require_once($CFG->libdir . '/completionlib.php');
$completion = new completion_info($course);
$completion->set_module_viewed($cm);

$PAGE->set_url('/mod/descriptionpage/view.php', array('id' => $cm->id, 'sesskey' => $USER->sesskey));
//$PAGE->set_pagelayout('base');
$PAGE->blocks->add_region('main');
$options = empty($page->displayoptions) ? array() : unserialize($descriptionpage->displayoptions);

$PAGE->set_title($course->shortname.': '.$descriptionpage->name);
$PAGE->set_heading($course->fullname);
$PAGE->set_activity_record($descriptionpage);

$pct = $descriptionpage->content;
$phpfile = 'pluginfile.php';
$ctxid = $context->id;
$mddesc = 'mod_descriptionpage';
$prev = $descriptionpage->revision;
$contentrewrited = file_rewrite_pluginfile_urls($pct, $phpfile, $ctxid, $mddesc, 'content', $prev);
$formatoptions = new stdClass;
$formatoptions->noclean = true;
$formatoptions->overflowdiv = true;
$formatoptions->context = $context;
$content = format_text($contentrewrited, $descriptionpage->contentformat, $formatoptions);

$filtersblock = new block_contents();
$filtersblock->content .= $content;

$extendedcourse = new extended_course_object();
$extendedcourse->get_extended_course($course, $context);

$filtersblock->content .= '<div class="text-center">'.$subscriptionbutton->set_button($extendedcourse).'</div>';
$filtersblock->footer = '';
$filtersblock->skiptitle = false;

$PAGE->blocks->add_fake_block($filtersblock, 'main');
echo $OUTPUT->header();
if (!isset($options['printheading']) || !empty($options['printheading'])) {
    echo $OUTPUT->heading(format_string($descriptionpage->name), 2);
}

echo $OUTPUT->footer();
