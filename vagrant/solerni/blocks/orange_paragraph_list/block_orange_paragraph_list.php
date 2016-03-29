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
 * orange_paragraph_list block
 *
 * @package    block_orange_paragraph_list
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot.'/blocks/orange_paragraph_list/lib.php');
require_once($CFG->dirroot.'/calendar/lib.php');
// Adding requirement to avoid  Class 'block_base' not found.
require_once($CFG->dirroot . '/blocks/moodleblock.class.php');
use local_orange_library\utilities\utilities_course;
use local_orange_library\utilities\utilities_image;
use local_orange_library\find_out_more\find_out_more_object;

class block_orange_paragraph_list extends block_base {

    /**
     * Sets the block title
     *
     * @return void
     */
    public function init() {
        Global $PAGE;

        $this->title = get_string('config_default_title', 'block_orange_paragraph_list');
        $this->renderer = $PAGE->get_renderer('block_orange_paragraph_list');
    }

    /**
     *  we have global config/settings data
     *
     * @return bool
     */
    public function has_config() {
        return true;
    }


    /**
     * Controls whether multiple instances of the block are allowed on a page
     *
     * @return bool
     */
    public function instance_allow_multiple() {
        return false;
    }

    /**
     * Controls whether the block is configurable
     *
     * @return bool
     */
    public function instance_allow_config() {
        return true;
    }

    /**
     * Defines where the block can be added
     *
     * @return array
     */
    public function applicable_formats() {
        return array(
            'course-view'    => true,
            'site'           => false,
            'mod'            => false,
            'my'             => true
        );
    }

    /**
     * Creates the blocks main content
     *
     * @return string
     */
    public function get_content() {
        global $COURSE, $CFG, $DB;

        // If content has already been generated, don't waste time generating it again.
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';

        $findoutmore = new find_out_more_object();
        // TODO-a revoir Guests do not have any progress. Don't show them the block.
        if (!isloggedin() or isguestuser()) {
            return $this->content;
        }

        if (block_orange_paragraph_list_on_course_page()) {
            $course = $COURSE; // Needed to have numsections property available.
            $context = context_course::instance($course->id);
            $imgurl = array();
            $resizedimgurl = array();
            $file = utilities_image::get_moodle_stored_file($context, 'format_flexpage', 'coursepicture');

            $imgurl[0] = utilities_image::get_moodle_url_from_stored_file($file);
            echo $imgurl[0];
            for ($i=0; $i<=9; $i++) {
                $property = 'paragraph' .$i.'picture';
                $file = utilities_image::get_moodle_stored_file($context, 'format_flexpage', $property);

                $imgurl[$i] = utilities_image::get_moodle_url_from_stored_file($file);
            $resizedimgurl[$i] = utilities_image::get_resized_url($imgurl[$i], array('w' => 940, 'h' => 360, 'scale' => false));
                echo $resizedimgurl[$i];
            }
            $this->content->text = $this->renderer->display_on_course_page($COURSE, $findoutmore, $resizedimgurl);
        }


        return $this->content;
    }


    /**
     * Sets block header to be hidden
     *
     * @return bool if true then header will be visible.
     */
    public function hide_header() {
        $config = get_config('block_orange_paragraph_list');
        return !empty($config->hideblockheader);
    }
}
