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
 * Admin settings class for the Orange Action block.
 *
 * @package    block_orange_action
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
use local_orange_library\utilities\utilities_course;

class block_orange_action_admin_setting_courselist extends admin_setting_configselect {
    public function load_choices() {
        global $CFG, $DB;

        if (is_array($this->choices)) {
            return true;
        }

        $utilitiescourse = new utilities_course();
        $courses = $utilitiescourse->get_courses_recommended();

        $choices = array();
        $choices[0] = get_string("selectcourse", 'block_orange_action');
        foreach ($courses as $course) {
            $choices[$course->id] = $course->fullname;
        }

        $this->choices = $choices;

        return true;
    }
}
