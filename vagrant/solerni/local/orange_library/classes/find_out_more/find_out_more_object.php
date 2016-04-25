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
 * @package    blocks
 * @subpackage extended_course_object
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_orange_library\find_out_more;

use local_orange_library\extended_course\extended_course_object;
use local_orange_library\utilities\utilities_course;
use local_orange_library\enrollment\enrollment_object;


class find_out_more_object extends extended_course_object{

      /**
     * The find out more page configuration
     */

    /**
     * The find out more page paragraphs title configuration
     */

    /**
     * The array paragraph title.
     * @var array $pragraphtitle
     */
    public $paragraphtitle;

    /**
     * The find out more page paragraphs description configuration
     */

    /**
     * The array paragraph description.
     * @var array $pragraphdescription
     */
    public $paragraphdescription;

    /**
     * The find out more page paragraphs picture configuration
     */

    /**
     * The array paragraph picture.
     * @var array $pragraphpicture1
     */
    public $paragraphpicture;

    /**
     *  Get the extended course values from the extended course flexpage values.
     *
     * @param object $course
     * @param optionnal object $context
     * @return object $this->extendedcourse
     */
    public function get_find_out_more($course, $context = null) {
    global $DB;

        $utilitiescourse = new utilities_course();
        $categoryid = $utilitiescourse->get_categoryid_by_courseid($course->id);
        $customer = customer_get_customerbycategoryid($categoryid);
        $enrolment = new enrollment_object();
        $instanceorangeinvitation = $enrolment->get_orangeinvitation_enrolment($course);
        $instanceself = $enrolment->get_self_enrolment($course);
        $extendedcourseflexpagevalues = $DB->get_records('course_format_options',
                array('courseid' => $course->id));
        foreach ($extendedcourseflexpagevalues as $extendedcourseflexpagevalue) {
            if ($extendedcourseflexpagevalue->format == "flexpage") {
                $this->set_find_out_more($extendedcourseflexpagevalue, $course, $context);
            }
        }
    }

    /**
     *  Set the extended course values from the extended course flexpage values.
     *
     * @param object $extendedcourseflexpagevalue
     * @return object $this->extendedcourse
     */
    protected function set_find_out_more ($extendedcourseflexpagevalue, $course, $context) {

        for ($i=0;$i<=9;$i++) {

            switch ($extendedcourseflexpagevalue->name) {
                case 'paragraph'.($i+1):
                    $this->paragraphtitle[$i] = $extendedcourseflexpagevalue->value;
                    break;
                case 'description'.($i+1):
                    $this->paragraphdescription[$i] = $extendedcourseflexpagevalue->value;
                    break;
                case 'paragraph'.($i+1).'picture':
                    $this->paragraphpicture[$i] = $extendedcourseflexpagevalue->value;
                    break;
                case 'paragraph'.($i+1).'bgcolor':
                    $this->paragraphbgcolor[$i] = $extendedcourseflexpagevalue->value;
                    break;
            }
        }
    }
}
