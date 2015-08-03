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
 * @subpackage orange_social_sharing
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
    public function get_text($course) {
        Global $PAGE, $DB;

        $shareonarray = new array_object();
        $socialclassarray = new array_object();
        $socialurlarray = new array_object();
        $coursecontext = context_course::instance($course->id);
        $blockrecord = $DB->get_record('block_instances', array('blockname' => 'orange_social_sharing',
            'parentcontextid' => $coursecontext->id), '*', MUST_EXIST);
        $blockinstance = block_instance('orange_social_sharing', $blockrecord);

        if (!empty($blockinstance->config->facebook)) {
            $shareonarray->add(get_string('shareonfacebook', 'block_orange_social_sharing'));
            $socialclassarray->add('button_social_facebook');
            $socialurlarray->add(get_string('urlshareonfacebook', 'block_orange_social_sharing'));
        }
        if (!empty($blockinstance->config->twitter)) {
            $shareonarray->add(get_string('shareontwitter', 'block_orange_social_sharing'));
            $socialclassarray->add('button_social_twitter');
            $socialurlarray->add(get_string('urlshareontwitter', 'block_orange_social_sharing'));
        }
        if (!empty($blockinstance->config->linkedin)) {
            $shareonarray->add(get_string('shareonlinkedin', 'block_orange_social_sharing'));
            $socialclassarray->add('button_social_linkedin');
            $socialurlarray->add(get_string('urlshareonlinkedin', 'block_orange_social_sharing'));
        }
        if (!empty($blockinstance->config->googleplus)) {
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
                            'href' => $socialurlarray->getCurrent().$PAGE->url, 'target' => '_blank'));
                    $text .= html_writer::end_tag('li');

        }
                $text .= html_writer::end_tag('ul');
        $text .= html_writer::end_tag('div');
        return $text;

    }
}
