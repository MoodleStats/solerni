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

/**
 * Emerging Messages block config form class
 * 
 * @package block_orange_emerging_messages
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_orange_emerging_messages_edit_form extends block_edit_form {
    protected function specific_definition($mform) {

        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Set emerging message block instance title.
        $mform->addElement('text', 'config_title', get_string('title', 'block_orange_emerging_messages'));
        $mform->setType('config_title', PARAM_TEXT);

        // Output the section header.
        $sectionname = get_string('settings', 'block_orange_emerging_messages');
        $mform->addElement('header', 'section', format_string($sectionname));
        $mform->setExpanded('section');

        $mform->addElement('text', 'config_nbdisplaypost', get_string('nbdisplaypost', 'block_orange_emerging_messages'));
        $mform->setType('config_nbdisplaypost', PARAM_INT);
        $mform->setDefault('config_nbdisplaypost', get_string('nbdisplaypostdefault', 'block_orange_emerging_messages'));

        $radioarray = array();
        $radioarray[] = $mform->createElement('radio', 'config_typetop', '', get_string('mylastposts', 'block_orange_emerging_messages'), 1);
        $radioarray[] = $mform->createElement('radio', 'config_typetop', '', get_string('lastdiscussions', 'block_orange_emerging_messages'), 2);
        $radioarray[] = $mform->createElement('radio', 'config_typetop', '', get_string('bestposts', 'block_orange_emerging_messages'), 3);
        $mform->addGroup($radioarray, 'radioar', get_string('typetop', 'block_orange_emerging_messages'), array(' '), false);
        $mform->addRule('radioar', null, 'required', null, 'client');
    }

    public function set_data($defaults) {
        if (!$this->block->user_can_edit()) {
            if (!empty($this->block->config->title)) {
                // If a title has been set but the user cannot edit it format it nicely.
                $title = $this->block->config->title;
                $defaults->config_title = format_string($title, true, $this->page->context);
                // Remove the title from the config so that parent::set_data doesn't set it.
                unset($this->block->config->title);
            }

            if (!empty($this->block->config->typetop)) {
                $defaults->config_typetop = $this->block->config->typetop;
            }

            if (!empty($this->block->config->nbdisplaypost)) {
                $defaults->config_nbdisplaypost = $this->block->config->nbdisplaypost;
            }
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