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

require_once($CFG->dirroot . '/local/orange_customers/lib.php');

class catalogue {
    public static function solerni_catalogue_get_customer_infos ($catid) {
        global $DB;

        $customer = customer_get_customerbycategoryid ($catid);

        return $customer;
    }

    public static function solerni_catalogue_get_course_infos ($course) {
        global $DB;

        // We get more information only when flexpage format is used.
        if ($course->format == "flexpage") {
            $extendedcourse = new stdClass();
            $courseid = $course->id;
            $context = context_course::instance($course->id);

            $fs = get_file_storage();
            $files = $fs->get_area_files($context->id, 'format_flexpage', 'coursepicture', 0);
            foreach ($files as $file) {
                $ctxid = $file->get_contextid();
                $cmpnt = $file->get_component();
                $filearea = $file->get_filearea();
                $itemid = $file->get_itemid();
                $filepath = $file->get_filepath();
                $filename = $file->get_filename();
                if ($filename != ".") {
                    $extendedcourse->imgurl = moodle_url::make_pluginfile_url($ctxid,
                            $cmpnt, $filearea, $itemid, $filepath, $filename);
                } else {
                    $extendedcourse->imgurl = null;
                }
            }

            $category = $DB->get_record('course_categories', array('id' => $course->category));
            $extendedcourse->categoryname = $category->name;

            $extendedcourseflexpagevalues = $DB->get_records('course_format_options', array('courseid' => $courseid));
            foreach ($extendedcourseflexpagevalues as $extendedcourseflexpagevalue) {
                switch ($extendedcourseflexpagevalue->name) {
                    case 'coursepicture':
                        $extendedcourse->picture = $extendedcourseflexpagevalue->value;
                        break;
                    case 'courseenddate':
                        $extendedcourse->enddate = $extendedcourseflexpagevalue->value;
                        break;
                    case 'courseprice':
                        $extendedcourse->price = $extendedcourseflexpagevalue->value;
                        break;
                }
            }

            return $extendedcourse;
        } else {
            return null;
        }
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
        global $DB;
        $ctxselect = context_helper::get_preload_record_columns_sql('ctx');
        $fields = array('c.id', 'c.category', 'c.sortorder',
                        'c.shortname', 'c.fullname', 'c.idnumber',
                        'c.startdate', 'c.visible', 'c.cacherev', 'co.value');
        if (!empty($options['summary'])) {
            $fields[] = 'c.summary';
            $fields[] = 'c.summaryformat';
        } else {
            $fields[] = $DB->sql_substr('c.summary', 1, 1). ' as hassummary';
        }
        $sql = "SELECT ". join(',', $fields). ", $ctxselect
                FROM {course} c
                JOIN {context} ctx ON c.id = ctx.instanceid AND ctx.contextlevel = :contextcourse
                JOIN {course_format_options} co ON c.id = co.courseid AND co.name = 'courseenddate'
                WHERE ". $whereclause." ORDER BY c.sortorder";
        $list = $DB->get_records_sql($sql,
                array('contextcourse' => CONTEXT_COURSE) + $params);

        if ($checkvisibility) {
            // Loop through all records and make sure we only return the courses accessible by user.
            foreach ($list as $course) {
                if (isset($list[$course->id]->hassummary)) {
                    $list[$course->id]->hassummary = strlen($list[$course->id]->hassummary) > 0;
                }
                if (empty($course->visible)) {
                    // Load context only if we need to check capability.
                    context_helper::preload_from_record($course);
                    if (!has_capability('moodle/course:viewhiddencourses', context_course::instance($course->id))) {
                        unset($list[$course->id]);
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
        $sortfields = !empty($options['sort']) ? $options['sort'] : array('sortorder' => 1);

        // Check if this category is hidden.
        // Also 0-category never has courses unless this is recursive call.
        // if (!$this->is_uservisible() || (!$this->id && !$recursive)) {
        // return array();
        // }

        // TODO-SLP
        // Tenir compte du user afin d'afficher ou non les MOOCs privés
        // Retrieve list of courses in category.

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

        if (($key = array_search(0, $filter->categoriesid)) !== false) {
            unset($filter->categoriesid[$key]);
        }

        // Get list of courses without preloaded coursecontacts because we don't need them for every course.
        if (is_array($filter->categoriesid) && count($filter->categoriesid)) {
            $wherecategory[] = "c.category IN (".implode(',', $filter->categoriesid).")";
        } else {
            $wherecategory[] = "c.id != 0";
        }

        $wherestatus = array();
        if (is_array($filter->statusid)) {
            foreach ($filter->statusid as $statusid) {
                // En cours : date de début <= NOW et date de fin > NOW.
                if ($statusid == 1) {
                    $wherestatus[] = "(c.startdate <= UNIX_TIMESTAMP(CURRENT_TIMESTAMP) AND co.value > UNIX_TIMESTAMP(CURRENT_TIMESTAMP))";
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

        $where = array();
        if (count($wherecategory) != 0) {
            $where[] = '(' . implode(' OR ', $wherecategory) . ')';
        }
        if (count($wherestatus) != 0) {
            $where[] = '(' . implode(' OR ', $wherestatus) . ')';
        }
        if (count($whereduration) != 0) {
            $where[] = '(' . implode(' OR ', $whereduration) . ')';
        }

        $list = self::get_course_records(implode(' AND ', $where), $params,
                array_diff_key($options, array('coursecontacts' => 1)), true);

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
        $cntcachekey = 'lcnt-'. 'c'. '-'. (!empty($options['recursive']) ? 'r' : '');
        $coursecatcache = cache::make('core', 'coursecat');
        if (($cnt = $coursecatcache->get($cntcachekey)) === false) {
            // Cached value not found. Retrieve ALL courses and return their count.
            unset($options['offset']);
            unset($options['limit']);
            unset($options['summary']);
            unset($options['coursecontacts']);
            $options['idonly'] = true;
            $courses = self::get_courses_catalogue($filter, $options);
            $cnt = count($courses);
        }
        return $cnt;
    }
}