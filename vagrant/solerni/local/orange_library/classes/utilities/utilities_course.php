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
 * @package    orange_library
 * @subpackage utilities
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_orange_library\utilities;

use local_orange_library\extended_course\extended_course_object;
use local_orange_library\enrollment\enrollment_object;
use local_orange_library\utilities\utilities_image;
use context_user;
use context_course;
use context_helper;
use coursecat_sortable_records;
use course_in_list;

require_once($CFG->dirroot . '/cohort/lib.php');
require_once($CFG->dirroot . '/lib/coursecatlib.php'); // TODO : use course_in_list not working.
require_once($CFG->libdir.'/outputcomponents.php');

class utilities_course {

    const MOOCREGISTRATIONCOMPLETE  = 0;
    const MOOCREGISTRATIONOPEN      = 1;
    const MOOCREGISTRATIONSTOPPED   = 2;
    const MOOCREGISTRATIONNOTOPEN   = 3;

    const MOOCCLOSED                = 4;
    const MOOCNOTSTARTED            = 5;
    const MOOCRUNNING               = 6;

    /**
     * Get all Solerni informations for a course
     * using flexpage format (imply that we use the blocks/orange_course_extended)
     *
     * @global type $DB
     * @param type $course
     * @return extended_course_object
     */
    public static function solerni_course_get_customer_infos($catid) {

        global $CFG;
        require_once($CFG->dirroot . '/local/orange_customers/lib.php');
        $customer = customer_get_customerbycategoryid($catid);

        return $customer;
    }

    /**
     * Get all Solerni informations for a course
     * using flexpage format (imply that we use the blocks/orange_course_extended)
     *
     * @global type $DB
     * @param type $course
     * @return extended_course_object
     */
    public static function solerni_get_course_infos($course) {

        global $DB;

        $extendedcourse = null;
        if ($course->format == "flexpage") {
            $context = context_course::instance($course->id);

            $extendedcourse = new extended_course_object();
            $extendedcourse->get_extended_course($course, $context);

            $category = $DB->get_record('course_categories', array('id' => $course->category));
            $extendedcourse->categoryname = $category->name;
            $extendedcourse->file = utilities_image::get_moodle_stored_file($context, 'format_flexpage', 'coursepicture');
            $extendedcourse->imgurl = utilities_image::get_moodle_url_from_stored_file($extendedcourse->file);
        }

        return $extendedcourse;
    }

    /**
     * Retrieves number of records from course table
     *
     * Not all fields are retrieved. Records are ready for preloading context
     *
     * @param string $whereclause
     * @param array $params
     * @param array $options may indicate that summary and/or coursecontacts need to be retrieved
     * @param bool $checkvisibility if true, capability 'moodle/course:viewhiddencourses' will be checked
     *     on not visible courses
     * @return array array of stdClass objects
     */
    public static function get_course_records($whereclause, $params, $options, $checkvisibility = false) {

        global $USER;
        $list = self::get_course_records_request($whereclause, $params, $options);

        if ($checkvisibility) {
            // Loop through all records and make sure we only return the courses accessible by user.
            $selfenrolment = new enrollment_object();
            foreach ($list as $course) {
                if (isset($list[$course->id]->hassummary)) {
                    $list[$course->id]->hassummary = strlen($list[$course->id]->hassummary) > 0;
                }

                // Set a flag if course is closed, inprogress. Used to sort MOOC.
                if (isset($list[$course->id]->enddate) && $list[$course->id]->enddate > time()) {
                    $list[$course->id]->closed = false;
                    $list[$course->id]->timeleft = $list[$course->id]->enddate - time();
                    if ($list[$course->id]->startdate > time()) {
                        $list[$course->id]->inprogress = true;
                    } else {
                        $list[$course->id]->inprogress = false;
                    }
                } else {
                    $list[$course->id]->closed = true;
                    $list[$course->id]->inprogress = false;
                    $list[$course->id]->timeleft = 0;
                }

                if (empty($course->visible)) {
                    // Load context only if we need to check capability.
                    context_helper::preload_from_record($course);
                    if (!has_capability('moodle/course:viewhiddencourses', context_course::instance($course->id))) {
                        unset($list[$course->id]);
                    }
                }

                if (isset($list[$course->id])) {
                    $enrolself = $selfenrolment->get_self_enrolment($course);
                    if ($enrolself != null) {
                        // We get the start and end for enrolment (is set).
                        // If not set we set them to the start and end of course.
                        if ($enrolself->enrolstartdate != 0) {
                            $list[$course->id]->enrolstartdate = $enrolself->enrolstartdate;
                        }
                        $list[$course->id]->enrolstartdate = $course->startdate;
                        if ($enrolself->enrolenddate != 0) {
                            $list[$course->id]->enrolenddate = $enrolself->enrolenddate;
                        }
                        $list[$course->id]->enrolenddate = $course->enddate;

                        // If selfenrol and cohort associated, the must must be part of the cohort to see the course.
                        $cohortid = (int) $enrolself->customint5;
                        if ($cohortid != 0) {
                            if (!cohort_is_member($cohortid, $USER->id)) {
                                unset($list[$course->id]);
                            }
                        }
                    } else {
                        // No self enrolment method, then enrol start/end date = start/end of course.
                        $list[$course->id]->enrolstartdate = $course->startdate;
                        $list[$course->id]->enrolenddate = $course->enddate;
                    }
                }
            }
        }

        // Preload course contacts if necessary.
        if (!empty($options['coursecontacts'])) {
            self::preload_course_contacts($list);
        }
        return $list;
    }


    /**
     * Get course records.
     *
     * @param int $whereclause
     * @param int $params
     * @param int $whereclause
     * @return object $list
     */
    private static function get_course_records_request($whereclause, $params, $options) {

        global $DB;
        $ctxselect = context_helper::get_preload_record_columns_sql('ctx');

        $fields = array('c.id', 'c.category', 'c.sortorder',
            'c.shortname', 'c.fullname', 'c.idnumber',
            'c.startdate', 'c.visible', 'c.cacherev', 'co.value AS enddate', 'co2.value AS coursethematics');
        if (!empty($options['summary'])) {
            $fields[] = 'c.summary';
            $fields[] = 'c.summaryformat';
        } else {
            $fields[] = $DB->sql_substr('c.summary', 1, 1) . ' as hassummary';
        }

        if (!empty($whereclause)) {
            $whereclause .= " AND ";
        }

        $sql = "SELECT " . join(',', $fields) . ", $ctxselect
                FROM {course} c
                JOIN {context} ctx ON c.id = ctx.instanceid AND ctx.contextlevel = :contextcourse
                LEFT OUTER JOIN {course_format_options} co ON c.id = co.courseid AND co.name = 'courseenddate'
                LEFT OUTER JOIN {course_format_options} co2 ON c.id = co2.courseid AND co2.name = 'coursethematics'
                WHERE " . $whereclause . "c.id != 1 ORDER BY c.sortorder";
        $list = $DB->get_records_sql($sql, array('contextcourse' => CONTEXT_COURSE) + $params);

        return $list;
    }

    /**
     * Construct the SQL where clause for categories
     * @param array $categories
     * @return wherecategory[]
     */
    private static function catalogue_filter_category ($categories) {
        $wherecategory = array();

        if (($key = array_search(0, $categories)) !== false) {
            unset($categories[$key]);
        }

        if (count($categories)) {
            $wherecategory[] = "c.category IN (" . implode(',', $categories) . ")";
        } else {
            $wherecategory[] = "c.id != 0";
        }

        return $wherecategory;
    }

    /**
     * Construct the SQL where clause for thematics
     * @param array $thematics
     * @return $wherethematic[]
     */
    private static function catalogue_filter_thematic ($thematics) {
        $wherethematic = array();

        if (($key = array_search(0, $thematics)) !== false) {
            unset($thematics[$key]);
        }

        if (count($thematics)) {
            foreach ($thematics as $thematicid) {
                $wherethematic[] = "find_in_set ('" . $thematicid . "', co2.value) <> 0";
            }
        }

        return $wherethematic;
    }

    /**
     * Construct the SQL where clause for status
     * @param array $status
     * @return $wherestatus[]
     */
    private static function catalogue_filter_status ($status) {
        $wherestatus = array();

        foreach ($status as $statusid) {
            // En cours : date de début <= NOW et date de fin > NOW.
            if ($statusid == 1) {
                $wherestatus[] = "(c.startdate <= UNIX_TIMESTAMP(CURRENT_TIMESTAMP) AND " .
                        "co.value > UNIX_TIMESTAMP(CURRENT_TIMESTAMP))";
            }
            // A venir : date de début > NOW.
            if ($statusid == 2) {
                $wherestatus[] = "(c.startdate > UNIX_TIMESTAMP(CURRENT_TIMESTAMP))";
            }
            // Terminé : date de fin < NOW.
            if ($statusid == 3) {
                $wherestatus[] = "(co.value < UNIX_TIMESTAMP(CURRENT_TIMESTAMP))";
            }
        }

        return $wherestatus;
    }

    /**
     * Construct the SQL where clause for durations
     * @param array $durations
     * @return $whereduration[]
     */
    private static function catalogue_filter_durations ($durations) {
        $whereduration = array();

        foreach ($durations as $durationid) {
            // 1 : Moins de 4 semaines.
            if ($durationid == 1) {
                $whereduration[] = "((co.value-c.startdate) < (3600*24*7*4))";
            }
            // 2 : de 4 à 6 semaines.
            if ($durationid == 2) {
                $whereduration[] = "((co.value-c.startdate) >= (3600*24*7*4) AND (co.value-c.startdate) <= (3600*24*7*6))";
            }
            // 3 : plus de 6 semaines.
            if ($durationid == 3) {
                $whereduration[] = "(co.value-c.startdate) > (3600*24*7*6)";
            }
        }

        return $whereduration;
    }

    /**
     * Retrieves the list of courses accessible by user
     *
     * The following fields are always retrieved:
     * - id, visible, fullname, shortname, idnumber, category, sortorder
     *
     * If you plan to use properties/methods course_in_list::$summary and/or
     * course_in_list::get_course_contacts()
     * you can preload this information using appropriate 'options'. Otherwise
     * they will be retrieved from DB on demand and it may end with bigger DB load.
     *
     * Note that method course_in_list::has_summary() will not perform additional
     * DB queries even if $options['summary'] is not specified
     *
     * List of found course ids is cached for 10 minutes. Cache may be purged prior
     * to this when somebody edits courses or categories, however it is very
     * difficult to keep track of all possible changes that may affect list of courses.
     *
     * @param array $options options for retrieving children
     *    - recursive - return courses from subcategories as well. Use with care,
     *      this may be a huge list!
     *    - summary - preloads fields 'summary' and 'summaryformat'
     *    - coursecontacts - preloads course contacts
     *    - sort - list of fields to sort. Example
     *             array('idnumber' => 1, 'shortname' => 1, 'id' => -1)
     *             will sort by idnumber asc, shortname asc and id desc.
     *             Default: array('sortorder' => 1)
     *    - offset
     *    - limit - maximum number of children to return, 0 or null for no limit
     *    - idonly - returns the array or course ids instead of array of objects
     *               used only in get_courses_count()
     * @return course_in_list[]
     */
    public static function get_courses_catalogue($filter, $options = array()) {

        $offset = !empty($options['offset']) ? $options['offset'] : 0;
        $limit = !empty($options['limit']) ? $options['limit'] : null;
        $sortfields = !empty($options['sort']) ? $options['sort'] :
                array('closed' => 1, 'timeleft' => 1, 'enddate' => -1, 'startdate' => 1);

        // Filter on categories.
        if (isset($filter->categoriesid) && is_array($filter->categoriesid)) {
            $wherecategory = self::catalogue_filter_category($filter->categoriesid);
        }

        // Filter on thematics.
        if (isset($filter->thematicsid) && is_array($filter->thematicsid)) {
            $wherethematic = self::catalogue_filter_thematic($filter->thematicsid);
        }

        // Filter en status.
        $wherestatus = array();
        if (isset($filter->statusid) && is_array($filter->statusid)) {
            $wherestatus = self::catalogue_filter_status($filter->statusid);
        }

        // Filter en duration.
        if (isset($filter->durationsid) && is_array($filter->durationsid)) {
            $whereduration = self::catalogue_filter_durations($filter->durationsid);
        }

        // Construct the where clause.
        $where = array();
        if (!empty($wherecategory)) {
            $where[] = '(' . implode(' OR ', $wherecategory) . ')';
        }
        if (!empty($wherethematic) != 0) {
            $where[] = '(' . implode(' OR ', $wherethematic) . ')';
        }
        if (!empty($wherestatus) != 0) {
            $where[] = '(' . implode(' OR ', $wherestatus) . ')';
        }
        if (!empty($whereduration) != 0) {
            $where[] = '(' . implode(' OR ', $whereduration) . ')';
        }

        $params = array('siteid' => SITEID);

        $list = self::get_course_records(implode(' AND ', $where), $params,
                array_diff_key($options, array('coursecontacts' => 0)), true);

        // Sort list.
        self::sort_records($list, $sortfields);

        // Apply offset/limit, convert to course_in_list and return.
        $courses = array();
        if (isset($list)) {
            if ($offset || $limit) {
                $list = array_slice($list, $offset, $limit, true);
            }
            // Preload course contacts if necessary - saves DB queries later to do it for each course separately.
            if (!empty($options['coursecontacts'])) {
                self::preload_course_contacts($list);
            }
            // If option 'idonly' is specified no further action is needed, just return list of ids.
            if (!empty($options['idonly'])) {
                return array_keys($list);
            }
            // Prepare the list of course_in_list objects.
            foreach ($list as $record) {
                $courses[$record->id] = new course_in_list($record);
            }
        }
        return $courses;
    }

    /**
     * Retrieves the list of recommended courses accessible by user
     *
     * The following fields are always retrieved:
     * - id, visible, fullname, shortname, idnumber, category, sortorder
     *
     * If you plan to use properties/methods course_in_list::$summary and/or
     * course_in_list::get_course_contacts()
     * you can preload this information using appropriate 'options'. Otherwise
     * they will be retrieved from DB on demand and it may end with bigger DB load.
     *
     * Note that method course_in_list::has_summary() will not perform additional
     * DB queries even if $options['summary'] is not specified
     *
     * List of found course ids is cached for 10 minutes. Cache may be purged prior
     * to this when somebody edits courses or categories, however it is very
     * difficult to keep track of all possible changes that may affect list of courses.
     *
     * @param array $options options for retrieving children
     *    - recursive - return courses from subcategories as well. Use with care,
     *      this may be a huge list!
     *    - summary - preloads fields 'summary' and 'summaryformat'
     *    - coursecontacts - preloads course contacts
     *    - sort - list of fields to sort. Example
     *             array('idnumber' => 1, 'shortname' => 1, 'id' => -1)
     *             will sort by idnumber asc, shortname asc and id desc.
     *             Default: array('sortorder' => 1)
     *    - offset
     *    - limit - maximum number of children to return, 0 or null for no limit
     *    - idonly - returns the array or course ids instead of array of objects
     *               used only in get_courses_count()
     * @return course_in_list[]
     */
    public static function get_courses_recommended($options = array()) {

        $offset = !empty($options['offset']) ? $options['offset'] : 0;
        $limit = !empty($options['limit']) ? $options['limit'] : null;
        $sortfields = !empty($options['sort']) ? $options['sort'] :
                array('closed' => 1, 'inprogress' => 1, 'timeleft' => 1, 'enddate' => -1, 'startdate' => 1);

        $params = array('siteid' => SITEID);

        // We should get in first in progress MOOC then followed by to be started mooc.
        $wherestatus = "(";
        // En cours : date de début <= NOW et date de fin > NOW.
        $wherestatus .= "(c.startdate <= UNIX_TIMESTAMP(CURRENT_TIMESTAMP) AND " .
                "co.value > UNIX_TIMESTAMP(CURRENT_TIMESTAMP))";
        $wherestatus .= " OR ";
        // A venir : date de début > NOW.
        $wherestatus .= "(c.startdate > UNIX_TIMESTAMP(CURRENT_TIMESTAMP))";
        $wherestatus .= ")";

        $list = self::get_course_records($wherestatus, $params, array_diff_key($options, array('coursecontacts' => 0)), true);

        // Sort list.
        self::sort_records($list, $sortfields);

        // Apply offset/limit, convert to course_in_list and return.
        $courses = array();
        if (isset($list)) {
            if ($limit) {
                $list = array_slice($list, 0, $limit, true);
            }
            // If option 'idonly' is specified no further action is needed, just return list of ids.
            if (!empty($options['idonly'])) {
                return array_keys($list);
            }
            // Prepare the list of course_in_list objects.
            foreach ($list as $record) {
                $courses[$record->id] = new course_in_list($record);
            }
        }
        return $courses;
    }

    /**
     * Sorts list of records by several fields
     *
     * @param array $records array of stdClass objects
     * @param array $sortfields assoc array where key is the field to sort and value is 1 for asc or -1 for desc
     * @return int
     */
    protected static function sort_records(&$records, $sortfields) {

        if (empty($records)) {
            return;
        }
        // If sorting by course display name, calculate it (it may be fullname or shortname+fullname).
        if (array_key_exists('displayname', $sortfields)) {
            foreach ($records as $key => $record) {
                if (!isset($record->displayname)) {
                    $records[$key]->displayname = get_course_display_name_for_list($record);
                }
            }
        }
        // Sorting by one field - use core_collator.
        if (count($sortfields) == 1) {
            $property = key($sortfields);
            if (in_array($property, array('sortorder', 'id', 'visible', 'parent', 'depth'))) {
                $sortflag = core_collator::SORT_NUMERIC;
            } else if (in_array($property, array('idnumber', 'displayname', 'name', 'shortname', 'fullname'))) {
                $sortflag = core_collator::SORT_STRING;
            } else {
                $sortflag = core_collator::SORT_REGULAR;
            }
            core_collator::asort_objects_by_property($records, $property, $sortflag);
            if ($sortfields[$property] < 0) {
                $records = array_reverse($records, true);
            }
            return;
        }
        $records = coursecat_sortable_records::sort($records, $sortfields);
    }

    /**
     * Returns number of courses visible to the user
     *
     * @param array $options similar to get_courses() except some options do not affect
     *     number of courses (i.e. sort, summary, offset, limit etc.)
     * @return int
     */
    public static function get_courses_catalogue_count($filter, $options = array()) {

        unset($options['offset']);
        unset($options['limit']);
        unset($options['summary']);
        unset($options['coursecontacts']);
        $options['idonly'] = true;
        $courses = self::get_courses_catalogue($filter, $options);
        $cnt = count($courses);
        return $cnt;
    }

    /**
     *  Get the category ID of a course.
     *
     * @return int $categoryid
     */
    public function get_categoryid() {

        global $PAGE, $DB;
        $context = $PAGE->context;
        $coursecontext = $context->get_course_context();
        $categoryid = null;
        if ($coursecontext) { // No course context for system / user profile.
            $courseid = $coursecontext->instanceid;
            $course = $DB->get_record('course', array('id' => $courseid), 'id, category');
            if ($course) { // Should always exist, but just in case ...
                $categoryid = $course->category;
            }
        }

        return $categoryid;
    }

    /**
     * Get the category id from course id.
     *
     * @param int $courseid
     * @return int $categoryid
     */
    public function get_categoryid_by_courseid($courseid) {

        global $DB;
        $categoryid = null;
        $course = $DB->get_record('course', array('id' => $courseid), 'id, category');
        if ($course) { // Should always exist, but just in case ...
            $categoryid = $course->category;
        }

        return $categoryid;
    }

    /**
     * Check if a user can see a course
     *
     * @param   $course object
     * @param   $user object - if empty, we will use current $USER
     * @return  (bool)
     */
    public function can_user_view_course($course, $user = null) {

        // Use global $USER if no user.
        if (!$user) {
            global $USER;
            $user = $USER;
        }

        // Check if course has self_enroll.
        $selfenrolment = new enrollment_object();
        $enrolself = $selfenrolment->get_self_enrolment($course);

        // If no self enrolment method, this is not a private mooc.
        if (!$enrolself) {
            return true;
        }

        // Always true if the user can create course.
        if (isloggedin() && has_capability('moodle/course:create', context_user::instance($user->id))) {
            return true;
        }

        // If enrolment, check for cohort and return true if no cohort.
        $cohortid = (int) $enrolself->customint5;
        if (!$cohortid) {
            return true;
        }

        // Last case : we'll grant access wheither the user is in the cohort.
        return cohort_is_member($cohortid, $user->id);
    }

    /**
     * Returns "description page" url of a course
     *
     * @global type $CFG
     * @param type $course
     * @return string
     *
     */
    public function get_description_page_url($course = null) {

        global $CFG, $DB;
        $url = '#';

        if (!$course) {
            global $COURSE;
            $course = $COURSE;
        }

        if ($course) {
            $descriptionpages = $DB->get_records('descriptionpage', array('course' => $course->id));
            // To avoid having an error page when the description page is not setup.
            if ($descriptionpages != null) {
                $url = $CFG->wwwroot . '/mod/descriptionpage/view.php?courseid=' . $course->id;
            } else {
                $url = $CFG->wwwroot;
            }
        }

        return $url;
    }

    /**
     * Returns "forum page" url of a course
     *
     * @global type $CFG
     * @param course Id $courseid
     * @return string
     *
     */
    public function get_course_url_page_forum($courseid = null) {
        global $CFG;

        $idpage = $this->get_course_id_page_forum($courseid);

        if (!$idpage) {
            return null;
        }

        return new \moodle_url('/course/view.php', array('id' => $courseid, 'pageid' => $idpage));
    }

    /**
     * Returns "forum page" id of a course
     *
     * @global type $CFG
     * @param course Id $courseid
     * @return id
     *
     */
    public function get_course_id_page_forum($courseid = null) {

        global $CFG, $DB;
        $idpage = null;

        if (!$courseid) {
            global $COURSE;
            $courseid = $COURSE->id;
        }

        if ($courseid) {
            $sql = "SELECT distinct(I.subpagepattern)
                     FROM {block_instances} I LEFT OUTER JOIN {format_flexpage_page} P ON (I.subpagepattern = P.id)
                     WHERE P.courseid = ?
                     AND I.blockname='orange_listforumng'
                     AND I.pagetypepattern LIKE 'course-view%' LIMIT 1";

            $idpage = $DB->get_record_sql($sql, array($courseid));
        }



        if ($idpage != null) {
            return $idpage->subpagepattern;
        } else {
            return $idpage;
        }
    }

    /**
     * Very simple function to check if we are inside the frontpage course (id=1)
     *
     * @param: $course
     * @return boolean
     */
    public static function is_frontpage_course($course) {

        return ($course->id == 1);
    }

    /**
     *
     * @param type $extendedcourse
     * @return type
     */
    private function incoming_unsubscribe($extendedcourse) {

        $extendedcourse->statuslink = $extendedcourse->unenrolurl;
        $extendedcourse->statustext = get_string('status_default', 'local_orange_library');
        return $extendedcourse;
    }

    /**
     * course running + unsubscription link + button active
     * @param type $extendedcourse
     * @return type
     */
    private function running_unsubscribe($extendedcourse) {

        $extendedcourse->statuslink = $extendedcourse->unenrolurl;
        $extendedcourse->statustext = get_string('status_running', 'local_orange_library');
        return $extendedcourse;
    }

    /**
     * new session state + registration closed + button disabled state
     * @param type $extendedcourse
     * @return type
     */
    private function new_session($extendedcourse) {

        $extendedcourse->statuslink = get_string('new_session', 'local_orange_library');
        $extendedcourse->statustext = get_string('registration_closed', 'local_orange_library');
        return $extendedcourse;
    }

    /**
     * subscription closed and button disabled state
     * @param type $extendedcourse
     * @return type
     */
    private function subscription_closed($extendedcourse) {

        $extendedcourse->statuslink = "#";
        $extendedcourse->statustext = get_string('registration_closed', 'local_orange_library');
        return $extendedcourse;
    }

    /**
     * Check the course configuration for the mandatory params.
     *
     * @return string (HTML content of error message
     */
    public static function check_mooc_configuration($courseid) {
        global $DB;

        $error = array();
        $context = context_course::instance($courseid);

        if (has_capability('moodle/course:enrolconfig', $context)) {
            // Check needed enrolment methods.
            $neededenrolment = array ('manual', 'self', 'orangeinvitation', 'orangenextsession');
            foreach ($neededenrolment as $enrol) {
                $enrolname = get_string('pluginname', 'enrol_' . $enrol);
                $instances = enrol_get_instances ($courseid, true);
                $instances = array_filter ($instances, function ($element) use($enrol) {
                    return $element->enrol == $enrol;
                });
                if (count($instances) == 0) {
                    $error[] = get_string('enrolmentmethodmissing', 'local_orange_library', $enrolname);
                } else {
                    $instance = array_pop($instances);
                    if ($instance->status != 0) {
                        $error[] = get_string('enrolmentmethoddisabled', 'local_orange_library', $enrolname);
                    } else {
                        // For self enrol me need start and end enrol date.
                        if ($instance->enrol == "self") {
                            if (empty($instance->enrolstartdate)) {
                                $error[] = get_string('startenrolmentdatemissing', 'local_orange_library');
                            }
                            if (empty($instance->enrolenddate)) {
                                $error[] = get_string('endenrolmentdatemissing', 'local_orange_library');
                            }
                        } else if ($instance->enrol == "orangeinvitation") {
                            if (empty($instance->customtext1) || empty($instance->customtext2) || empty($instance->customtext3)) {
                                $error[] = get_string('orangeinvitationconfigmissing', 'local_orange_library');
                            }
                        }
                    }
                }
            }
        }

        if (has_capability('mod/descriptionpage:addinstance', $context)) {
            // Check descriptionpage module.
            $descriptionpages = $DB->get_records('descriptionpage', array('course' => $courseid));
            $modname = get_string('modulename', 'mod_descriptionpage');
            if (empty($descriptionpages)) {
                $error[] = get_string('moddescriptionpagemissing', 'local_orange_library', $modname);
            }
            if (count($descriptionpages) > 1) {
                $error[] = get_string('moddescriptionpagemultiple', 'local_orange_library', $modname);
            }
        }

        // Check mandatory blocks.
        $neededblocks = array ( 'orange_course_extended', 'orange_progressbar');
        foreach ($neededblocks as $block) {
            if (has_capability('block/'.$block.':addinstance', $context)) {
                $extendedcourseblock = $DB->get_records('block_instances',
                        array('blockname' => $block, 'parentcontextid' => $context->id));
                if (count($extendedcourseblock) == 0) {
                    $error[] = get_string('blockmissing', 'local_orange_library', $block);
                }
            }
        }

        $output = "";
        if (count($error)) {
            $output .= \html_writer::start_tag('div', array('class' => 'alert alert-danger'));
            $output .= \html_writer::tag('strong', get_string('configuration_error', 'local_orange_library'));
            $output .= "<br />";
            $output .= implode($error, "<br />");
            $output .= \html_writer::end_tag('div');
        }
        return $output;

    }

    /**
     * Get the URL for course menu "PARTAGER"
     *
     * @param course id $courseid
     * @return url
     */
    public static function get_mooc_share_menu($courseid) {
        global $DB;

        $folder = $DB->get_record('folder', array('course' => $courseid), '*', IGNORE_MISSING);

        if ($folder) {
            return new \moodle_url('/mod/folder/view.php', array('f' => $folder->id));
        } else {
            return null;
        }
    }

    /**
     * Get the URL for course menu "S'INFORMER"
     *
     * @param course id $courseid
     * @return url
     */
    public static function get_mooc_learnmore_menu($courseid) {
        global $DB;

        $params = array('course' => $courseid);
        if (!$coursemodule = $DB->get_field_sql("SELECT cm.id
                                                 FROM {course_modules} cm
                                                 JOIN {modules} md ON md.id = cm.module
                                                WHERE cm.course = :course AND md.name='oublog'", $params, IGNORE_MISSING)) {
            return null;
        }

        return new \moodle_url('/mod/oublog/view.php', array('id' => $coursemodule));
    }

    /**
     * Get the URL for course menu "DISCUTER"
     *
     * @param course Id $courseid
     * @return url
     */
    public static function get_mooc_forum_menu($courseid) {
        global $CFG;

        $utilitiescourse = new utilities_course();

        return $utilitiescourse->get_course_url_page_forum($courseid);
    }

    /**
     * Get the URL for course menu "APPRENDRE"
     *
     * @param course id $courseid
     *
     * @return mixed $tab object
     */
    public static function get_mooc_learn_menu($courseid) {
        global $DB;

        $tab = new \stdClass();
        $tab->url = null;

        // Get last page view in course if exist.

        switch ($lastpage = self::get_course_lastpage($courseid)) {

            case true:
                $tab->pageid = $lastpage->id;
                $tab->title = $lastpage->name;
            break;

            default:
                // We have no pageid from previous visit. Get flexpage course homepage.
                // Which is: lowest ID of visible flexpage for the mooc.
                $home = $DB->get_record_sql("SELECT fp.id, fp.name
                    FROM {format_flexpage_page} fp
                    WHERE fp.courseid = :id AND fp.display=2
                    ORDER BY fp.parentid ASC
                    LIMIT 1", array('id' => $courseid), IGNORE_MISSING);

                if (!$home) {
                    debbuging('This course which id is: ' . $courseid . ' has no flexpage.', DEBUG_DEVELOPER);
                    return $tab;
                }

                // Get first Sequence page.
                // Which is: lowest ID of $home children.
                // @todo: make it in one query ?
                $firstpage = $DB->get_record_sql("SELECT fp.id, fp.name
                    FROM {format_flexpage_page} fp
                    WHERE fp.parentid = :id AND fp.display=2
                    ORDER BY fp.weight ASC
                    LIMIT 1", array('id' => $home->id), IGNORE_MISSING);

                if ($firstpage) {
                    $tab->pageid = $firstpage->id;
                    $tab->title = $firstpage->name;
                } else {
                    $tab->pageid = $home->id;
                    $tab->title = $home->name;
                }
            break;
        }

        $tab->url = new \moodle_url('/course/view.php',
            array('id' => $courseid, 'pageid' => $tab->pageid));

        return $tab;
    }

    /**
     * Detect if we are on a course page
     *
     * @return boolean
     */
    public static function is_on_course_page() {
        global $COURSE;

        return ($COURSE->id > 1);
    }

    /**
     * Store current course page
     *
     * @param page id $pageid
     * @return none
     */
    public static function store_course_page($pageid) {
        global $DB, $USER, $COURSE;

        // If we access the forum page of the MOOC then we should not store the id.
        $utilitiescourse = new utilities_course();
        $idpageforum = $utilitiescourse->get_course_id_page_forum($COURSE->id);
        if (!empty($pageid) && ($pageid != $idpageforum)) {
            $currentpage = $DB->get_record('last_page_viewed',
                    array('courseid' => $COURSE->id, 'userid' => $USER->id), '*', IGNORE_MISSING);
            if ($currentpage) {
                $currentpage->pageid = $pageid;
                $currentpage->time = time();
                $DB->update_record('last_page_viewed', $currentpage);
            } else {
                $page = new \stdClass();
                $page->userid = $USER->id;
                $page->courseid = $COURSE->id;
                $page->pageid = $pageid;
                $page->time = time();
                $DB->insert_record('last_page_viewed', $page);
            }
        }
        return true;
    }

    /**
     * Return last course page view id (from flexpage format) or null.
     *
     * @param page id $pageid
     *
     * @return mixed $pagedata (int || null)
     */
    public static function get_course_lastpage($courseid = null) {
        global $DB, $USER, $COURSE;

        if (!$courseid) {
            $courseid = $COURSE->id;
        }

        $pagedata = new \stdClass();
        $pagedata->id = null;

        $pagedata = $DB->get_record_sql("SELECT fp.id, fp.name
            FROM {format_flexpage_page} fp
            WHERE fp.display=2 AND fp.id =
                (   SELECT pageid
                    FROM {last_page_viewed}
                    WHERE courseid = :courseid
                    AND userid = :userid)
            LIMIT 1",
            array('courseid' => $courseid, 'userid' => $USER->id), IGNORE_MISSING);

        return $pagedata;
    }

    /**
     * Check if tab is active
     *
     * @param tab identifier $tabid
     * @param current script $script
     * @param course Id $courseid
     * @return none
     */
    public static function is_active_tab($tabid, $script, $courseid) {
        $forumurl = self::get_mooc_forum_menu($courseid);

        switch ($tabid) {
            case "learn":
                if ((strpos($script, "/course/view") !== false) &&
                    (is_null($forumurl) || (strpos($script, $forumurl->out_as_local_url(false)) === false))) {
                    return 'class="active"';
                }
            break;

            case "learnmore":
                if (strpos($script, "/mod/oublog") !== false) {
                    return 'class="active"';
                }
            break;

            case "forum":
                if (!is_null($forumurl)) {
                    if ((strpos($script, $forumurl->out_as_local_url(false)) !== false) ||
                        (strpos($script, "/mod/forumng") !== false)) {
                        return 'class="active"';
                    }
                }
            break;

            case "share":
                if (strpos($script, "/mod/folder") !== false) {
                    return 'class="active"';
                }
            break;
        }

        return '';
    }
}
