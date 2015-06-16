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
 * @subpackage course_extended
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use local_orange_library\utilities\array_object;

defined('MOODLE_INTERNAL') || die();


class block_orange_social_sharing_renderer extends plugin_renderer_base {

    /**
     *  Set the dicplayed text in the block.
     *
     * @param moodle_url $imgurl
     * @param object $course
     * @param object $context
     * @return string $text
     */
    public function get_text($course, $context) {
        Global $PAGE, $DB;

        //todo gerer les differentes config
        $shareonarray = new array_object();
        $socialclassarray = new array_object();
        $socialurlarray = new array_object();
        $coursecontext = context_course::instance($course->id);
        $blockrecord = $DB->get_record('block_instances', array('blockname' => 'orange_social_sharing',
            'parentcontextid' => $coursecontext->id), '*', MUST_EXIST);
        $blockinstance = block_instance('orange_social_sharing', $blockrecord);

        if($blockinstance->config->facebook){
            $shareonarray->add(get_string('shareonfacebook', 'block_orange_social_sharing'));
            $socialclassarray->add('button_social_facebook');
            $socialurlarray->add(get_string('urlshareonfacebook', 'block_orange_social_sharing'));
        }
        if($blockinstance->config->twitter){
            $shareonarray->add(get_string('shareontwitter', 'block_orange_social_sharing'));
            $socialclassarray->add('button_social_twitter');
            $socialurlarray->add(get_string('urlshareontwitter', 'block_orange_social_sharing'));
        }
        if($blockinstance->config->linkedin){
            $shareonarray->add(get_string('shareonlinkedin', 'block_orange_social_sharing'));
            $socialclassarray->add('button_social_linkedin');
            $socialurlarray->add(get_string('urlshareonlinkedin', 'block_orange_social_sharing'));
        }
        if($blockinstance->config->googleplus){
            $shareonarray->add(get_string('shareongoogleplus', 'block_orange_social_sharing'));
            $socialclassarray->add('button_social_googleplus');
            $socialurlarray->add(get_string('urlshareongoogleplus', 'block_orange_social_sharing'));
        }


        $count = $shareonarray->count;
        $text = html_writer::start_tag('div', array('class' => 'sider sider_social-sharing'));
                $text .= html_writer::start_tag('ul', array('class' => 'list-unstyled'));

        for ($i = 1; $i <= $count; $i++) {
                    $shareonarray->setCurrent($i);
                    $socialclassarray->setCurrent($i);
                    $socialurlarray->setCurrent($i);

                    $text .= html_writer::start_tag('li', array('class' => 'button_social_item'));

                    $text .= html_writer::tag('a', $shareonarray->getCurrent(),
                            array('class' => 'button_social_link__icon '.$socialclassarray->getCurrent().' -sprite-solerni',
                            'href' => $socialurlarray->getCurrent().$PAGE->url));
                    $text .= html_writer::end_tag('li');

        }
                $text .= html_writer::end_tag('ul');
        $text .= html_writer::end_tag('div');
        return $text;

    }

    /**
     *  Set the dicplayed text in the block.
     *
     * @param moodle_url $imgurl
     * @param object $course
     * @param object $context
     * @return string $text
     */
    public function get_social_link($name, $class, $url) {
        Global $PAGE;

        $text .= html_writer::start_tag('ul', array('class' => 'essentiels'));
            $text .= html_writer::start_tag('li');
             return html_writer::tag('a', get_string('shareonfacebook', 'block_orange_social_sharing'),
                     array('class' => 'footer_social_link__icon footer_social_facebook -sprite-solerni',
                     'href' => "http://www.facebook.com/sharer.php?u=".$PAGE->url));
             $text .= html_writer::end_tag('li');
        $text .= html_writer::end_tag('ul');
        return $text;

    }

    /**
     *  Set the extended course registration values from the extended course registration.
     *
     * @param object $extendedcourse
     * @return object $this->extendedcourse
     */
    private function get_registration ($extendedcourse) {

        if (!empty($extendedcourse->registration)) {
            switch ($extendedcourse->registration) {
                case '0':
                    $registrationvalue = get_string('registration_case1', 'block_orange_course_extended').
                    get_string('registration_from', 'block_orange_course_extended').
                    date("d-m-Y", $extendedcourse->enrolstartdate).
                    get_string('registration_to', 'block_orange_course_extended').
                    date("d-m-Y", $extendedcourse->enrolenddate);
                break;
                case '1':
                    $registrationvalue = get_string('registration_case2', 'block_orange_course_extended').
                    $extendedcourse->maxregisteredusers.' '.
                    get_string('registration_case2_2', 'block_orange_course_extended').
                    get_string('registration_from', 'block_orange_course_extended').
                    date("d-m-Y", $extendedcourse->enrolstartdate).
                    get_string('registration_to', 'block_orange_course_extended').
                    date("d-m-Y", $extendedcourse->enrolenddate);
                break;
                case '2':

                    $registrationvalue = get_string('registration_case3', 'block_orange_course_extended').
                    $extendedcourse->registrationcompany.
                    get_string('registration_from', 'block_orange_course_extended').
                    date("d-m-Y", $extendedcourse->enrolstartdate).
                    get_string('registration_to', 'block_orange_course_extended').
                    date("d-m-Y", $extendedcourse->enrolenddate);
                break;
            }
            return $registrationvalue;
        }
    }



}
