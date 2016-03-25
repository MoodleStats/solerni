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

        $output = html_writer::start_tag('div', array('class' => 'row'));

        foreach ($listcourseforuminfo as $courseforuminfo) {
            $output .= $this->display_list_bestforumng_course($courseforuminfo->course,
                    $courseforuminfo->extendedcourse,
                    $courseforuminfo->lastpost,
                    $courseforuminfo->nbdiscussions,
                    $courseforuminfo->courseimageurl);
            $output .= html_writer::tag('span', "&nbsp;");
        }

        $output .= html_writer::end_tag('div');

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

        $output .= html_writer::start_tag('div', array('class' => 'row text-tertiary',
                                                       'style' => 'background-color:black; padding:1% 0% 1% 0%;'));
            $output .= html_writer::start_tag('div', array('class' => 'H4 col-md-9 orange-course-name'));
                $output .= html_writer::tag('span', $course->fullname);
            $output .= html_writer::end_tag('div');

            $output .= html_writer::start_tag('div', array('class' => 'col-md-3 text-right'));
                $output .= html_writer::tag('span', $nbdiscussions , array('class' => 'text-secondary'));
                $output .= html_writer::tag('span', " discussions", array('class' => 'text-tertiary'));
            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        $output .= html_writer::start_tag('div', array('class' => 'row', 'style' => 'border:1px solid black;'));

            $output .= html_writer::start_tag('div', array('class' => 'col-md-4'));
                $output .= html_writer::empty_tag('img',
                    array('src' => $courseimageurl,
                          'alt' => 'image du mooc',
                          'class' => 'col-md-12 essentiels-image',
                          'style' => 'padding:2%;'));
                $output .= html_writer::start_tag('div', array('class' => 'overpicture'));
                    $output .= html_writer::tag('span', $extendedcourse->enrolledusers . " inscrits");
                $output .= html_writer::end_tag('div');
            $output .= html_writer::end_tag('div');

            $output .= html_writer::start_tag('div', array('class' => 'col-md-8', 'style' => 'padding:2%'));
                $output .= html_writer::start_tag('div', array('class' => 'row', 'style' => 'padding: 0% 0% 3% 0%;'));
                    $output .= html_writer::start_tag('div', array('class' => 'col-md-10'));
                        $output .= html_writer::tag('span', get_string('linebestdiscussion', 'block_orange_list_bestforumng'));
                    $output .= html_writer::end_tag('div');
                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'row boxhover'));

                    $output .= html_writer::start_tag('div', array('class' => 'col-md-12 fullwidth-line'));
                    $output .= html_writer::end_tag('div');

                    $output .= html_writer::start_tag('div', array('class' => 'col-md-6'));
                        $output .= html_writer::tag('span', '<strong>' . $lastpost->get_discussion()->get_subject() . '</strong>');
                    $output .= html_writer::end_tag('div');

                    $output .= html_writer::start_tag('div', array('class' => 'col-md-3 text-center'));
                        $output .= html_writer::tag('span', "<strong>"
                                . $lastpost->get_discussion()->get_num_posts()
                                . " </strong>",
                                array('class' => 'text-orange'));
                        $output .= html_writer::tag('span', get_string('responses', 'block_orange_list_bestforumng'));
                    $output .= html_writer::end_tag('div');

                    $output .= html_writer::start_tag('div', array('class' => 'col-md-1 center-block'));
                        $output .= $OUTPUT->user_picture($lastpost->get_user(), array('class' => ''));
                    $output .= html_writer::end_tag('div');

                    $output .= html_writer::start_tag('div', array('class' => 'col-md-2 center-block'));
                        $output .= fullname($lastpost->get_user())
                                . "<br>"
                                . utilities_object::get_formatted_date_forum($lastpost->get_modified());
                    $output .= html_writer::end_tag('div');

                    $output .= html_writer::start_tag('div', array('class' => 'col-md-12 fullwidth-line'));
                    $output .= html_writer::end_tag('div');

                $output .= html_writer::end_tag('div');

                $output .= html_writer::start_tag('div', array('class' => 'row', 'style' => 'padding: 2% 0% 0% 0%;'));

                    $courselinkdescript = $CFG->wwwroot . "/mod/descriptionpage/view.php?courseid=" . $course->id;
                    $output .= html_writer::start_tag('div', array('class' => 'col-md-12'));
                        $output .= html_writer::tag('span', get_string('questionunregistered', 'block_orange_list_bestforumng'));
                        $output .= html_writer::link($courselinkdescript,
                                                     get_string('answerunregistered', 'block_orange_list_bestforumng'));
                    $output .= html_writer::end_tag('div');

                    // Get link acces forum of course.
                    $courseutilities = new utilities_course();
                    $courselinkdescript = $courseutilities->get_course_url_page_forum($course);
                    $output .= html_writer::start_tag('div', array('class' => 'col-md-12'));
                        $output .= html_writer::tag('span', get_string('questionregistered', 'block_orange_list_bestforumng'));
                        $output .= html_writer::link($courselinkdescript,
                                                     get_string('answerregistered', 'block_orange_list_bestforumng'));
                    $output .= html_writer::end_tag('div');

                $output .= html_writer::end_tag('div');

            $output .= html_writer::end_tag('div');

        $output .= html_writer::end_tag('div');

        return $output;

    }
}