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

class log_and_session_utilities_testcase extends advanced_testcase {

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

    public function test_is_platform_login_uses_mnet() {
        $mnetlog = log_and_session_utilities::is_platform_login_uses_mnet();
        $this->assertInternalType('bool', $mnetlog);
    }

    public function test_testsession_initialize() {
        $testvalues = array(0, 1, '0', '1', 455, -45, 0123, 0x1A, 0b11111111, $this->user->id);

        foreach ($testvalues as $value) {
            $init = log_and_session_utilities::testsession_initialize($value);
            $this->assertInternalType('array', $init,
                    '$init is not a array.');
            $this->assertCount(2, $init,
                    'Wrong number of rows in $init: ' . count($init) . ' rows.');
            $this->assertArrayHasKey('errormsg', $init,
                    'No errormsg key in $init');
            $this->assertArrayHasKey('errorcode', $init,
                    'No errorcode key in $init');

            if($value && is_int($value) && $value !== $this->user->id) {
                $this->assertEquals(1, $init['errorcode'],
                        'User Id different from $testsession, should have received a errorcode. '
                        . '$testsession: '  . $value
                        . ', UserId: '      . $this->user->id
                        . ', errorcode: '   . $init['errorcode']
                    );
                $this->assertNotEmpty($init['errormsg'],
                        'No error message but errorcode is not empty');
            } else {
                $this->assertEquals(0, $init['errorcode']);
                $this->assertEmpty($init['errormsg']);
            }
        }
    }

    public function test_define_login_form_action() {
        $testvalues = array(0, 1);
        foreach ($testvalues as $value) {
            $formaction = log_and_session_utilities::define_login_form_action($value);
            $isthematic = utilities_network::is_thematic();
                $this->assertInternalType('array', $formaction,
                    '$formaction is not a array.');
            $this->assertCount(2, $formaction,
                    'Wrong number of rows in $formaction: ' . count($formaction) . ' rows.');
            $this->assertArrayHasKey('host', $formaction,
                    'No host key in $formaction');
            $this->assertArrayHasKey('isthematic', $formaction,
                    'No isthematic key in $formaction');
            $this->assert_valid_url($formaction['host']);

            if (log_and_session_utilities::is_platform_login_uses_mnet() && $isthematic && !$value) {
                $this->assertTrue($formaction['isthematic'],
                    'This is thematic, so the isthematic key should be true');
            } else {
                $this->assertFalse($formaction['isthematic'],
                    'This is HOME MNET, so the isthematic key should be false');
            }
        }
    }

    public function test_get_session_user_redirect_url() {

        $urltogo = log_and_session_utilities::get_session_user_redirect_url();
        $this->assert_valid_url($urltogo);
    }

    public function test_get_register_form_url() {

        $url = log_and_session_utilities::get_register_form_url();
        $this->assertInternalType('string', $url, $url . ' is not a string.');
        $this->assert_valid_url($url);

        global $SESSION;
        $SESSION->wantsurl = 'wrongurl';
        $url = log_and_session_utilities::get_register_form_url();
        $this->assertInternalType('string', $url,
                $url . ' is not a string.');
        $this->assert_valid_url($url);

        $SESSION->wantsurl = 'http://www.orange.fr';
        $url = log_and_session_utilities::get_register_form_url();
        $this->assertInternalType('string', $url,
                $url . ' is not a string.');
        $this->assert_valid_url($url);
    }

    public function test_check_for_mnet_origin() {
        global $SESSION, $CFG;
        $frm = new StdClass();
        log_and_session_utilities::check_for_mnet_origin($frm);
        $this->assertFalse(isset($SESSION->mnetredirect));
        // Need to add a test with mnet hosts in DB
    }

    protected function assert_valid_url($url) {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            $this->fail($url . ' is not a valid URL');
        }
    }
}
