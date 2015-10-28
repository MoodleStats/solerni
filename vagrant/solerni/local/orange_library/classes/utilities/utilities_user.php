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
namespace local_orange_library\utilities;

defined('MOODLE_INTERNAL') || die();

class utilities_user {

    static function is_user_site_admin($user) {
        foreach (get_admins() as $adminuser) {
            if ($user->id === $adminuser->id ) {
                return true;
            }
        }
    }

    static function is_user_course_admin($user, $course) {
        // check user right inside the course
    }

    /**
     * Check for user new mail. Return the number of mail (int) or false.
     * Use local_mail plugin.
     *
     * @param class $user
     * @return int || boolean
     */
    static function user_have_new_mail($user) {
        if (class_exists('local_mail_message')) {
            $count = \local_mail_message::count_menu($user->id);
            if (property_exists($count, 'inbox')) {
                return $count->inbox;
            }
        }
        
        return false;
    }

}
