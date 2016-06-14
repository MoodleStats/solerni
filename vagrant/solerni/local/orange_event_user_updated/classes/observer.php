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
 * Version details
 *
 * @package    local_orange_event_user_updated
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

use local_orange_library\utilities\utilities_network;
use local_orange_library\utilities\utilities_user;

/**
 * Event observer.
 */
class local_orange_event_user_updated_observer {

    /**
     * Triggered via user_updated event.
     *
     * @param \core\event\user_updated $event
     */

    public static function user_updated(\core\event\user_updated $event) {
        global $DB;

        $clause = array('id' => $event->objectid);

        if ($user = $DB->get_record('user', $clause)) {
            // In case of Mnet configuration we have to propagate user_updated event.
            if ((utilities_network::is_platform_uses_mnet())
                    && (utilities_network::is_home())) {
                utilities_user::propagate_update_user($user);
            }

        }
        return true;
    }
}
