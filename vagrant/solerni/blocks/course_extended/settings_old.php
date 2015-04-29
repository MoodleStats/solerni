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
 * @package    blocks
 * @subpackage course_extended
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$settings->add(new admin_setting_heading(
            'headerconfig',
            get_string('headerconfig', 'block_course_extended'),
            get_string('descconfig', 'block_course_extended')
        ));

$settings->add(new admin_setting_configcheckbox(
            'course_extended/Allow_HTML',
            get_string('labelallowhtml', 'block_course_extended'),
            get_string('descallowhtml', 'block_course_extended'),
            '0'
        ));

