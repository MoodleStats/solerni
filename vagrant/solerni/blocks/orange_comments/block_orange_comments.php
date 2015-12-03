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
 * @copyright 2009 Dongsheng Cai <dongsheng@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Obviously required.
require_once($CFG->dirroot . '/comment/lib.php');

class block_orange_comments extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_orange_comments');
    }

    public function specialization() {
        // Require js for commenting.
        comment::init();
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
        $this->content->text = '';
        if (empty($this->instance)) {
            return $this->content;
        }
        list($context, $course, $cm) = get_context_info_array($PAGE->context->id);

        $pageid  = optional_param('pageid', 0, PARAM_INT);

        if ($pageid == 0 ) {
            // Find all element in navbar and keep the last : this is curent page.
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

        $args = new stdClass;
        $args->context   = $PAGE->context;
        $args->course    = $course;
        $args->area      = 'page_comments';
        $args->itemid    = $pageid;
        $args->component = 'block_orange_comments';
        $args->linktext  = get_string('showcomments');
        $args->notoggle  = true;
        $args->autostart = true;
        $args->displaycancel = false;
        $comment = new comment($args);
        $comment->set_view_permission(true);
        $comment->set_fullwidth();

        $this->content = new stdClass();
        $this->content->text = $comment->output(true);
        $this->content->footer = '';
        return $this->content;
    }
}
