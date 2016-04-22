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

class extended_course_object_test extends advanced_testcase {

    public static function setUpBeforeClass() {
        global $DB;
        parent::setUpBeforeClass();
        $record = array('id' => 461,
            'courseid' => 2,
            'format' => 'flexpage',
            'sectionid' => 0,
            'name' => 'coursebadge',
            'value'=>1);

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