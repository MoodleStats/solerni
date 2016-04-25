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
 * To add the Orange_opinion links to the administration block
 *
 * @package    local
 * @subpackage orange_opinion
 * @copyright  2016 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$orangeplugin = 'local_orange_opinion';
$orangelistopinionurl = '/local/orange_opinion/index.php?sesskey=' . sesskey().'&action=opinion_list';

if ($hassiteconfig or has_capability('local/orange_opinion:edit', context_system::instance())) {

    $ADMIN->add('root', new admin_category('opinion', get_string('opinionlink', $orangeplugin)));

    $ADMIN->add('opinion', new admin_externalpage('orange_opinion_level2', get_string('opinionlinklist', $orangeplugin),
        new moodle_url($orangelistopinionurl),
        array('local/orange_opinion:edit')
        ));
}