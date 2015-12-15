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
 * @subpackage test/utilities
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use local_orange_library\utilities\utilities_network;

class utilities_networkTest extends advanced_testcase {

    /**
     * Test: getting the Mnet Hosts URL of the Moodle Network
     * should return false or array with Hosts server URL/name
     */
    public function test_get_hosts() {
        global $CFG;
        $this->setAdminUser();
        $hosts = utilities_network::get_hosts();

        if ($CFG->solerni_isprivate) {
            $this->assertFalse($hosts);
        } else {
            $this->assertInternalType('array', $hosts);
            $this->assertGreaterThanOrEqual(1, count($hosts));
            $this->assertArrayHasKey('url', $hosts[0]);
            $this->assertArrayHasKey('name', $hosts[0]);
            $this->assertInternalType('string', $hosts[0]['url']);
            $this->assertInternalType('string', $hosts[0]['name']);
            $this->assertTrue(filter_var($hosts[0]['url'],FILTER_VALIDATE_URL));
        }
    }

}
