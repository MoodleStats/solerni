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
 * Main block functions.
 *
 * @package    blocks
 * @subpackage jmail
 * @copyright  2011 Juan Leyva <juanleyvadelgado@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_jmail extends block_list {

    public function applicable_formats() {
        // This method allows you to control which pages your block can be added to
        // Default case: the block can be used in courses and site index, but not in activities
        return array('all' => true, 'mod' => false, 'tag' => false);
    }

    public function has_config() {
        return true;
    }

    public function instance_allow_config() {
        return true;
    }

    public function specialization() {

        if (empty($this->config->title)) {
            $this->title = get_string('pluginname','block_jmail');
        } else {
            $this->title = $this->config->title;
        }
    }

    public function get_content() {
        global $CFG, $DB;

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        if ($this->content !== null) {
            return $this->content;
        }

        // Only for logged and non guest users
        if (!isloggedin() or isguestuser()) {
            return '';
        }

        require_once(dirname(__FILE__).'/block_jmail_mailbox.class.php');

        $this->content = new stdClass();
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->footer = '';

        $currentcontext = $this->page->context;

        $renderer = $this->page->get_renderer('block_jmail');

        $newmailicon = $renderer->plugin_icon('new');

        $mycourses = array();
        if ($this->page->course->id == SITEID) {
            if (!empty($CFG->block_jmail_enable_globalinbox)) {
                $this->content->footer = $renderer->global_inbox();
            }
            if ($mycourses = block_jmail_mailbox::get_my_mailboxes()) {
                foreach ($mycourses as $course) {
                    if ($mailbox = new block_jmail_mailbox($course)) {
                        if ($unreadmails = $mailbox->count_unread_messages()) {
                            $this->content->items[] = $renderer->unread_messages($mailbox);
                            $this->content->icons[] = $newmailicon;
                        }
                    }
                }
            }
        } else {
            $this->content->footer = $renderer->course_inbox($this->page->course);
            $context = block_jmail_get_context(CONTEXT_COURSE, $this->page->course->id);
            if ($mailbox = new block_jmail_mailbox($this->page->course, $context)) {
                if ($unreadmails = $mailbox->count_unread_messages()) {
                    $mailbox->pagesize = 5;
                    if ($messages = $mailbox->get_message_headers('unread', 0, 'date', 'desc', '')) {
                        foreach ($messages[1] as $m) {
                            $strfrom = get_string('from', 'block_jmail');
                            $messagetext = shorten_text($m->subject,25)." (<i>$strfrom: ".shorten_text($m->from,15).")</i>";
                            $this->content->items[] = $messagetext;
                            $this->content->icons[] = '';
                        }
                    }
                    $this->content->items[] = get_string('unreadmessages', 'block_jmail', $unreadmails);
                    $this->content->icons[] = $newmailicon;
                }
            }
        }

        if (!count($this->content->items)) {
			$this->content->items[] = get_string('nonewmessages', 'block_jmail');
		}

        return $this->content;
    }

    public function init() {
        // This method must be implemented for all blocks
        $this->title = get_string('pluginname', 'block_jmail');
    }

    public function instance_allow_multiple() {
        return false;
    }

}
