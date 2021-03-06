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
 * To add the Orange_customers links to the administration block
 *
 * @package    local
 * @subpackage orange_customer
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$orangeplugin = 'local_orange_customers';
$orangelistcustomersurl = '/local/orange_customers/index.php?sesskey=' . sesskey().'&action=customers_list';

if ($hassiteconfig or has_capability('local/orange_customers:edit', context_system::instance())) {

    $ADMIN->add('root', new admin_category('customer', get_string('customerslink', $orangeplugin)));

    $ADMIN->add('customer', new admin_externalpage('orange_customers_level2', get_string('customerslinklist', $orangeplugin),
        new moodle_url($orangelistcustomersurl),
        array('local/orange_customers:edit')
        ));

    $ADMIN->add('customer',
        new admin_externalpage('customercoursemgmt', get_string('customerslinkadd', $orangeplugin),
        $CFG->wwwroot . '/course/management.php',
        array('moodle/category:manage', 'moodle/course:create')
        ));
}