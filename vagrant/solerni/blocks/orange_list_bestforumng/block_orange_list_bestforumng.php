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
 * Orange List Forumng Best block definition
 *
 * @package    block_orange_list_bestforumng
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot.'/local/orange_library/classes/forumng/forumng_object.php');
require_once($CFG->dirroot.'/blocks/orange_list_bestforumng/lib.php');
require_once($CFG->dirroot.'/mod/forumng/mod_forumng.php');

use local_orange_library\utilities\utilities_course;
use local_orange_library\utilities\utilities_image;
use local_orange_library\extended_course\extended_course_object;

/**
 * Orange List Forumng Best block class
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_orange_list_bestforumng extends block_base {

    /**
     * Sets the block title
     *
     * @return void
     */
    public function init() {
        Global $PAGE;
        $this->title = get_string('pluginname', 'block_orange_list_bestforumng');
        $this->renderer = $PAGE->get_renderer('block_orange_list_bestforumng');
    }

    /**
     *  we have global config/settings data
     *
     * @return bool
     */
    public function has_config() {
        return false;
    }

    public function specialization() {
        $this->title = "";
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
     * Defines where the block can be added
     *
     * @return array
     */
    public function applicable_formats() {
        return array(
            'course-view'    => false,
            'site'           => true,
            'mod'            => false,
            'my'             => false
        );
    }

    /**
     * Creates the blocks main content
     *
     * @return string
     */
    public function get_content() {
        // If content has already been generated, don't waste time generating it again.
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';

        if (empty($this->instance)) {
            return $this->content;
        }

        $filter = new stdClass();
        $filter->statusid = array(1); // Course open.
        $filter->categoriesid = array();
        $filter->thematicsid = array();
        $filter->durationsid = null;
        $options = array();
        $utilitiescourse = new utilities_course();
        $listcourse = utilities_course::get_courses_catalogue($filter, $options);

        $listcourseforuminfo = array();

        foreach ($listcourse as $course) {
            // Get info about last discussion.
            $forumobject = new forumng_object();
            $res = $forumobject->get_recent_discussions($course->id, 0, 1);

            $context = context_course::instance($course->id, MUST_EXIST);
            $extendedcourse = utilities_course::solerni_get_course_infos($course);
            $nbdiscussions = block_orange_list_bestforumng_get_num_discussions($course->id);
            $courseimageurl = utilities_image::get_resized_url($extendedcourse->imgurl,
                    array('w' => 490, 'h' => 357, 'scale' => false));

            if (count($res->posts) >= 1 ) {
                foreach ($res->posts as $post) {
                    $lastpost = mod_forumng_post::get_from_id($post->id, mod_forumng::CLONE_DIRECT);
                    $courseforuminfo = new stdClass();
                    $courseforuminfo->course = $course;
                    $courseforuminfo->extendedcourse = $extendedcourse;
                    $courseforuminfo->lastpost = $lastpost;
                    $courseforuminfo->nbdiscussions = $nbdiscussions;
                    $courseforuminfo->courseimageurl = $courseimageurl;

                    $listcourseforuminfo[] = $courseforuminfo;
                }
            }
        }

        $this->content->text .= $this->renderer->display_list_bestforumng($listcourseforuminfo);

        return $this->content;

    }
}