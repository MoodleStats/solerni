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
 * Orange List Forumng Best block renderer
 *
 * @package    block_orange_list_bestforumng
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
use local_orange_library\utilities\utilities_object;
use local_orange_library\utilities\utilities_course;

class block_orange_list_bestforumng_renderer extends plugin_renderer_base {

    /**
     * Display all blocks with data of best forumng in thematic
     *
     * @param $listcourseforuminfo
     * @return string html
     */
    public function display_list_bestforumng($listcourseforuminfo) {

        global $CFG;
        $output = "";

        $output .= html_writer::tag('h2', get_string('title', 'block_orange_list_bestforumng', $CFG->solerni_thematic));
        $output .= html_writer::tag('div', get_string('intro', 'block_orange_list_bestforumng'), array('class' => 'h3'));
        $output .= html_writer::end_tag('div');

        foreach ($listcourseforuminfo as $courseforuminfo) {
            $output .= $this->display_list_bestforumng_course($courseforuminfo->course,
                    $courseforuminfo->extendedcourse,
                    $courseforuminfo->lastpost,
                    $courseforuminfo->nbdiscussions,
                    $courseforuminfo->courseimageurl);
            $output .= html_writer::tag('span', "&nbsp;");
        }

        return $output;
    }


    /**
     * Display block with data of best forumng in course
     *
     * @param object $course Moodle course object
     * @param object $extendedcourse
     * @param object $lastpost mod_forum_post object
     * @param int $nbdiscussions
     * @param string $courseimageurl url of image resized
     * @return string html
     */
    public function display_list_bestforumng_course($course, $extendedcourse, $lastpost, $nbdiscussions, $courseimageurl) {
        global $CFG, $OUTPUT;
        $output = "";

        $output .= html_writer::start_tag('div', array('class' => 'u-inverse'));
            $output .= html_writer::start_tag('div', array('class' => 'row u-row-table'));
                $output .= html_writer::start_tag('div', array('class' => 'col-xs-9 orange-listbestforumng-titlecourse'));
                    $output .= html_writer::tag('span', $course->fullname, array('class' => 'h4'));
                    $output .= html_writer::end_tag('span');
                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'col-xs-3 text-right u-vertical-align'));
                    $output .= html_writer::tag('span', $nbdiscussions , array('class' => 'text-secondary'));
                     $output .= html_writer::tag('span',
                        utilities_object::get_string_plural($nbdiscussions, 'block_orange_list_bestforumng', 'discussion', 'discussions'));

                $output .= html_writer::end_tag('div');
            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        $output .= html_writer::start_tag('div', array('class' => 'row orange-listbestforumng-info'));

            $output .= html_writer::start_tag('div', array('class' => 'col-md-4 orange-listbestforumng-image'));
                $output .= html_writer::empty_tag('img',
                    array('src' => $courseimageurl,
                          'class' => 'img-responsive'));
                $output .= html_writer::start_tag('div', array('class' => 'overpicture'));
                    $output .= html_writer::tag('span', $extendedcourse->enrolledusers
                            . utilities_object::get_string_plural($extendedcourse->enrolledusers, 'block_orange_list_bestforumng', 'registered', 'registeredplural'));
                $output .= html_writer::end_tag('div');
            $output .= html_writer::end_tag('div');

            $output .= html_writer::start_tag('div', array('class' => 'col-md-8 orange-listbestforumng-text'));

                $output .= html_writer::start_tag('div', array('class' => 'row baner-text'));
                    $output .= html_writer::start_tag('div', array('class' => 'col-md-12'));
                        $output .= html_writer::tag('span', get_string('linebestdiscussion', 'block_orange_list_bestforumng'));
                    $output .= html_writer::end_tag('div');
                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'baner-forum'));
                    $output .= html_writer::start_tag('div', array('class' => 'row u-row-table'));

                        $output .= html_writer::start_tag('div', array('class' => 'col-md-6 u-vertical-align'));
                            $output .= html_writer::tag('span', '<strong>' . $lastpost->get_discussion()->get_subject() . '</strong>');
                        $output .= html_writer::end_tag('div');

                        $output .= html_writer::start_tag('div', array('class' => 'col-md-3 u-vertical-align'));
                            $nbposts = $lastpost->get_discussion()->get_num_posts();
                            $output .= html_writer::tag('span', "<strong>" . $nbposts . " </strong>", array('class' => 'text-orange'));
                            $output .= html_writer::tag('span',
                                    utilities_object::get_string_plural($nbposts, 'block_orange_list_bestforumng', 'response', 'responses'));

                        $output .= html_writer::end_tag('div');

                        $output .= html_writer::start_tag('div', array('class' => 'col-md-1 u-vertical-align'));
                            $output .= $OUTPUT->user_picture($lastpost->get_user(), array('class' => ''));
                        $output .= html_writer::end_tag('div');

                        $output .= html_writer::start_tag('div', array('class' => 'col-md-2 u-vertical-align'));
                            $output .= fullname($lastpost->get_user())
                                    . "<br>"
                                    . utilities_object::get_formatted_date_forum($lastpost->get_modified());
                        $output .= html_writer::end_tag('div');

                    $output .= html_writer::end_tag('div');

                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'row baner-text'));
                    $output .= html_writer::start_tag('div', array('class' => 'col-xs-12'));
                        $output .= html_writer::tag('span', get_string('questionunregistered', 'block_orange_list_bestforumng'));
                        $output .= html_writer::link(new moodle_url(utilities_course::get_course_home_url($course->id)),
                                                     get_string('answerunregistered', 'block_orange_list_bestforumng'));
                    $output .= html_writer::end_tag('div');

                    // Get link acces forum of course.
                    $courselinkdescript = utilities_course::get_course_url_page_forum($course->id);
                    if (!is_null($courselinkdescript)) {
                        $output .= html_writer::start_tag('div', array('class' => 'col-xs-12'));
                            $output .= html_writer::tag('span', get_string('questionregistered', 'block_orange_list_bestforumng'));
                            $output .= html_writer::link($courselinkdescript,
                                                 get_string('answerregistered', 'block_orange_list_bestforumng'));
                        $output .= html_writer::end_tag('div');
                    }

                $output .= html_writer::end_tag('div');

            $output .= html_writer::end_tag('div');

        $output .= html_writer::end_tag('div');

        return $output;

    }
}
