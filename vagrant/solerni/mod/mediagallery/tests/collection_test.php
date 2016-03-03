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

class mod_mediagallery_collection_testcase extends advanced_testcase {

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

    public function test_user_can_add_children() {
        $options = array('colltype' => 'contributed', 'course' => $this->course->id, 'groupmode' => VISIBLEGROUPS, 'maxgalleries' => 1);
        $record = $this->getDataGenerator()->create_module('mediagallery', $options);
        $collection = new \mod_mediagallery\collection($record);

        $group1 = $this->getDataGenerator()->create_group(array('courseid' => $this->course->id));
        $group2 = $this->getDataGenerator()->create_group(array('courseid' => $this->course->id));
        $this->getDataGenerator()->create_group_member((object)array('groupid' => $group1, 'userid' => $this->students[0]->id));
        $this->getDataGenerator()->create_group_member((object)array('groupid' => $group2, 'userid' => $this->students[0]->id));
        $this->getDataGenerator()->create_group_member((object)array('groupid' => $group2, 'userid' => $this->students[1]->id));

        $this->assertTrue($collection->user_can_add_children($this->students[0]->id));
        $this->assertTrue($collection->user_can_add_children($this->students[1]->id));

        $generator = self::getDataGenerator()->get_plugin_generator('mod_mediagallery');
        $record = array(
            'name' => 'Test gallery G1',
            'instanceid' => $collection->id,
            'contributable' => 1,
            'userid' => $this->students[0]->id,
            'groupid' => $group1->id,
        );
        $generator->create_gallery($record);

        // Limit is one per group, as both are in group2 which has no gallery yet, they should both still be able to add.
        $this->assertTrue($collection->user_can_add_children($this->students[0]->id));
        $this->assertTrue($collection->user_can_add_children($this->students[1]->id));

        $record = array(
            'name' => 'Test gallery G2',
            'instanceid' => $collection->id,
            'contributable' => 1,
            'userid' => $this->students[0]->id,
            'groupid' => $group2->id,
        );
        $generator->create_gallery($record);

        // Now that group2 has a gallery, neither should be able to add a new gallery.
        $this->assertFalse($collection->user_can_add_children($this->students[0]->id));
        $this->assertFalse($collection->user_can_add_children($this->students[1]->id));

        // Now test with a non-groupmode collection.
        $options = array('colltype' => 'contributed', 'course' => $this->course->id, 'groupmode' => NOGROUPS, 'maxgalleries' => 1);
        $record = $this->getDataGenerator()->create_module('mediagallery', $options);
        $collection = new \mod_mediagallery\collection($record);

        $this->assertTrue($collection->user_can_add_children($this->students[0]->id));
        $this->assertTrue($collection->user_can_add_children($this->students[1]->id));

        $generator = self::getDataGenerator()->get_plugin_generator('mod_mediagallery');
        $record = array(
            'name' => 'Test gallery G1',
            'instanceid' => $collection->id,
            'contributable' => 1,
            'userid' => $this->students[0]->id,
        );
        $generator->create_gallery($record);

        // Limit is one per user, not in groupmode so groups don't matter.
        $this->assertFalse($collection->user_can_add_children($this->students[0]->id));
        $this->assertTrue($collection->user_can_add_children($this->students[1]->id));
    }
}
