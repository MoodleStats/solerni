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
 * Event observers used in local_orange_customers.
 *
 * @package    local
 * @subpackage orange_customers
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/local/orange_customers/lib.php');

/**
 * Event observer for local_orange_customers.
 */
class local_orange_customers_observer {


    /**
     * Triggered via course_category_created event.
     *
     * @param \core\event\course_category_created $event
     */

    public static function customer_created(\core\event\course_category_created $event) {
        global $DB;

        $category = (object)$event->get_record_snapshot('course_categories', $event->objectid);
        $customer = new stdClass();
        $customer->name = $category->name;
        $customer->categoryid = $category->id;

        $DB->insert_record('orange_customers', $customer, false);

    }

    /**
     * Triggered via course_category_updated event.
     *
     * @param \core\event\course_category_updated $event
     */
    public static function customer_updated(\core\event\course_category_updated $event) {
        global $DB;

        $category = (object)$event->get_record_snapshot('course_categories', $event->objectid);

        $customer = customer_get_customerbycategoryid($category->id);

        if ($customer === false) {
            $customer = new stdClass();
            $customer->name = $category->name;
            $customer->categoryid = $category->id;
            $DB->insert_record('orange_customers', $customer, false);
        } else {
            $DB->execute("UPDATE {orange_customers}
        		          SET name = '". str_replace("'", "\'", $category->name) . "'
        		          WHERE categoryid = ". $category->id );
        }

    }

    /**
     * Triggered via course_category_deleted event.
     *
     * @param \core\event\course_category_deleted $event
     */
    public static function customer_deleted(\core\event\course_category_deleted $event) {
        global $DB;

        $DB->execute("DELETE FROM {orange_customers} WHERE categoryid = ". $event->objectid );

    }

}
