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
 * @package    local
 * @subpackage orange_customers
 * @copyright  2015 Orange
* @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

defined('MOODLE_INTERNAL') || die();


function block_course_extended_images() {
    return array(html_writer::tag('img', '', array('alt' => get_string('red', 'block_course_extended'), 'src' => "pix/picture0.gif")),
                html_writer::tag('img', '', array('alt' => get_string('blue', 'block_course_extended'), 'src' => "pix/blue.png")),
                html_writer::tag('img', '', array('alt' => get_string('green', 'block_course_extended'), 'src' => "pix/green.jpeg")));
}
function block_course_extended_print_page($course_extended, $return = false) {
    global $OUTPUT, $COURSE;
    $display = $OUTPUT->heading($course_extended->pagetitle);
    $display .= $OUTPUT->box_start();
    if($course_extended->config_startdate) {
        $display .= userdate($course_extended->config_startdate);
    }
    if($course_extended->config_enddate) {
        $display .= userdate($course_extended->config_enddate);
    }
}
function block_course_extended_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $DB;
       
    if ($context->contextlevel != CONTEXT_COURSE) {
        return false;
    }
    
    require_login();
    if ($filearea != 'coursepicture') {
        return false;
    }
    
    $itemid = (int)array_shift($args);
    if ($itemid != 0) {
        return false;
    }
    
    $fs = get_file_storage();
    $filename = array_pop($args);
    
    if (empty($args)) {
        $filepath = '/';
    } else {
        $filepath = '/'.implode('/', $args).'/';
    }
    
    $file = $fs->get_file($context->id, 'block_course_extended', $filearea, $itemid, $filepath, $filename);
    if (!$file) {
        return false;
    }
    
    send_stored_file($file, 0, 0, $forcedownload, $options);
}