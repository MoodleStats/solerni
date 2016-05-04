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
 * orange library Thematic cron task.
 *
 * @package    orange_library
 * @subpackage utilities
 * @copyright  2016 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_orange_library\task;
use local_orange_library\utilities\utilities_network;
use local_orange_library\utilities\utilities_image;

defined('MOODLE_INTERNAL') || die();


class orange_library_thematic_task extends \core\task\scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('orange_library_thematic_task', 'local_orange_library');
    }

    /**
     * Retreive information about local or remote thématic and cache data in DB.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {

        // This task should only run on Home in case of Mnet configuration.
        if (utilities_network::is_platform_uses_mnet() && utilities_network::is_home()) {
            $hosts = utilities_network::get_hosts();

            foreach ($hosts as $host) {
                utilities_network::update_thematic_info($host);
            }
        } else {
            $host = new \stdclass();
            $host->id = 1;
            utilities_network::update_thematic_info($host);
        }
    }
}