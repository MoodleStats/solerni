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
 * orange_course_home block renderer
 *
 * @package    block_orange_course_home
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configtext('block_orange_course_home/defaultmaxcourses',
                        new lang_string('defaultmaxcourses', 'block_orange_course_home'),
                        new lang_string('defaultmaxcoursesdesc', 'block_orange_course_home'), 3, PARAM_INT));
    $settings->add(new admin_setting_configtext('block_orange_course_home/catalogurl',
                        new lang_string('definecatalogurl', 'block_orange_course_home'),
                        new lang_string('definecatalogurldesc', 'block_orange_course_home'), '/catalog/', PARAM_URL));
}