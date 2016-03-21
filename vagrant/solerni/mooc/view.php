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
 * Displays user my moocs page
 *
 * @package    core
 * @subpackage moocs
 * @copyright  Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use local_orange_library\utilities\utilities_course;

require_once(dirname(dirname(__FILE__)) . '/config.php');
require_once($CFG->dirroot.'/blocks/course_overview/locallib.php');
require_once($CFG->dirroot.'/blocks/orange_action/block_orange_action.php');
require_once($CFG->dirroot.'/blocks/orange_social_sharing/block_orange_social_sharing.php');
require_once($CFG->dirroot.'/blocks/orange_social_following/block_orange_social_following.php');
require_once($CFG->dirroot.'/blocks/orange_iconsmap/block_orange_iconsmap.php');
require_once($CFG->dirroot.'/blocks/orange_separator_line/block_orange_separator_line.php');
require_once($CFG->dirroot.'/blocks/orange_action/renderer.php');




$filter      = optional_param('filter', utilities_course::MOOCRUNNING, PARAM_INT);

//require_login();

$url = new moodle_url('/mooc/index.php');
$courseid      = optional_param('id', 0, PARAM_INT); // Course Module ID.
$context = context_course::instance($courseid);
$PAGE->set_url($url);
$PAGE->blocks->add_region('main');
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$PAGE->set_course($course);

$PAGE->set_context($context);

    $block_orange_action = new block_orange_action();
    $orange_action = new block_contents(array('class' => 'block_orange_action'));
    $orange_action->content = $block_orange_action->get_content()->text;
    $PAGE->blocks->add_fake_block($orange_action, 'main');

    $block_orange_iconsmap = new block_orange_iconsmap();
    $orange_iconsmap = new block_contents(array('class' => 'block_orange_iconsmap'));
    print_object($block_orange_iconsmap->get_content());
    $orange_iconsmap->content = $block_orange_iconsmap->get_content()->text;
    $PAGE->blocks->add_fake_block($orange_iconsmap, 'main');

    $block_orange_separator_line = new block_orange_separator_line();
    $orange_separator_line = new block_contents(array('class' => 'block_orange_separator_line'));
    $orange_separator_line->content = $block_orange_separator_line->get_content()->text;
    $PAGE->blocks->add_fake_block($orange_separator_line, 'main');

    $block_orange_social_sharing = new block_orange_social_sharing();
    $orange_social_sharing = new block_contents(array('class' => 'block_orange_social_sharing'));
    $orange_social_sharing->content = $block_orange_social_sharing->get_content()->text;
    $PAGE->blocks->add_fake_block($orange_social_sharing, 'main');

    $block_orange_separator_line = new block_orange_separator_line();
    $orange_separator_line = new block_contents(array('class' => 'block_orange_separator_line'));
    $orange_separator_line->content = $block_orange_separator_line->get_content()->text;
    $PAGE->blocks->add_fake_block($orange_separator_line, 'main');

    $block_orange_social_following = new block_orange_social_following();
    $orange_social_following = new block_contents(array('class' => '$block_orange_social_following'));
    $orange_social_following->content = $block_orange_social_following->get_content()->text;
    $PAGE->blocks->add_fake_block($orange_social_following, 'main');

echo $OUTPUT->header();


echo $OUTPUT->footer();
