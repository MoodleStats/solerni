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
 * orange_paragraph_list block
 *
 * @package    block_orange_paragraph_list
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

use block_orange_paragraph_list\find_out_more;

class block_orange_paragraph_list extends block_base {

    /**
     * Instance constructor.
     *
     * @return void
     */
    public function init() {
        global $PAGE;

        $this->title = get_string('config_default_title', 'block_orange_paragraph_list');
        $this->renderer = $PAGE->get_renderer('block_orange_paragraph_list');
        $this->defaultnbitems = 10;
    }

    /**
     * @return bool
     */
    public function has_config() {
        return false;
    }


    /**
     * @return bool
     */
    public function instance_allow_multiple() {
        return false;
    }

    /**
     * @return bool
     */
    public function instance_allow_config() {
        return false;
    }

    /**
     * @return array
     */
    public function applicable_formats() {
        return array(
            'course-view'    => true,
            'site'           => false,
            'mod'            => false,
            'my'             => false
        );
    }

    /**
     * Creates the blocks main content.
     *
     * @todo: I don't think we need to instanciate something (find_out_more)
     * for just one iteration.
     *
     * @global $COURSE
     *
     * @return string <DOM fragment>
     */
    public function get_content() {
        global $COURSE;

        // If content has already been generated, don't waste time generating it again.
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';

        $findoutmore = new find_out_more($COURSE, $this->defaultnbitems);
        $findoutmore->get_find_out_more();

        $this->content->text = $this->renderer->render_paragraph_list($findoutmore);

        return $this->content;
    }

    /**
     * Sets block header to be hidden
     *
     * @return bool if true then header will be visible.
     */
    public function hide_header() {

        return true;
    }
}
