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
 * Orange_customers front controller
 *
* @package    block
 * @subpackage block_course_extended
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot.'/blocks/course_extended/course_extended_form.php');
require_once($CFG->dirroot.'/blocks/course_extended/locallib.php');
 
global $DB, $OUTPUT, $PAGE;
 
// Check for all required variables.
$courseid = required_param('courseid', PARAM_INT);
$blockid = required_param('blockid', PARAM_INT);


// Next look for optional variables.
$id = optional_param('id', 0, PARAM_INT); 

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'block_course_extended', $courseid);
}
// Access control
require_login($course);
require_capability('moodle/site:config', context_system::instance());

$context = context_system::instance();



// New object or update ?
$extendedcourse = new stdClass();
$extendedcourse = $course;

if ($courseid) {
    $extendedcourseflexpagevalues = $DB->get_records('course_format_options', array('courseid'=>$courseid));
    foreach ($extendedcourseflexpagevalues as $extendedcourseflexpagevalue){
        switch ($extendedcourseflexpagevalue->name) {
            case 'coursestatus':
                $extendedcourse->status = $extendedcourseflexpagevalue->value;
            case 'coursepicture':
                $extendedcourse->picture = $extendedcourseflexpagevalue->value;
            case 'courseenddate':
                $extendedcourse->enddate = $extendedcourseflexpagevalue->value;
            case 'courseworkingtime':
                $extendedcourse->workingtime = $extendedcourseflexpagevalue->value;
            case 'courseprice':
                $extendedcourse->price = $extendedcourseflexpagevalue->value;
            case 'coursevideo':
                $extendedcourse->video = $extendedcourseflexpagevalue->value;
            case 'courseteachingteam':
                $extendedcourse->teachingteam = $extendedcourseflexpagevalue->value;
            case 'courseprerequesites':
                $extendedcourse->prerequesites = $extendedcourseflexpagevalue->value;
            case 'duration':
                $extendedcourse->duration = $extendedcourseflexpagevalue->value;
        }
    }
} else {		
            $extendedcourse->status = get_config('status','block_course_extended');
            $extendedcourse->picture = get_config('picture','block_course_extended');
            $extendedcourse->enddate = get_config('enddate','block_course_extended');
            $extendedcourse->workingtime = get_config('workingtime','block_course_extended');
            $extendedcourse->price = get_config('price','block_course_extended');
            $extendedcourse->video = get_config('video','block_course_extended');
            $extendedcourse->teachingteam = get_config('teachingteam','block_course_extended');
            $extendedcourse->prerequesites = get_config('prerequesites','block_course_extended');
            $extendedcourse->duration = get_config('duration','block_course_extended');
}


$PAGE->set_url('/blocks/course_extended/view.php', array('id' => $courseid));
$PAGE->set_pagelayout('standard');
$PAGE->set_heading(get_string('blocktitle', 'block_course_extended')); 
$PAGE->set_context($context);
$course_extended = new course_extended_form();


$settingsnode = $PAGE->settingsnav->add(get_string('course_extended_settings', 'block_course_extended'));
$editurl = new moodle_url('/blocks/course_extended/view.php', array('id' => $id, 'courseid' => $courseid, 'blockid' => $blockid));
$editnode = $settingsnode->add(get_string('editpage', 'block_course_extended'), $editurl);
$editnode->make_active();
 
$formdata = array('id' => $id); 
$course_extended->set_data($formdata);
$course_extended->set_data($formdata);

$toform['blockid'] = $blockid;
$toform['courseid'] = $courseid;
$course_extended->set_data($toform);
$optionsfilemanager = array(
    'maxfiles' => 1,
    'maxbytes' => $CFG->maxbytes,
    'subdirs' => 0,
    'accepted_types' => 'web_image'
);

//$courseextendedfile = file_prepare_standard_filemanager($course_extended, 'picture', $optionsfilemanager, $context,'block_course_extended','picture',$course_extended->picture);
//print_r($courseextendedfile) ;
if($fromform = $course_extended->is_cancelled()) {
    // Cancelled forms redirect to the course main page.
    $courseurl = new moodle_url('/blocks/course_extended/view.php', array('id' => $id, 'courseid' => $courseid, 'blockid' => $blockid));
    redirect($courseurl);
    
    
} else if ($fromform = $course_extended->get_data()) {
    // We need to add code to appropriately act on and store the submitted data
    // but for now we will just redirect back to the course main page.
    $courseurl = new moodle_url('/blocks/course_extended/view.php', array('id' => $id, 'courseid' => $courseid, 'blockid' => $blockid));
   $draftitemid = file_get_submitted_draft_itemid('picture');
    file_save_draft_area_files($draftitemid, $context->id,'block_course_extended', 'picture', $data->id, $optionsfilemanager );

    //if (!$DB->insert_record('block_course_extended', $fromform, false)) {
    //    print_error('inserterror', 'block_course_extended');
    //}
        redirect($courseurl);

    
} else {
    // form didn't validate or this is the first display
    $site = get_site();
    echo $OUTPUT->header();
    $course_extended->display();
    echo $OUTPUT->footer();
}
