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
 * course_overview block settings
 *
 * @package    block_course_overview
 * @copyright  2012 Adam Olley <adam.olley@netspot.com.au>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

// Config in site admin/plugins/blocks/Orange Course Dashboard
if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configtext('block_orange_course_dashboard/defaultmaxcourses',
                        new lang_string('defaultmaxcourses', 'block_orange_course_dashboard'),
                        new lang_string('defaultmaxcoursesdesc', 'block_orange_course_dashboard'), 10, PARAM_INT));
    $settings->add(new admin_setting_configtext('block_orange_course_dashboard/defaultmaxrecommendations',
                        new lang_string('defaultmaxrecommendations', 'block_orange_course_dashboard'),
                        new lang_string('defaultmaxrecommendationsdesc', 'block_orange_course_dashboard'), 4, PARAM_INT));
    $settings->add(new admin_setting_configcheckbox('block_orange_course_dashboard/showchildren',
                        new lang_string('showchildren', 'block_orange_course_dashboard'),
                        new lang_string('showchildrendesc', 'block_orange_course_dashboard'), 1, PARAM_INT));
    $settings->add(new admin_setting_configtext('block_orange_course_dashboard/catalogurl',
                        new lang_string('definecatalogurl', 'block_orange_course_dashboard'),
                        new lang_string('definecatalogurldesc', 'block_orange_course_dashboard'), '', PARAM_URL));
    $settings->add(new admin_setting_configtext('block_orange_course_dashboard/mymoocsurl',
                        new lang_string('definemymoocsurl', 'block_orange_course_dashboard'),
                        new lang_string('definemymoocsurldesc', 'block_orange_course_dashboard'), '/moocs/mymoocs.php', PARAM_URL));
    $settings->add(new admin_setting_configcheckbox('block_orange_course_dashboard/hideblockheader',
                        new lang_string('hideblockheader', 'block_orange_course_dashboard'),
                        new lang_string('hideblockheaderdesc', 'block_orange_course_dashboard'), 1, PARAM_INT));
    $settings->add(new admin_setting_configcheckbox('block_orange_course_dashboard/forcednoavailabalemooc',
                        new lang_string('forcednoavailabalemooc', 'block_orange_course_dashboard'),
                        new lang_string('forcednoavailabalemoocdesc', 'block_orange_course_dashboard'), 1, PARAM_INT));
}
