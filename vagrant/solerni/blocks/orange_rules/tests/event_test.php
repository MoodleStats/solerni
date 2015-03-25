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
 * Orange Rules block.
 *
 * @package    block_orange_rules
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/webservice/tests/helpers.php');
require_once($CFG->dirroot . '/cohort/externallib.php');
require_once($CFG->dirroot . '/local/orange_rules/lib.php');
require_once($CFG->dirroot . '/cohort/lib.php');

class block_orange_rules_events_testcase extends advanced_testcase {

    /**
     * Setup test data.
     */
    public function setUp() {
        $this->resetAfterTest();
        $this->setAdminUser();
    }

    /**
     * Test user_created and assignment in cohort.
     */
    public function test_user_created() {
        global $CFG, $DB;

        // Create the cohort 1.
        $cohort1 = array(
            'categorytype' => array('type' => 'id', 'value' => '1'),
            'name' => 'cohort test 1',
            'idnumber' => 'cohorttest1',
            'description' => 'This is a description for cohorttest1'
            );

        // Create the cohort 2.
        $cohort2 = array(
            'categorytype' => array('type' => 'id', 'value' => '1'),
            'name' => 'cohort test 2',
            'idnumber' => 'cohorttest2',
            'description' => 'This is a description for cohorttest2'
            );

        // Create the cohort 2.
        $cohort3 = array(
            'categorytype' => array('type' => 'id', 'value' => '1'),
            'name' => 'cohort test 3',
            'idnumber' => 'cohorttest3',
            'description' => 'This is a description for cohorttest3'
            );

			// Call the external function.
        $createdcohorts = core_cohort_external::create_cohorts(array($cohort1, $cohort2, $cohort3));
        // Check we retrieve the good total number of created cohorts + no error on capability.
        $this->assertEquals(3, count($createdcohorts),"Create cohort");

		$username = 'orangerules'.sha1(time());

        // Create the rule based on emails.
        $rule1 = new stdClass();
        $rule1->id = 0;
        $rule1->name = "Rule 1";
        $rule1->cohortid = $createdcohorts[0]['id'];
        $rule1->emails = "11111111@yopmail.com\n22222222@yopmail.com\n" . $username . "@orangetest.com\n"."33333333@yopmail.com\n44444444@yopmail.com\n";
        $rule1->domains = "";
        rule_add_rule($rule1);

        // Create the rule based on domains.
        $rule2 = new stdClass();
        $rule2->id = 0;
        $rule2->name = "Rule 2";
        $rule2->cohortid = $createdcohorts[1]['id'];
        $rule2->emails = "";
        $rule2->domains = "yopmail.com\nhotmail.com\norangetest.com\ngmail.com";
        rule_add_rule($rule2);

        // Create the rule based on emails with no match.
        $rule3 = new stdClass();
        $rule3->id = 0;
        $rule3->name = "Rule 3";
        $rule3->cohortid = $createdcohorts[2]['id'];
        $rule3->emails = "12345678@orangetest.com";
        $rule3->domains = "";
        rule_add_rule($rule3);
		
		// Create a user.
        $record = array('firstname' => 'User',
        'lastname' => 'User', 'username' => $username, 'email' => $username . '@orangetest.com', 'confirm' => true);
        $user = $this->getDataGenerator()->create_user($record);
        $this->assertEquals(1, count($user),"Create user in database");
		
		// Create the event related to the user create.
		\core\event\user_created::create_from_userid($user->id)->trigger();
		
        // Check if user has been asign to the cohort 1.
        $this->assertEquals(true, cohort_is_member($createdcohorts[0]['id'], $user->id),"Assign to cohort based on rule 1 - emails");

        // Check if user has been asign to the cohort 2.
        $this->assertEquals(true, cohort_is_member($createdcohorts[1]['id'], $user->id),"Assign to cohort based on rule 2 - domains");

        // Check that user has not been asign to the cohort 3.
        $this->assertEquals(false, cohort_is_member($createdcohorts[2]['id'], $user->id),"No assign to cohort based on rule 3");
	}
}