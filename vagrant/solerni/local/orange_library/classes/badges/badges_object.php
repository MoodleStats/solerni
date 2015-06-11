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
 * @package    orange_library
 * @subpackage utilities
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_orange_library\badges;
defined('MOODLE_INTERNAL') || die();

class badges_object {

    /**
     * Get the badges for a course
     * @return array $usedbadges
     */
        public function get_badges() {
        global $DB, $PAGE;
        $usedbadges = array();
        $badges = $DB->get_records('badge', array('courseid'=>$PAGE->course->id));
        if ($badges) {
            foreach ($badges as $badge) {
                    $usedbadges[$badge->id] = $badge->name;
            }
        } else {
            $usedbadges[1] = get_string('badge_default', 'local_orange_library');
        }
        return $usedbadges;
    }

    /**
     * Get the badges string for a course
     * @return string $stringbadges
     */
    public function get_badges_string() {
        $badges = get_badges();
        if ($badges) {
            $stringbadges = get_string('badge', 'local_orange_library');
            foreach ($badges as $badge) {
                $stringbadges = $stringbadges."<br>".$badge;
            }
        } else {
            $stringbadges = get_string('certification_default', 'local_orange_library');
        }

        return $stringbadges;
    }

    /**
     * count badges for a course
     * @return int number of badges
     */
    public function count_badges($courseid) {
        global $DB;
        $nbbadges = $DB->count_records('badge', array('courseid'=>$courseid));
        return $nbbadges;
    }
}
