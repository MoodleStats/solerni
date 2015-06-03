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
 * Orange customers event handler definition.
 *
 * @package    local
 * @subpackage orange_customers
 * @category event
 * @copyright 2015 Orange
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$observers = array(

    array(
        'eventname'   => '\core\event\course_category_created',
        'callback'    => 'local_orange_customers_observer::customer_created',
    ),
    array(
        'eventname'   => '\core\event\course_category_updated',
        'callback'    => 'local_orange_customers_observer::customer_updated',
    ),
    array(
        'eventname'   => '\core\event\course_category_deleted',
        'callback'    => 'local_orange_customers_observer::customer_deleted',
    )


);
