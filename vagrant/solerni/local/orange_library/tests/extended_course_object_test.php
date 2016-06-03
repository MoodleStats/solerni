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


class extended_course_object_test extends advanced_testcase {

    /**
     * Load required classes.
     */
    public function setUp() {
        // Load the mock info class so that it can be used.
        global $CFG;
        require_once($CFG->dirroot . '/course/lib.php');
        require_once($CFG->dirroot . '/local/orange_library/tests/fixtures/mock_extended_course.php');
        /**
         * @see course_format_flexpage_model_cache
         */
        require_once($CFG->dirroot.'/local/orange_library/classes/extended_course/extended_course_object.php');
        $this->setAdminUser();
    }

    public function test_extended_course() {
        global $DB;

        $category = $this->getDataGenerator()->create_category();
        $course = $this->getDataGenerator()->create_course(array('name'=>'Some course', 'category'=>$category->id));
        $mockextendedcourse = new \local_orange_library_tests_fixtures_mock_extended_course\mock_extended_course($course);
        $structure = "";
        $mockextendedcourse->mock_factory($course);

        $mockextendedcourse->get_extended_course($course);

        $this->assertTrue(true, $mockextendedcourse->coursebadge);
        $this->assertTrue(true, $mockextendedcourse->coursecertification);
        $this->assertEquals('contact@email.com', $mockextendedcourse->contactemail);
        $this->assertEquals(5, $mockextendedcourse->duration);
        $this->assertEquals(7, $mockextendedcourse->inactivitydelay);
        $this->assertFalse(false, $mockextendedcourse->language);
        $this->assertEquals(0, $mockextendedcourse->maxregisteredusers);
        $this->assertEquals(381002270, $mockextendedcourse->picture);
        $this->assertEquals("<p>Prérequis</p>", $mockextendedcourse->prerequesites);
        $this->assertEquals("free mooc<br>certification in option", $mockextendedcourse->price);
        $this->assertEquals(0, $mockextendedcourse->registration);
        $this->assertEquals("Replay", $mockextendedcourse->replay);
        $this->assertEquals(1, $mockextendedcourse->subtitle);
        $this->assertEquals("<p>Équipe pédagogique</p>", $mockextendedcourse->teachingteam);
        $this->assertEquals("cours a venir / ouvert et places dispo", $mockextendedcourse->thumbnailtext);
        $this->assertEquals(1, $mockextendedcourse->workingtime);
        $this->assertContains('<iframe', $mockextendedcourse->videoplayer);

    }

    public function test_deleting() {
        global $DB;
        $this->resetAfterTest(false);
    }

}