<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/tests/fixtures/format_theunittest.php');

class observer_testcase extends advanced_testcase {
    public function test_course_created_with_bad_id() {
        $event = new \core\event\course_created();
        $event->courseid = 1;
        $result = local_orange_event_course_created_observer::course_created($event);
        $this->assertFalse($result);
    }
  }