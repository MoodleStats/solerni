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
 * Orange Rules block.
 *
 * @package    block_orange_rules
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_orange_rules extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_orange_rules');
    }

    public function applicable_formats() {
        return array('all' => true, 'tag' => false);
    }

    public function specialization() {
        $this->title = isset($this->config->title) ? $this->config->title : get_string('neworangerulesblock', 'block_orange_rules');
    }

    public function instance_allow_multiple() {
        return true;
    }

    public function get_content() {
        global $CFG, $USER, $DB;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();

        return $this->content;
    }

    /**
     * Returns true if the block can be docked.
     * The Orange Rules block can only be docked if it has a non-empty title.
     * @return bool
     */
    public function instance_can_be_docked() {
        return parent::instance_can_be_docked() && isset($this->config->title) && !empty($this->config->title);
    }
}

