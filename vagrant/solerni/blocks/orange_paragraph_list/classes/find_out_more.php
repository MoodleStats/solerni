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
 * orange_paragraph_list library
 *
 * @package    orange_paragraph_list
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace block_orange_paragraph_list;

use local_orange_library\utilities\utilities_image;

class find_out_more {

    /**
     * @var moodle_course $course
     */
    private $course;

    /**
     * @var int $nbitems
     */
    private $nbitems;

    /**
     * @var array $pragraphtitle
     */
    public $paragraphtitle;

    /**
     * @var array $pragraphdescription
     */
    public $paragraphdescription;

    /**
     * @var array $pragraphpicture
     */
    public $paragraphpicture;

    /**
     * @var array $resizedimgurl
     */
    public $resizedimgurl;

    /**
     * Constructor: stores the course object and the expecting number of items.
     *
     * @param moodle_course $course
     * @param int $nbitems
     */
    function __construct($course, $nbitems) {
        $this->course = $course;
        $this->nbitems = $nbitems;
    }

    /**
     * Make a query to get all course format option of this instance course.
     * Then send the filtered values to another method.
     *
     * @global type $DB
     */
    public function get_find_out_more() {
        global $DB;

        $extendedcourseflexpagevalues =
                $DB->get_records('course_format_options',
                                  array('courseid' => $this->course->id));

        foreach ($extendedcourseflexpagevalues as $extendedcourseflexpagevalue) {
            if ($extendedcourseflexpagevalue->format == "flexpage") {
                $this->set_find_out_more($extendedcourseflexpagevalue);
            }
        }
    }

    /**
     *
     * Basically, a filter. Stores flexpage settings values into an object
     * This object will be use by the renderer.
     *
     * @param object $extendedcourseflexpagevalue
     *
     * @return void
     */
    protected function set_find_out_more($extendedcourseflexpagevalue) {

        $defaults = array('w' => 580, 'h' => 430, 'scale' => true);
        for ($i = 1 ; $i <= $this->nbitems; $i++) {

            $file = utilities_image::get_moodle_stored_file(\context_course::instance($this->course->id), 'format_flexpage', 'paragraphpicture', $i);
            if ($file) {
                $this->resizedimgurl[$i] = utilities_image::get_resized_url($file, $defaults);
            } else {
                $this->resizedimgurl[$i] = utilities_image::get_resized_url(null, $defaults); // get a default image.
            }

            switch ($extendedcourseflexpagevalue->name) {
                case 'paragraph'.($i):
                    $this->paragraphtitle[$i] = $extendedcourseflexpagevalue->value;
                    break;
                case 'description'.($i):
                    $this->paragraphdescription[$i] = $extendedcourseflexpagevalue->value;
                    break;
                case 'paragraph'.($i).'bgcolor':
                    $this->paragraphbgcolor[$i] = $extendedcourseflexpagevalue->value;
                    break;
            }
        }
    }
}
