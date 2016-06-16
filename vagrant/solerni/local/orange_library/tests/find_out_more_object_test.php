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

class find_out_more_object_test extends advanced_testcase {

    /**
     * Load required classes.
     */
    public function setUp() {
        // Load the mock info class so that it can be used.
        global $CFG;
        require_once($CFG->dirroot . '/course/lib.php');
        require_once($CFG->dirroot . '/local/orange_library/tests/fixtures/mock_find_out_more.php');
        /**
         * @see course_format_flexpage_model_cache
         */
        require_once($CFG->dirroot.'/local/orange_library/classes/find_out_more/find_out_more_object.php');
        $this->setAdminUser();
    }

    public function test_extended_course() {
        global $DB;

        $category = $this->getDataGenerator()->create_category();
        $course = $this->getDataGenerator()->create_course(array('name'=>'Some course', 'category'=>$category->id));
        $mockextendedcourse = new \local_orange_library_tests_fixtures_mock_find_out_more\mock_find_out_more($course);
        $structure = "";
        $mockextendedcourse->mock_factory($course);

        $mockextendedcourse->get_find_out_more($course);


        $this->assertEquals("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", $mockextendedcourse->paragraphdescription[0]);
        $this->assertEquals("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", $mockextendedcourse->paragraphdescription[1]);
        $this->assertEquals("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", $mockextendedcourse->paragraphdescription[2]);
        $this->assertEquals("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", $mockextendedcourse->paragraphdescription[3]);
        $this->assertEquals("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", $mockextendedcourse->paragraphdescription[4]);
        $this->assertEquals("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", $mockextendedcourse->paragraphdescription[5]);
        $this->assertEquals("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", $mockextendedcourse->paragraphdescription[6]);
        $this->assertEquals("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", $mockextendedcourse->paragraphdescription[7]);
        $this->assertEquals("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", $mockextendedcourse->paragraphdescription[8]);
        $this->assertEquals("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", $mockextendedcourse->paragraphdescription[9]);

        $this->assertEquals("Titre Paragraphe 1", $mockextendedcourse->paragraphtitle[0]);
        $this->assertEquals("Titre Paragraphe 2", $mockextendedcourse->paragraphtitle[1]);
        $this->assertEquals("Titre Paragraphe 3", $mockextendedcourse->paragraphtitle[2]);
        $this->assertEquals("Titre Paragraphe 4", $mockextendedcourse->paragraphtitle[3]);
        $this->assertEquals("Titre Paragraphe 5", $mockextendedcourse->paragraphtitle[4]);
        $this->assertEquals("Titre Paragraphe 6", $mockextendedcourse->paragraphtitle[5]);
        $this->assertEquals("Titre Paragraphe 7", $mockextendedcourse->paragraphtitle[6]);
        $this->assertEquals("Titre Paragraphe 8", $mockextendedcourse->paragraphtitle[7]);
        $this->assertEquals("Titre Paragraphe 9", $mockextendedcourse->paragraphtitle[8]);
        $this->assertEquals("Titre Paragraphe 10", $mockextendedcourse->paragraphtitle[9]);

        $this->assertEquals('bg-green', $mockextendedcourse->paragraphbgcolor[0]);
        $this->assertEquals('bg-graylighter', $mockextendedcourse->paragraphbgcolor[1]);
        $this->assertEquals('bg-red', $mockextendedcourse->paragraphbgcolor[2]);
        $this->assertEquals('bg-graylighter', $mockextendedcourse->paragraphbgcolor[3]);
        $this->assertEquals('bg-yellow', $mockextendedcourse->paragraphbgcolor[4]);
        $this->assertEquals('bg-graylighter', $mockextendedcourse->paragraphbgcolor[5]);
        $this->assertEquals('bg-blue', $mockextendedcourse->paragraphbgcolor[6]);
        $this->assertEquals('bg-graylighter', $mockextendedcourse->paragraphbgcolor[7]);
        $this->assertEquals('bg-pink', $mockextendedcourse->paragraphbgcolor[8]);
        $this->assertEquals('bg-graylighter', $mockextendedcourse->paragraphbgcolor[9]);


        $this->assertEquals(181464878, $mockextendedcourse->paragraphpicture[0]);
        $this->assertEquals(435990855, $mockextendedcourse->paragraphpicture[1]);
        $this->assertEquals(257556141, $mockextendedcourse->paragraphpicture[2]);
        $this->assertEquals(972257379, $mockextendedcourse->paragraphpicture[3]);
        $this->assertEquals(25516927, $mockextendedcourse->paragraphpicture[4]);
        $this->assertEquals(635357878, $mockextendedcourse->paragraphpicture[5]);
        $this->assertEquals(396585880, $mockextendedcourse->paragraphpicture[6]);
        $this->assertEquals(412869366, $mockextendedcourse->paragraphpicture[7]);
        $this->assertEquals(653207731, $mockextendedcourse->paragraphpicture[8]);
        $this->assertEquals(730279675, $mockextendedcourse->paragraphpicture[9]);

    }

         public function test_deleting() {
         //global $DB;
         $this->resetAfterTest(false);
         //$DB->delete_records('course_format_options');
         //$this->assertEmpty($DB->get_records('course_format_options'));
     }

}