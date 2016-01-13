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
 * The comments block
 *
 * @package    block_orange_comments
 * @copyright  2015 Orange based on block_comments plugin from 1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/comment/lib.php');
require_once($CFG->dirroot . '/blocks/orange_comments/lib.php');
require_once($CFG->dirroot . '/blocks/orange_comments/locallib.php');

class block_orange_comments extends block_base {

    public function init() {
        // Admin Plugin Name.
        $this->title = get_string('pluginname', 'block_orange_comments');
    }

    public function specialization() {
        // Frontend Block Name.
        $this->title = get_string('yourreactions', 'block_orange_comments');
    }

    public function applicable_formats() {
        return array('all' => true);
    }

    public function instance_allow_multiple() {
        return true;
    }

    public function get_content() {
        global $CFG, $PAGE, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        if (!$CFG->usecomments) {
            $this->content = new stdClass();
            $this->content->text = '';
            if ($this->page->user_is_editing()) {
                $this->content->text = get_string('disabledcomments');
            }
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->footer = '';

        if (empty($this->instance)) {
            $this->content->text = '';

            return $this->content;
        }

        list($context, $course, $cm) = get_context_info_array($PAGE->context->id);

        $pageid  = optional_param('pageid', 0, PARAM_INT);
        if ($pageid == 0 ) {
            // Find all element in navbar and keep the last : this is current page.
            $tab = explode('<a href="', $OUTPUT->navbar());
            $urlcurrent = substr( end($tab), 0, strpos(end($tab), '"'));
            if (strpos($urlcurrent, "pageid") !== false) {
                // Parameters in url current.
                $tab2 = explode("&amp;", substr($urlcurrent, strpos($urlcurrent, "?") + 1));
                foreach ($tab2 as $element) {
                    if (strpos($element, "pageid") !== false) {
                        $pageid = substr($element, strlen("pageid="));
                    }
                }
            }
        }

        $args                   = new stdClass;
        $args->context          = $PAGE->context;
        $args->course           = $course;
        $args->area             = 'page_comments';
        $args->itemid           = $pageid;
        $args->pluginname       = 'orange_comments';
        $args->plugintype       = 'block';
        $args->component        = 'block_orange_comments';
        $args->linktext         = get_string('writecomment', 'block_orange_comments');
        $args->notoggle         = false;
        $args->autostart        = true;
        $args->displaycancel    = false;

        $orangecomment = new orange_comments($args);
        $orangecomment->set_view_permission(true);
        $orangecomment->set_fullwidth();

        $this->content->text = $orangecomment->output(true);

        return $this->content;
    }
}
