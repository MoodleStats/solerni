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
 * Orange Thematics Menu block for solerni Home.
 *
 * @package    block_orange_thematics_menu
 * @copyright  2016 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use local_orange_library\utilities\utilities_network;

class block_orange_thematics_menu extends block_base {
    public function init() {
        global $PAGE;

        $this->title = get_string('pluginname', 'block_orange_thematics_menu');
        $this->renderer = $PAGE->get_renderer('block_orange_thematics_menu');
    }

    public function html_attributes() {
        $attributes = parent::html_attributes();
        $attributes['class'] .= ' bg-yellow expanded';

        return $attributes;
    }

    public function has_config() {
        return false;
    }

    /**
     * Defines where the block can be added
     *
     * @return array
     */
    public function applicable_formats() {
        return array('site-index'     => true);
    }

    /**
     * Sets block header to be hidden or visible
     *
     * @return bool if true then header will be visible.
     */
    public function hide_header() {
        return true;
    }

    public function get_content() {

        // Bloc only for MNet plateforme.
        if (    !utilities_network::is_platform_uses_mnet()
                || (utilities_network::is_platform_uses_mnet() && utilities_network::is_thematic())
                || ! ($hosts = utilities_network::get_hosts())) {
            return false;
        }

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->footer = '';

        $this->content->text = html_writer::start_tag('div', array('class' => 'row'));
            foreach ($hosts as $host) {
                $host = utilities_network::get_thematic_info($host);
                if (isloggedin() and !isguestuser()) {
                    $host->url = $host->jump;
                }
                $this->content->text .= $this->renderer->menu_item($host);
            }

        $this->content->text .= html_writer::end_tag('div');

        return $this->content;
    }
}
