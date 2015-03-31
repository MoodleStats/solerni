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
 * @package    core_backup
 * @category   phpunit
 * @copyright  2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Include all the needed stuff
global $CFG;
require_once($CFG->dirroot . '/backup/util/includes/backup_includes.php');


/**
 * Instantiable class extending base_plan in order to be able to perform tests
 */
class mock_base_plan extends base_plan {
	public function build() {
	}

	public function get_progress() {
		return null;
	}
}

/**
 * Instantiable class extending base_step in order to be able to perform tests
 */
class mock_base_step extends base_step {
	public function execute() {
	}
}

/**
 * Instantiable class extending backup_step in order to be able to perform tests
 */
class mock_backup_step extends backup_step {
	public function execute() {
	}
}

/**
 * Instantiable class extending backup_task in order to mockup get_taskbasepath()
 */
class mock_backup_task_basepath extends backup_task {

	public function build() {
		// Nothing to do
	}

	public function define_settings() {
		// Nothing to do
	}

	public function get_taskbasepath() {
		global $CFG;
		return $CFG->tempdir . '/test';
	}
}

	/**
	 * Instantiable class extending backup_structure_step in order to be able to perform tests
	 */
class mock_backup_structure_step extends backup_structure_step {

	protected function define_structure() {

		// Create really simple structure (1 nested with 1 attr and 2 fields)
		$test = new backup_nested_element('test',
				array('id'),
				array('field1', 'field2')
		);
		$test->set_source_array(array(array('id' => 1, 'field1' => 'value1', 'field2' => 'value2')));

		return $test;
	}
}

/**
 * Instantiable class extending activity_backup_setting to be added to task and perform tests
 */
class mock_fullpath_activity_setting extends activity_backup_setting {
	public function process_change($setting, $ctype, $oldv) {
		// Nothing to do
	}
}

	/**
	 * Instantiable class extending activity_backup_setting to be added to task and perform tests
	 */
class mock_backupid_activity_setting extends activity_backup_setting {
	public function process_change($setting, $ctype, $oldv) {
		// Nothing to do
	}
}

	/**
	 * Instantiable class extending base_task in order to be able to perform tests
	 */
class mock_base_task extends base_task {
	public function build() {
	}

	public function define_settings() {
	}
}

/**
 * Instantiable class extending backup_task in order to be able to perform tests
 */
class mock_backup_task extends backup_task {
	public function build() {
	}

	public function define_settings() {
	}
}
