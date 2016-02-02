<?php
// This file is part of The Orange Halloween Moodle Theme
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

use theme_halloween\tools\log_and_session_utilities;
use local_orange_library\utilities\utilities_network;

class utilities_network_testcase extends advanced_testcase {

	private $user;
    private $mnethost;

    protected function setUp() {
        global $CFG;
        $this->resetAfterTest();
        $this->user = self::getDataGenerator()->create_user();
		self::setUser($this->user);

        $this->mnethost = $this->add_mnet_host();

        // Simulate MNET is activated
        if (!$CFG->solerni_isprivate) {
            $CFG->auth = 'mnet';
        }
    }

    /*
     * Creates a host in the database and return the host object
     */
    public function add_mnet_host() {
        // Add a mnet host.
        global $DB;
        $mnethost = new stdClass();
        $mnethost->name = 'A mnet host';
        $mnethost->public_key = 'A random public key!';
        $mnethost->wwwroot = 'http://www.goodurl.fr';
        $mnethost->id = $DB->insert_record('mnet_host', $mnethost);

        return $mnethost;
    }

    public function test_is_platform_uses_mnet() {
        $mnetlog = utilities_network::is_platform_uses_mnet();
        $this->assertInternalType('bool', $mnetlog);
    }

    protected function assert_valid_url($url) {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            $this->fail($url . ' is not a valid URL');
        }
    }
}
