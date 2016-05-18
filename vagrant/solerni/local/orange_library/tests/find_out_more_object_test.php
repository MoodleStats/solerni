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

use local_orange_library\extended_course\find_out_more_object;

class find_out_more_object_test extends advanced_testcase {

    public static function setUpBeforeClass() {
        global $DB;
        parent::setUpBeforeClass();
        $record = array('id' => 461,
            'courseid' => 2,
            'format' => 'flexpage',
            'sectionid' => 0,
            'name' => 'coursetest',
            'value'=>1);

        $DB->insert_record('course_format_options', $record);

    }

    public function test_set_find_out_more() {

        $this->resetAfterTest(true);
        $user = $this->getDataGenerator()->create_user(array('email'=>'user1@yopmail.com', 'username'=>'user1'));
        $this->setUser($user);
        $this->setGuestUser();

        $course1 = $this->getDataGenerator()->create_course();

        $category = $this->getDataGenerator()->create_category();
        $course2 = $this->getDataGenerator()->create_course(array('name' => 'Some course', 'category'=>$category->id));

        $find_out_more_course = new find_out_more_object();
        $find_out_more_course->get_extended_course($course2);
        $this->assertEquals(0, $find_out_more_course->enrolledusers);
    }
    

}