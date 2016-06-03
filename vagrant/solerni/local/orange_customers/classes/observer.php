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
use local_orange_library\utilities\utilities_piwik;
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
        global $CFG;

        $category = (object)$event->get_record_snapshot('course_categories', $event->objectid);
        self::orange_customer_created($category);
        if (!$CFG->solerni_isprivate) {
            self::piwik_segment_created($category);
        }
    }

    /**
     * Triggered via course_category_updated event.
     *
     * @param \core\event\course_category_updated $event
     */
    public static function customer_updated(\core\event\course_category_updated $event) {
        global $DB;

        $category = (object)$event->get_record_snapshot('course_categories', $event->objectid);
        self::orange_customer_created($category);
        if ((!$CFG->solerni_isprivate) && ($customer === true)) {
            self::piwik_segment_created($category);
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

    private static function orange_customer_created($category) {
        global $DB;

        $customer = new stdClass();
        $customer->name = $category->name;
        $customer->categoryid = $category->id;
        $DB->insert_record('orange_customers', $customer, false);
    }

    private static function orange_customer_updated($category) {
        global $DB;

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

    private static function piwik_segment_created($category) {
        global $CFG;

        $tokenauth = '&token_auth='.$CFG->piwik_token_admin;
        $url = $CFG->piwik_internal_url;
        $module = 'module=API';
        $methodsegment = '&method=SegmentEditor.add';
        $name = '&name='.$category->name;
        $definition = '&definition=customVariablePageValue3=='.$category->name;
        $login1 = '&login=admin';
        $login2 = '&login=market';
        $idsite = '&idSite=1';
        $autoarchive = '&autoArchive=0';
        $enabledallusers = '&enabledAllUsers=0';
        $urlsegment1 = $url.'?'.$module.$methodsegment.$name.$definition.$idsite.$autoarchive.$enabledallusers.$login1.$tokenauth;
        $urlsegment2 = $url.'?'.$module.$methodsegment.$name.$definition.$idsite.$autoarchive.$enabledallusers.$login2.$tokenauth;
        $xmlaccount1 = utilities_piwik::xml_from_piwik($urlsegment1);
        $xmlaccount2 = utilities_piwik::xml_from_piwik($urlsegment2);
        if ((is_int($xmlaccount1) === false)|| (is_int($xmlaccount2)) === false) {
            error_log('problem to create a piwik segment for this customer');
        }
    }
}