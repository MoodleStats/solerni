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
    public function get_text() {
        Global $PAGE, $DB;

        $shareonarray = new array_object();
        $socialclassarray = new array_object();
        $socialurlarray = new array_object();

        $blockrecord = $DB->get_record('block_instances', array('blockname' => 'orange_social_sharing',
            'parentcontextid' => $PAGE->context->id), '*', IGNORE_MISSING);

        if ($blockrecord) {
            $blockinstance = block_instance('orange_social_sharing', $blockrecord);
        }

        if (!empty($blockinstance->config->facebook)) {
            $shareonarray->add(get_string('shareonfacebook', 'block_orange_social_sharing'));
            $socialclassarray->add('facebook');
            $socialurlarray->add(get_string('urlshareonfacebook', 'block_orange_social_sharing'));
        }
        if (!empty($blockinstance->config->twitter)) {
            $shareonarray->add(get_string('shareontwitter', 'block_orange_social_sharing'));
            $socialclassarray->add('twitter');
            $socialurlarray->add(get_string('urlshareontwitter', 'block_orange_social_sharing'));
        }
        if (!empty($blockinstance->config->linkedin)) {
            $shareonarray->add(get_string('shareonlinkedin', 'block_orange_social_sharing'));
            $socialclassarray->add('linkedin');
            $socialurlarray->add(get_string('urlshareonlinkedin', 'block_orange_social_sharing'));
        }
        if (!empty($blockinstance->config->googleplus)) {
            $shareonarray->add(get_string('shareongoogleplus', 'block_orange_social_sharing'));
            $socialclassarray->add('googleplus');
            $socialurlarray->add(get_string('urlshareongoogleplus', 'block_orange_social_sharing'));
        }

        $count = $shareonarray->count;
        $text = html_writer::start_tag('div', array('class' => 'sider sider_social-sharing row'));

        for ($i = 1; $i <= $count; $i++) {
                    $shareonarray->setCurrent($i);
                    $socialclassarray->setCurrent($i);
                    $socialurlarray->setCurrent($i);

                    $text .= html_writer::start_tag('div', array('class' => 'col-xs-12 col-md-2'));

                    $text .= html_writer::tag('a', " ",
                            array('class' => 'icon-halloween icon-halloween--'.$socialclassarray->getCurrent(),
                            'href' => $socialurlarray->getCurrent().$PAGE->url, 'target' => '_blank'));
                    $text .= html_writer::end_tag('div');

        }

        $text .= html_writer::end_tag('div');
        return $text;

    }
}
