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
 * This is built using the bootstrapbase template to allow for new theme's using
 * Moodle's new Bootstrap theme engine
 *
 * @package     theme_solerni
 * @copyright   2015 Orange
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_orange_library\utilities;

use local_orange_library\extended_course\extended_course_object;
use local_orange_library\enrollment\enrollment_object;
use context_user;
use context_course;
use moodle_url;
use context_helper;
use coursecat_sortable_records;
use course_in_list;

class utilities_course {

    public static function solerni_course_get_customer_infos ($catid) {
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
    public static function solerni_get_course_infos ($course) {
        global $DB;

        $extendedcourse = null;
        // We get more information only when flexpage format is used.
        if ($course->format == "flexpage") {
            $context = context_course::instance($course->id);

            $extendedcourse = new extended_course_object();
            $extendedcourse->get_extended_course($course, $context);

            $category = $DB->get_record('course_categories', array('id' => $course->category));
            $extendedcourse->categoryname = $category->name;

            $fs = get_file_storage();
            $files = $fs->get_area_files($context->id, 'format_flexpage', 'coursepicture', 0);
            $extendedcourse->imgurl = null;
            $extendedcourse->file = null;
            foreach ($files as $file) {
                $ctxid      = $file->get_contextid();
                $cmpnt      = $file->get_component();
                $filearea   = $file->get_filearea();
                $itemid     = $file->get_itemid();
                $filepath   = $file->get_filepath();
                $filename   = $file->get_filename();
                if ($filename != ".") {
                    $extendedcourse->imgurl = moodle_url::make_pluginfile_url($ctxid,
                            $cmpnt, $filearea, $itemid, $filepath, $filename);
                    $extendedcourse->file = $file;
                }
            }
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
        global $DB, $USER;
        $ctxselect = context_helper::get_preload_record_columns_sql('ctx');
        $fields = array('c.id', 'c.category', 'c.sortorder',
                        'c.shortname', 'c.fullname', 'c.idnumber',
                        'c.startdate', 'c.visible', 'c.cacherev', 'co.value AS enddate', 'co2.value AS coursethematics');
        if (!empty($options['summary'])) {
            $fields[] = 'c.summary';
            $fields[] = 'c.summaryformat';
        } else {
            $fields[] = $DB->sql_substr('c.summary', 1, 1). ' as hassummary';
        }

        $sql = "SELECT ". join(',', $fields). ", $ctxselect
                FROM {course} c
                JOIN {context} ctx ON c.id = ctx.instanceid AND ctx.contextlevel = :contextcourse
                LEFT OUTER JOIN {course_format_options} co ON c.id = co.courseid AND co.name = 'courseenddate'
                LEFT OUTER JOIN {course_format_options} co2 ON c.id = co2.courseid AND co2.name = 'coursethematics'
                WHERE ". $whereclause." ORDER BY c.sortorder";
        $list = $DB->get_records_sql($sql, array('contextcourse' => CONTEXT_COURSE) + $params);

        if ($checkvisibility) {
            // Loop through all records and make sure we only return the courses accessible by user.
            $selfenrolment = new enrollment_object();
            foreach ($list as $course) {
                if (isset($list[$course->id]->hassummary)) {
                    $list[$course->id]->hassummary = strlen($list[$course->id]->hassummary) > 0;
                }

                // Set a flag if course is closed. Used to sort MOOC.
                if (isset($list[$course->id]->enddate) && $list[$course->id]->enddate > time()) {
                    $list[$course->id]->closed = false;
                    $list[$course->id]->timeleft = $list[$course->id]->enddate - time();
                } else {
                    $list[$course->id]->closed = true;
                    $list[$course->id]->timeleft = 0;
                }

                if (empty($course->visible)) {
                    // Load context only if we need to check capability.
                    context_helper::preload_from_record($course);
                    if (!has_capability('moodle/course:viewhiddencourses', context_course::instance($course->id))) {
                        unset($list[$course->id]);
                    }
                }
                $enrolself = $selfenrolment->get_self_enrolment($course);
                if ($enrolself != null) {
                    // We get the start and end for enrolment (is set).
                    // If not set we set them to the start and end of course.
                    if ($enrolself->enrolstartdate !=0) $list[$course->id]->enrolstartdate = $enrolself->enrolstartdate;
                    $list[$course->id]->enrolstartdate = $course->startdate;
                    if ($enrolself->enrolenddate !=0) $list[$course->id]->enrolenddate = $enrolself->enrolenddate;
                    $list[$course->id]->enrolenddate = $course->enddate;

                    // If selfenrol and cohort associated, the must must be part of the cohort to see the course.
                    $cohortid = (int)$enrolself->customint5;
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

        // Preload course contacts if necessary.
        if (!empty($options['coursecontacts'])) {
            self::preload_course_contacts($list);
        }
        return $list;
    }

    /**
     * Retrieves the list of courses accessible by user
     *
     * Not all information is cached, try to avoid calling this method
     * twice in the same request.
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
     *             Only cached fields may be used for sorting!
     *    - offset
     *    - limit - maximum number of children to return, 0 or null for no limit
     *    - idonly - returns the array or course ids instead of array of objects
     *               used only in get_courses_count()
     * @return course_in_list[]
     */
    public static function get_courses_catalogue($filter, $options = array()) {
        global $DB;
        $recursive = !empty($options['recursive']);
        $offset = !empty($options['offset']) ? $options['offset'] : 0;
        $limit = !empty($options['limit']) ? $options['limit'] : null;
        $sortfields = !empty($options['sort']) ? $options['sort'] : array('closed' => 1, 'timeleft' => 1, 'enddate' => -1);

        // Check if this category is hidden.
        // Also 0-category never has courses unless this is recursive call.
        // if (!$this->is_uservisible() || (!$this->id && !$recursive)) {
        // return array();
        // }

        $wherecategory = array();
        $params = array('siteid' => SITEID);
        // if ($recursive) {
            // if ($this->id) {
            //    $context = context_coursecat::instance($this->id);
            //    $wherecategory[] .= 'ctx.path like :path';
            //    $params['path'] = $context->path. '/%';
            // }
        // } else {
            //$where .= ' AND c.category = :categoryid';
            //$params['categoryid'] = $this->id;
        // }

        // Filter on categories.
        if (($key = array_search(0, $filter->categoriesid)) !== false) {
            unset($filter->categoriesid[$key]);
        }

        if (is_array($filter->categoriesid) && count($filter->categoriesid)) {
            $wherecategory[] = "c.category IN (".implode(',', $filter->categoriesid).")";
        } else {
            $wherecategory[] = "c.id != 0";
        }

        // Filter on thematics.
        $wherethematic = array();
        if (($key = array_search(0, $filter->thematicsid)) !== false) {
            unset($filter->thematicsid[$key]);
        }
        if (is_array($filter->thematicsid) && count($filter->thematicsid)) {
            foreach ($filter->thematicsid as $thematicid) {
                $wherethematic[] = "find_in_set ('" . $thematicid . "', co2.value) <> 0";
            }
        }

        // Filter en status.
        $wherestatus = array();
        if (is_array($filter->statusid)) {
            foreach ($filter->statusid as $statusid) {
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
        }

        // Filter en duration.
        $whereduration = array();
        if (is_array($filter->durationsid)) {
            foreach ($filter->durationsid as $durationid) {
                // 1 : Moins de 4 semaines.
                if ($durationid == 1) {
                    $whereduration[] = "((co.value-c.startdate) < (3600*24*31*4))";
                }
                // 2 : de 4 à 6 semaines.
                if ($durationid == 2) {
                    $whereduration[] = "((co.value-c.startdate) >= (3600*24*31*4) AND (co.value-c.startdate) <= (3600*24*31*6))";
                }
                // 3 : plus de 6 semaines.
                if ($durationid == 3) {
                    $whereduration[] = "(co.value-c.startdate) > (3600*24*31*6)";
                }
            }
        }

        // Construct the where claude.
        $where = array();
        if (count($wherecategory) != 0) {
            $where[] = '(' . implode(' OR ', $wherecategory) . ')';
        }
        if (count($wherethematic) != 0) {
            $where[] = '(' . implode(' OR ', $wherethematic) . ')';
        }
        if (count($wherestatus) != 0) {
            $where[] = '(' . implode(' OR ', $wherestatus) . ')';
        }
        if (count($whereduration) != 0) {
            $where[] = '(' . implode(' OR ', $whereduration) . ')';
        }

        $list = self::get_course_records(implode(' AND ', $where), $params,
                array_diff_key($options, array('coursecontacts' => 0)), true);

        // Sort and cache list.
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
     * Get the number of users enrolled in the course
     *
     * @param object $course
     * @return int $nbenrolledusers
     */
    public function get_nb_users_enrolled_in_course($course) {
        global $DB;
        $courseid = $course->id;
        $sqlrequest = "SELECT DISTINCT u.id AS userid, c.id AS courseid
            FROM mdl_user u
            JOIN mdl_user_enrolments ue ON ue.userid = u.id
            JOIN mdl_enrol e ON e.id = ue.enrolid
            JOIN mdl_role_assignments ra ON ra.userid = u.id
            JOIN mdl_context ct ON ct.id = ra.contextid AND ct.contextlevel = 50
            JOIN mdl_course c ON c.id = ct.instanceid AND e.courseid = ". $courseid."
            JOIN mdl_role r ON r.id = ra.roleid AND r.shortname = 'student'
            WHERE e.status = 0 AND u.suspended = 0 AND u.deleted = 0
            AND (ue.timeend = 0 OR ue.timeend > NOW()) AND ue.status = 0";
        $enrolledusers = $DB->get_records_sql($sqlrequest);
        $nbenrolledusers = count ($enrolledusers);

        return $nbenrolledusers;
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
        if ($coursecontext) { // No course context for system / user profile
            $courseid = $coursecontext->instanceid;
            $course = $DB->get_record('course', array('id' => $courseid), 'id, category');
            if ($course) { // Should always exist, but just in case ...
                $categoryid = $course->category;
            }
        }

        return $categoryid;
    }

    /**
     * Set the extended course values from config.
     *
     * @param object $context
     * @return object $this->extendedcourse
     */
    public function get_categoryid_by_courseid($course) {
        global $DB;
        $categoryid = NULL;
        $course = $DB->get_record('course', array('id' => $course->id), 'id, category');
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
    public function can_user_view_course($course, $user = null ) {

        // Use global $USER if no user
        if (!$user) {
            global $USER;
            $user = $USER;
        }

        // Check if course has self_enroll
        $selfenrolment = new enrollment_object();
        $enrolself = $selfenrolment->get_self_enrolment($course);

        // If no self enrolment method, this is not a private mooc
        if ( ! $enrolself ) {
            return true;
        }

        // Always true if the user can create course
        if ( isloggedin() && has_capability('moodle/course:create', context_user::instance($user->id)) ) {
                return true;
        }

        // If enrolment, check for cohort and return true if no cohort
        $cohortid = (int)$enrolself->customint5;
        if ( ! $cohortid ) {
            return true;
        }

        // Last case : we'll grant access wheither the user is in the cohort
        return cohort_is_member($cohortid, $USER->id);
    }

    public function get_description_page_url($course = null) {

        $url = '#';
        if ($course) {
            $url = new moodle_url('mod/descriptionpage/view.php', array('courseid' => $course->id));
        }

        return $url;
    }
}