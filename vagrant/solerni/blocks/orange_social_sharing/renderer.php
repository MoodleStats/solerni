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
 * Orange Social Sharing renderer
 *
 * @package    blocks
 * @subpackage orange_social_sharing
 * @copyright  2016 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_orange_social_sharing_renderer extends plugin_renderer_base {

    /**
     *  Set the displayed text in the block.
     *
     * @global $PAGE
     * @param none
     * @return string $text
     */
    public function get_text() {
        global $PAGE, $CFG, $COURSE;
        require_once($CFG->dirroot.'/blocks/orange_social_sharing/lib.php');

        $shareonarray       = block_orange_social_sharing_shareonarray();
        $socialclassarray   = block_orange_social_sharing_socialclassarray();
        $socialurlarray     = block_orange_social_sharing_socialurlarray();

        $title              = get_string('sharetitle', 'block_orange_social_sharing');

        $count = $shareonarray->count;
        $text = html_writer::start_tag('ul', array('class' => "list-unstyled list-social text-oneline"));
            $text .= html_writer::tag("li", $title , array('class' => "social-item h7 hidden-xs"));
        for ($i = 1; $i <= $count; $i++) {
            $shareonarray->setCurrent($i);
            $socialclassarray->setCurrent($i);
            $socialurlarray->setCurrent($i);

                    $text .= html_writer::start_tag('li', array('class' => 'social-item'));
                        $text .= html_writer::link(
                                $socialurlarray->getCurrent()."http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
                                $socialclassarray->getCurrent(),
                                array('class' => 'icon-halloween social icon-halloween--' . $socialclassarray->getCurrent(),
                                      'target' => '_blank')
                        );
                    $text .= html_writer::end_tag('li');
                }
        $text .= html_writer::end_tag('ul');

        return $text;
    }
}
