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

defined('MOODLE_INTERNAL') || die();

global $CFG;

class mod_mediagallery_base_testcase extends advanced_testcase {

    protected $course;

    protected $teachers = array();
    protected $students = array();

    /**
     * Setup function - we will create a course and add a mediagallery instance to it.
     */
    protected function setUp() {
        global $DB;

        $this->resetAfterTest(true);

        $this->course = $this->getDataGenerator()->create_course();

        $teacher1 = $this->getDataGenerator()->create_user();
        $student1 = $this->getDataGenerator()->create_user();
        $student2 = $this->getDataGenerator()->create_user();

        $editingteacherrole = $DB->get_record('role', array('shortname' => 'editingteacher'));
        $this->getDataGenerator()->enrol_user($teacher1->id,
                                              $this->course->id,
                                              $editingteacherrole->id);

        $studentrole = $DB->get_record('role', array('shortname' => 'student'));
        $this->getDataGenerator()->enrol_user($student1->id,
                                              $this->course->id,
                                              $studentrole->id);
        $this->getDataGenerator()->enrol_user($student2->id,
                                              $this->course->id,
                                              $studentrole->id);

        $this->teachers[] = $teacher1;
        $this->students[] = $student1;
        $this->students[] = $student2;
    }

    public function test_collection_read_only() {
        $options = array('colltype' => 'instructor', 'course' => $this->course->id);
        $record = $this->getDataGenerator()->create_module('mediagallery', $options);

        // Test instructor can write to an instructor collection and students can't.
        $collection = new \mod_mediagallery\collection($record);
        self::setUser($this->teachers[0]);
        $this->assertFalse($collection->is_read_only());
        self::setUser($this->students[0]);
        $this->assertTrue($collection->is_read_only());

        // Students can write when its not an instructor collection.
        $options = array('colltype' => 'contributed', 'course' => $this->course->id);
        $record = $this->getDataGenerator()->create_module('mediagallery', $options);
        $contributed = new \mod_mediagallery\collection($record);
        $this->assertFalse($contributed->is_read_only());
    }

    public function test_gallery_access_permissions() {
        $options = array('colltype' => 'contributed', 'course' => $this->course->id);
        $record = $this->getDataGenerator()->create_module('mediagallery', $options);
        $collection = new \mod_mediagallery\collection($record);

        // Contributed mode. Users can see each others galleries.
        self::setUser($this->students[0]);
        $record = array('name' => 'Test gallery', 'instanceid' => $collection->id);
        $gallery = self::getDataGenerator()->get_plugin_generator('mod_mediagallery')->create_gallery($record);

        $mygals = $collection->get_my_galleries();
        $this->assertTrue(isset($mygals[$gallery->id]));

        self::setUser($this->students[1]);
        $mygals = $collection->get_my_galleries();
        $this->assertFalse(isset($mygals[$gallery->id]));

        // Assignment mode. Users cannot see each others galleries.

        // Peer assessment mode. Users can see each others galleries.

        // Instructor mode. Users can see all galleries.

    }

}
