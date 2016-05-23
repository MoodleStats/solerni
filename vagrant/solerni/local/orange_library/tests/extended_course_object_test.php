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
require_once($CFG->dirroot.'/local/orange_library/classes/extended_course/extended_course_object.php');


class extended_course_object_test extends UnitTestCase {

        /**
     * Load required classes.
     */
    public function setUp() {
        // Load the mock info class so that it can be used.
        global $CFG;
        require_once($CFG->dirroot . '/local/orange_library/tests/fixtures/mock_extended_course.php');

    }

    public function test_extended_course() {
        global $DB;

        // Create a course and pages.
        $this->setAdminUser();
        $this->resetAfterTest();
        $generator = $this->getDataGenerator();
        $course = $generator->create_course();
        $mock = new orange_library_extended_course\mock_extended_course();
        $course2 = $this->getDataGenerator()->create_course(array('name' => 'Some course', 'category'=>$category->id));
        $structure = "";
        $mock->mock_factory($course2);
        $mockextendedcourse->get_extended_course($mock);



        // Do availability and full information checks.

        $this->assertTrue($mockextendedcourse->coursebadge);
        $this->assertTrue($mockextendedcourse->coursecertification);
        $this->assertEquals('contact@email.com', $mockextendedcourse->coursecontactemail);
        $this->assertEquals(3024000, $mockextendedcourse->courseduration);
        $this->assertEquals(7, $mockextendedcourse->courseinactivitydelay);
        $this->assertFalse($mockextendedcourse->courselanguage);
        $this->assertTrue($mockextendedcourse->coursemaxregisteredusers);
        $this->assertEquals(381002270, $mockextendedcourse->coursepicture);
        $this->assertEquals("<p>Prérequis</p>", $mockextendedcourse->courseprerequesites);
        $this->assertTrue($mockextendedcourse->courseprice);
        $this->assertFalse($mockextendedcourse->courseregistration);
        $this->assertFalse($mockextendedcourse->coursereplay);
        $this->assertTrue($mockextendedcourse->coursesubtitle);
        $this->assertEquals("<p>Équipe pédagogique</p>", $mockextendedcourse->courseteachingteam);
        $this->assertTrue($mockextendedcourse->coursethematics);
        $this->assertEquals("cours a venir / ouvert et places dispo", $mockextendedcourse->coursethumbnailtext);
        $this->assertFalse($mockextendedcourse->coursevideo);
        $this->assertEquals(7200, $mockextendedcourse->courseworkingtime);
        $this->assertContains('<iframe', $mockextendedcourse->coursevideoplayer);
        $this->assertContains('></iframe>', $mockextendedcourse->coursevideoplayer);
        $this->assertEquals('contact@email.com', $mockextendedcourse->coursecontactemail);
        $this->assertEquals('contact@email.com', $mockextendedcourse->coursecontactemail);

    }

    public static function setUpBeforeClass() {
        parent::setUpBeforeClass();

    }

    private function make_record($id, $courseid, $format, $sectionid, $name, $value) {
        return array('id' => $id,
        'courseid' => $courseid,
        'format' => '$format',
        'sectionid' => $sectionid,
        'name' => '$name',
        'value'=>$value);

    }

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