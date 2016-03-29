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
 * Orange Social following renderer
 *
 * @package    blocks
 * @subpackage orange_orange_social_following
 * @copyright  2016 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use local_orange_library\utilities\utilities_array;

defined('MOODLE_INTERNAL') || die();


class block_orange_social_following_renderer extends plugin_renderer_base {

    /**
     *  Set the displayed text in the block.
     *
     * @global $PAGE
     * @param none
     * @return string $text
     */
    public function get_text() {
        Global $PAGE;

        $shareonarray = new utilities_array();
        $socialclassarray = new utilities_array();
        $socialurlarray = new utilities_array();

        $title = get_string('followtitle', 'block_orange_social_sharing');

        $shareonarray->add(get_string('shareonfacebook', 'block_orange_social_sharing'));
        $socialclassarray->add('facebook');
        $socialurlarray->add(get_string('urlshareonfacebook', 'block_orange_social_sharing'));

        $shareonarray->add(get_string('shareontwitter', 'block_orange_social_sharing'));
        $socialclassarray->add('twitter');
        $socialurlarray->add(get_string('urlshareontwitter', 'block_orange_social_sharing'));

        $shareonarray->add(get_string('shareonlinkedin', 'block_orange_social_sharing'));
        $socialclassarray->add('linkedin');
        $socialurlarray->add(get_string('urlshareonlinkedin', 'block_orange_social_sharing'));

        $shareonarray->add(get_string('shareongoogleplus', 'block_orange_social_sharing'));
        $socialclassarray->add('googleplus');
        $socialurlarray->add(get_string('urlshareongoogleplus', 'block_orange_social_sharing'));

        $count = $shareonarray->count;

        $text = html_writer::start_tag('div');
        $text .= html_writer::start_tag('ul', array('class' => "list-unstyled list-social"));

        $text .= html_writer::tag("li", $title , array('class' => "social-item h7 hidden-xs"));

        for ($i = 1; $i <= $count; $i++) {
                    $shareonarray->setCurrent($i);
                    $socialclassarray->setCurrent($i);
                    $socialurlarray->setCurrent($i);

                    $text .= html_writer::start_tag('li', array('class' => 'social-item'));

                    $text .= html_writer::tag('a', " ",
                            array('class' => 'icon-halloween icon-halloween--'.$socialclassarray->getCurrent(),
                            'href' => $socialurlarray->getCurrent().$PAGE->url, 'target' => '_blank'));
                    $text .= html_writer::end_tag('li');

        }
        $text .= html_writer::end_tag('ul');
        $text .= html_writer::end_tag('div');

        return $text;

    }
}
