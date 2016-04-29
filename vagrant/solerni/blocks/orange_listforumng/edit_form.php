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

require_once($CFG->dirroot . '/course/moodleform_mod.php');
require_once($CFG->dirroot . '/mod/forumng/mod_forumng.php');
require_once($CFG->dirroot.'/blocks/orange_listforumng/lib.php');

/**
 * Listforumng block config form class
 * 
 * @package block_orange_listforumng
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_orange_listforumng_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        global $COURSE, $DB;

        $turnallon = optional_param('turnallon', 0, PARAM_INT);

        // No title if in forum page : title is defined in lang file.
        if (!block_orange_listforumng_on_forum_index_page()) {
            // Fields for editing HTML block title and contents.
            $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

            // Set listforumng block instance title.
            $mform->addElement('text', 'config_title', get_string('title', 'block_orange_listforumng'));
            $mform->setType('config_title', PARAM_TEXT);
        }

        // Get course section information.
        $allforums = block_orange_listforumng_get_all($COURSE->id);

        // Output the section header.
        $sectionname = get_string('assignforum', 'block_orange_listforumng');
        $mform->addElement('header', 'section', format_string($sectionname));
        $mform->setExpanded('section');

        $course = $DB->get_record('course', array('id' => $COURSE->id), '*', MUST_EXIST);
        $text = get_string('course', 'block_orange_listforumng') . $course->fullname;
        $attributes = array('class' => 'progressConfigModuleTitle');
        $moduletitle = html_writer::tag('div', $text, $attributes);

        $mform->addElement('html', $moduletitle);

        foreach ($allforums as $forum) {
            // Allow monitoring turned on or off.
            $mform->addElement('advcheckbox',
                    'config_forumng_'.$forum->id, null, $forum->name);
            $mform->setDefault('config_forumng_'.$forum->id, $turnallon);
        }

    }

    public function set_data($defaults) {
        if (!$this->block->user_can_edit() && !empty($this->block->config->title)) {
            // If a title has been set but the user cannot edit it format it nicely.
            $title = $this->block->config->title;
            $defaults->config_title = format_string($title, true, $this->page->context);
            // Remove the title from the config so that parent::set_data doesn't set it.
            unset($this->block->config->title);
        }

        parent::set_data($defaults);
        // Restore $text.
        if (!isset($this->block->config)) {
            $this->block->config = new stdClass();
        }

        if (isset($title)) {
            // Reset the preserved title.
            $this->block->config->title = $title;
        }
    }
}