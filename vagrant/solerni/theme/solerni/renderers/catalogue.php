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

require_once($CFG->dirroot . '/local/orange_customers/lib.php');

class catalogue {
    public static function solerni_catalogue_get_customer_infos ($catid) {
        global $DB;

        $customer = customer_get_customerbycategoryid ($catid);

        return $customer;
    }

    public static function solerni_catalogue_get_course_infos ($course) {
        global $DB;

        // We get more information only when flexpage format is used.
        if ($course->format == "flexpage") {
            $extendedcourse = new stdClass();
            $courseid = $course->id;
            $context = context_course::instance($course->id);

            $fs = get_file_storage();
            $files = $fs->get_area_files($context->id, 'format_flexpage', 'coursepicture', 0);
            foreach ($files as $file) {
                $ctxid = $file->get_contextid();
                $cmpnt = $file->get_component();
                $filearea = $file->get_filearea();
                $itemid = $file->get_itemid();
                $filepath = $file->get_filepath();
                $filename = $file->get_filename();
                if ($filename != ".") {
                    $extendedcourse->imgurl = moodle_url::make_pluginfile_url($ctxid, $cmpnt, $filearea, $itemid, $filepath, $filename);
                } else {
                    $extendedcourse->imgurl = NULL;
                }
            }

            $category = $DB->get_record('course_categories', array('id' => $course->category));
            $extendedcourse->categoryname = $category->name;

            $extendedcourseflexpagevalues = $DB->get_records('course_format_options', array('courseid' => $courseid));
            foreach ($extendedcourseflexpagevalues as $extendedcourseflexpagevalue) {
                switch ($extendedcourseflexpagevalue->name) {
                    case 'coursepicture':
                        $extendedcourse->picture = $extendedcourseflexpagevalue->value;
                        break;
                    case 'courseenddate':
                        $extendedcourse->enddate = $extendedcourseflexpagevalue->value;
                        break;
                    case 'courseprice':
                        $extendedcourse->price = $extendedcourseflexpagevalue->value;
                        break;
                }
            }

            return $extendedcourse;
        } else {
            return null;
        }
    }
}