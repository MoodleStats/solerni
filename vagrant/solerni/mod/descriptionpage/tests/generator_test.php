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
 * PHPUnit data generator tests
 *
 * @package    mod_descriptionpage
 * @category   phpunit
 * @package mod_descriptionpage
  * @copyright  2015 Orange based on mod_page plugin from 2009 Petr Skoda (http://skodak.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();


/**
 * PHPUnit data generator testcase
 *
 * @package    mod_descriptionpage
 * @category   phpunit
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_page_generator_testcase extends advanced_testcase {
    public function test_generator() {
        global $DB, $SITE;

        $this->resetAfterTest(true);

        $this->assertEquals(0, $DB->count_records('descriptionpage'));

        // Comment @var mod_page_generator $generator.
        $generator = $this->getDataGenerator()->get_plugin_generator('mod_descriptionpage');
        $this->assertInstanceOf('mod_page_generator', $generator);
        $this->assertEquals('descriptionpage', $generator->get_modulename());

        $generator->create_instance(array('course' => $SITE->id));
        $generator->create_instance(array('course' => $SITE->id));
        $page = $generator->create_instance(array('course' => $SITE->id));
        $this->assertEquals(3, $DB->count_records('descriptionpage'));

        $cm = get_coursemodule_from_instance('descriptionpage', $page->id);
        $this->assertEquals($page->id, $cm->instance);
        $this->assertEquals('descriptionpage', $cm->modname);
        $this->assertEquals($SITE->id, $cm->course);

        $context = context_module::instance($cm->id);
        $this->assertEquals($page->cmid, $context->instanceid);
    }
}
