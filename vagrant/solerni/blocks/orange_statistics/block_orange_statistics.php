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
 * Orange statistics block definition
 *
 * @package    block_orange_last_message
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


/**
 * statistics class
 *
 * @copyright 2010 Michael de Raadt
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_orange_statistics extends block_base {

    /**
     * Sets the block title
     *
     * @return void
     */
    public function init() {
        $this->title = get_string('config_default_title', 'block_orange_statistics');
    }

    public function get_content() {
        global $USER, $COURSE, $CFG, $OUTPUT, $DB;
    if ($this->content !== null) {
        return $this->content;
    }
    die($USER);
    $this->content         =  new stdClass;
    $this->content->text   = 'The content of our statistics block!';
    $this->content->footer = 'Footer here...';
    $blockinstancesonpage = array();
    
    if (has_capability('block/orange_statistics:overview', $this->context)) {
        $parameters = array('courseid' => $COURSE->id);
        $url = new moodle_url('/blocks/orange_statistics/overview.php', $parameters);
        $label = get_string('overviewbutton', 'block_orange_statistics');
        $options = array('class' => 'overviewButton');
        $this->content->text .= $OUTPUT->single_button($url, $label, 'post', $options);
    }
    
    $blockinstancesonpage = array($this->instance->id);
 
    return $this->content;
    }
  
  /**
     * Defines where the block can be added
     *
     * @return array
     */
    public function applicable_formats() {
        return array(
            'course-view'    => true,
            'site'           => true,
            'mod'            => false,
            'my'             => true
        );
    }
    
    public function instance_allow_multiple() {
        return false;
    }
  
    
    
    
    
    
    
}



