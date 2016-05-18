<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of extended_course_object_test
 *
 * @author ajby6350
 */

use local_orange_library\extended_course\extended_course_object;



/**
 * @see course_format_flexpage_model_cache
 */
require_once($CFG->dirroot.'/local/orange_library/classes/extended_course/extended_course_object.php');

Mock::generate('local_orange_library_classes_extended_course_extended_course_object', 'mock_local_orange_library_classes_extended_course_extended_course_object');
class extended_course_object_test extends UnitTestCase {

        /**
     * Load required classes.
     */
    public function setUp() {
        // Load the mock info class so that it can be used.
        global $CFG;
        require_once($CFG->dirroot . '/orange_library/tests/fixtures/mock_extended_course_object.php');
    }

    public function testFactory()
    {
        $body = EntityBody::factory('data');
        $this->assertEquals('data', (string) $body);
        $this->assertEquals(4, $body->getContentLength());
        $this->assertEquals('PHP', $body->getWrapper());
        $this->assertEquals('TEMP', $body->getStreamType());

        $handle = fopen(__DIR__ . '/../../../../phpunit.xml.dist', 'r');
        if (!$handle) {
            $this->fail('Could not open test file');
        }
        $body = EntityBody::factory($handle);
        $this->assertEquals(__DIR__ . '/../../../../phpunit.xml.dist', $body->getUri());
        $this->assertTrue($body->isLocal());
        $this->assertEquals(__DIR__ . '/../../../../phpunit.xml.dist', $body->getUri());
        $this->assertEquals(filesize(__DIR__ . '/../../../../phpunit.xml.dist'), $body->getContentLength());

        // make sure that a body will return as the same object
        $this->assertTrue($body === EntityBody::factory($body));
    }

    public static function setUpBeforeClass() {
        global $DB;
        parent::setUpBeforeClass();
        $id=0;
        $this->save_extended_course_value($id, 1, 'flexpage', 0, 'table', "course_format_options");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'enddate', 1467496800);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'picture', 381002270);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'replay', "Rejouable");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'duration', 5);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'workingtime', 1);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'badge', 1);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'certification', 1);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'price', "Mooc gratuit<br>certification en option");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'language', "Français");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'subtitle', 1);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'registration', 0);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'registrationcompany', 7);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'maxregisteredusers', 1000);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'registrationstartdate', 1462377425);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'registrationenddate', 1467496800);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'prerequesites', "<p>Prérequis</p>");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'teachingteam', "<p>Équipe pédagogique</p>");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'enrolurl', "http://10.194.54.237/enrol/orangeinvitation/enrol.php?enrolinvitationtoken=92a0490d5105b109df86074dc430e3e6&id=2&id2=1");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'unenrolurl', array
        (
            "scheme" => "http",
            "host" => "solerni",
            "port" => "",
            "user" => "",
            "pass"=> "",
            "path" => '/enrol/self/unenrolself.php',
            "slashargument" => "",
            "anchor"=> "",
            "params" => Array
                (
                    "enrolid" => 3
                )

        ));
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'coursestatus', 6);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'registrationstatustext', "Inscription ouverte");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'replay', "Rejouable");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'statuslink', array
        (
            "scheme" => "http",
            "host" => "solerni",
            "port" => "",
            "user" => "",
            "pass"=> "",
            "path" => '/enrol/self/unenrolself.php',
            "slashargument" => "",
            "anchor"=> "",
            "params" => Array
                (
                    "enrolid" => 3
                )

        ));
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'statustext', "En cours");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'coursestatustext', "En cours");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'registrationstatus', 1);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'registrationstatustext', "Inscription ouverte");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'thumbnailtext', "cours a venir / ouvert et places dispo");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'enrolledusers', 2);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'enrolledusersself', 2);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'enrolstartdate', 1434618300);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'enrolenddate', 1468832700);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'displaybutton', '<a class="btn btn-success" href="http://solerni/course/view.php?id=2" data-mooc-name="a venir ouvert et places dispos">Accéder au cours</a>');
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'videoplayer', '<iframe width="560" height="315" src="https://www.youtube.com/embed/bNfYUsDSrOs?rel=0" frameborder="0" allowfullscreen></iframe>');
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'inactivitydelay', 7);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'contactemail', "contact@email.com");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'newsessionurl', 'http://10.194.54.237/enrol/orangeinvitation/enrol.php?enrolinvitationtoken=92a0490d5105b109df86074dc430e3e6&id=2&id2=2');
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'moocurl', Array
        (
            "scheme" => "http",
            "host" => "solerni",
            "port" => "",
            "user" => "",
            "pass" => "",
            "path" => "/course/view.php",
            "slashargument" => "",
            "anchor" => "",
            "params" => Array
                (
                    "id"=> 2
                )

        ));
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'statuslinktext', '');

    }

    private function make_record($id, $courseid, $format, $sectionid, $name, $value) {
        return array('id' => $id,
        'courseid' => $courseid,
        'format' => '$format',
        'sectionid' => $sectionid,
        'name' => '$name',
        'value'=>$value);

    }

    private function save_extended
    private function save_extended_course_value($id, $courseid, $format, $sectionid, $name, $value){
        $record = make_record($id, $courseid, $format, $sectionid, $name, $value);
        $DB->insert_record('course_format_options', $record);
    }
    public function test_set_extended_course() {

        $this->resetAfterTest(true);
        $user = $this->getDataGenerator()->create_user(array('email'=>'user1@yopmail.com', 'username'=>'user1'));
        $this->setUser($user);
        $this->setGuestUser();

        $course1 = $this->getDataGenerator()->create_course();

        $category = $this->getDataGenerator()->create_category();
        $course2 = $this->getDataGenerator()->create_course(array('name' => 'Some course', 'category'=>$category->id));

        $extended_course = new extended_course_object();
        $extended_course->get_extended_course($course2);
        $this->assertEquals(0, $extended_course->enrolledusers);
    }

}