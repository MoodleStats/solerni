<?php
/**
 * Flexpage
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://opensource.org/licenses/gpl-3.0.html.
 *
 * @copyright Copyright (c) 2009 Moodlerooms Inc. (http://www.moodlerooms.com)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @package format_flexpage
 * @author Mark Nielsen
 */

require_once($CFG->libdir.'/completionlib.php');
require_once($CFG->libdir.'/conditionlib.php');
require_once($CFG->libdir.'/gradelib.php');

/**
 * @see course_format_flexpage_model_page
 */
require_once($CFG->dirroot.'/course/format/flexpage/model/page.php');

/**
 * Repository mapper for page conditions
 *
 * @author Mark Nielsen
 * @package format_flexpage
 */
class course_format_flexpage_repository_condition {
    /**
     * Get all page conditions for a course
     *
     * @param int $courseid
     * @return array
     */
    public function get_course_conditions($courseid) {
        return $this->get_conditions($courseid);
    }

    /**
     * Get all page conditions
     *
     * @param course_format_flexpage_model_page $page
     * @return array
     */
    public function get_page_condtions(course_format_flexpage_model_page $page) {
        $conditions = $this->get_conditions($page->get_courseid(), $page->get_id());

        if (array_key_exists($page->get_id(), $conditions)) {
            return $conditions[$page->get_id()];
        }
        return array();
    }

    /**
     * Get all page conditions and set them to the page
     *
     * @param course_format_flexpage_model_page $page
     * @return void
     */
    public function set_page_conditions(course_format_flexpage_model_page $page) {
        $page->set_conditions($this->get_page_condtions($page));
    }

    /**
     * Delete conditions from database and remove them from the page
     *
     * @param course_format_flexpage_model_page $page
     * @return void
     */
    public function remove_page_conditions(course_format_flexpage_model_page $page) {
        global $DB;

        $DB->delete_records('format_flexpage_grade', array('pageid' => $page->get_id()));
        $DB->delete_records('format_flexpage_field', array('pageid' => $page->get_id()));
        $DB->delete_records('format_flexpage_completion', array('pageid' => $page->get_id()));

        $page->set_conditions(array());
    }

    /**
     * Fetches all conditions for a page or course
     *
     * @param int $courseid
     * @param null|int $pageid
     * @return array
     */
    protected function get_conditions($courseid, $pageid = null) {
        return $this->merge_conditions(
            $this->get_field_conditions($courseid, $pageid),
            $this->get_grade_conditions($courseid, $pageid),
            $this->get_completion_conditions($courseid, $pageid)
        );
    }

    /**
     * Pass any number of condition arrays to merge.
     *
     * @return array
     */
    protected function merge_conditions() {
        $args       = func_get_args();
        $conditions = array_shift($args);
        foreach ($args as $otherconditions) {
            foreach ($otherconditions as $pageid => $pageconditions) {
                if (array_key_exists($pageid, $conditions)) {
                    $conditions[$pageid] = array_merge($conditions[$pageid], $pageconditions);
                } else {
                    $conditions[$pageid] = $pageconditions;
                }
            }
        }
        return $conditions;
    }

    /**
     * Get grade conditions
     *
     * @param int $courseid
     * @param null|int $pageid
     * @return array
     */
    protected function get_grade_conditions($courseid, $pageid = null) {
        global $CFG, $DB;

        if (empty($CFG->enableavailability)) {
            return array();
        }
        if (!is_null($pageid)) {
            $sqlwhere = 'p.id = ?';
            $params   = array($pageid);
        } else {
            $sqlwhere = 'p.courseid = ?';
            $params   = array($courseid);
        }
        $rs = $DB->get_recordset_sql(
            "SELECT c.id AS conditionid, g.*, c.pageid, c.grademin AS conditiongrademin, c.grademax AS conditiongrademax
               FROM {format_flexpage_page} p
         INNER JOIN {format_flexpage_grade} c ON p.id = c.pageid
         INNER JOIN {grade_items} g ON g.id = c.gradeitemid
              WHERE $sqlwhere
           ORDER BY conditionid", $params
        );

        $conditions = array();
        foreach ($rs as $record) {
            $item = new grade_item($record, false);
            $conditions[$record->pageid][] = new course_format_flexpage_model_condition_grade(
                $item->id, $record->conditiongrademin, $record->conditiongrademax, $item->get_name()
            );
        }
        return $conditions;
    }

    /**
     * Get user field conditions
     *
     * @param int $courseid
     * @param null|int $pageid
     * @return array
     */
    protected function get_field_conditions($courseid, $pageid = null) {
        global $CFG, $DB;

        if (empty($CFG->enableavailability)) {
            return array();
        }
        if (!is_null($pageid)) {
            $sqlwhere = 'p.id = ?';
            $params   = array($pageid);
        } else {
            $sqlwhere = 'p.courseid = ?';
            $params   = array($courseid);
        }
        $rs = $DB->get_recordset_sql(
            "SELECT f.*, uf.name, uf.shortname
               FROM {format_flexpage_page} p
         INNER JOIN {format_flexpage_field} f ON p.id = f.pageid
          LEFT JOIN {user_info_field} uf ON f.customfieldid =  uf.id
              WHERE $sqlwhere
           ORDER BY f.id", $params
        );

        $conditions = array();
        foreach ($rs as $record) {
            if (!empty($record->customfieldid)) {
                $field     = $record->customfieldid;
                $fieldname = $record->name; // Might be null, means field deleted.
                $shortname = $record->shortname; // Might be null, means field deleted.
            } else {
                $field     = $record->userfield;
                $fieldname = $record->userfield;
                $shortname = null;
            }
            $conditions[$record->pageid][] = new course_format_flexpage_model_condition_field(
                $field, $fieldname, $record->operator, $record->value, $shortname
            );
        }
        return $conditions;
    }

    /**
     * Get completion conditions
     *
     * @param int $courseid
     * @param null|int $pageid
     * @return array
     */
    protected function get_completion_conditions($courseid, $pageid = null) {
        global $DB;

        $completion = new completion_info($DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST));
        if (!$completion->is_enabled()) {
            return array();
        }

        if (!is_null($pageid)) {
            $sqlwhere = 'p.id = ?';
            $params   = array($pageid);
        } else {
            $sqlwhere = 'p.courseid = ?';
            $params   = array($courseid);
        }
        $rs = $DB->get_recordset_sql(
            "SELECT c.*
               FROM {format_flexpage_page} p
         INNER JOIN {format_flexpage_completion} c ON p.id = c.pageid
         INNER JOIN {course_modules} cm ON cm.id = c.cmid
              WHERE $sqlwhere
           ORDER BY c.id", $params
        );

        $conditions = array();
        foreach ($rs as $record) {
            $conditions[$record->pageid][] = new course_format_flexpage_model_condition_completion(
                $record->cmid, $record->requiredcompletion
            );
        }
        return $conditions;
    }

    /**
     * Save an array of conditions
     *
     * @param course_format_flexpage_model_page $page
     * @param array $conditions
     * @return course_format_flexpage_repository_condition
     */
    public function save_page_conditions(course_format_flexpage_model_page $page, array $conditions) {
        $grade = $completion = $field = array();
        foreach ($conditions as $condition) {
            if ($condition instanceof course_format_flexpage_model_condition_grade) {
                $grade[] = $condition;
            } else if ($condition instanceof course_format_flexpage_model_condition_completion) {
                $completion[] = $condition;
            } else if ($condition instanceof course_format_flexpage_model_condition_field) {
                $field[] = $condition;
            }
        }
        $this->save_page_grade_conditions($page, $grade)
             ->save_page_field_conditions($page, $field)
             ->save_page_completion_conditions($page, $completion);

        return $this;
    }

    /**
     * Save grade conditions
     *
     * @param course_format_flexpage_model_page $page
     * @param course_format_flexpage_model_condition_grade[] $conditions
     * @return course_format_flexpage_repository_condition
     */
    public function save_page_grade_conditions(course_format_flexpage_model_page $page, array $conditions) {
        global $DB;

        $records = array();
        foreach ($conditions as $condition) {
            $record = (object) array(
                'pageid' => $page->get_id(),
                'gradeitemid' => $condition->get_gradeitemid(),
                'grademin' => $condition->get_min(),
                'grademax'=> $condition->get_max()
            );
            $params = array(
                'pageid' => $page->get_id(),
                'gradeitemid' => $condition->get_gradeitemid()
            );
            if ($id = $DB->get_field('format_flexpage_grade', 'id', $params)) {
                $record->id = $id;
            }
            $records[] = $record;
        }
        return $this->save_condition_records($records, 'format_flexpage_grade', $page);
    }

    /**
     * Save user field conditions
     *
     * @param course_format_flexpage_model_page $page
     * @param course_format_flexpage_model_condition_field[] $conditions
     * @return course_format_flexpage_repository_condition
     */
    public function save_page_field_conditions(course_format_flexpage_model_page $page, array $conditions) {
        global $DB;

        $records = array();
        foreach ($conditions as $condition) {
            $record = (object) array(
                'pageid' => $page->get_id(),
                'userfield' => null,
                'customfieldid' => null,
                'operator' => $condition->get_operator(),
                'value' => $condition->get_value(),
            );
            if ($condition->is_custom()) {
                $field = 'customfieldid';
            } else {
                $field = 'userfield';
            }
            $record->$field = $condition->get_field();

            $params = array(
                'pageid' => $page->get_id(),
                $field => $condition->get_field(),
            );
            if ($id = $DB->get_field('format_flexpage_field', 'id', $params)) {
                $record->id = $id;
            }
            $records[] = $record;
        }
        return $this->save_condition_records($records, 'format_flexpage_field', $page);
    }

    /**
     * Save completion conditions
     *
     * @param course_format_flexpage_model_page $page
     * @param course_format_flexpage_model_condition_completion[] $conditions
     * @return course_format_flexpage_repository_condition
     */
    public function save_page_completion_conditions(course_format_flexpage_model_page $page, array $conditions) {
        global $DB;

        $records = array();
        foreach ($conditions as $condition) {
            $record = (object) array(
                'pageid' => $page->get_id(),
                'cmid' => $condition->get_cmid(),
                'requiredcompletion' => $condition->get_requiredcompletion()
            );
            $params = array(
                'pageid' => $page->get_id(),
                'cmid' => $condition->get_cmid(),
            );
            if ($id = $DB->get_field('format_flexpage_completion', 'id', $params)) {
                $record->id = $id;
            }
            $records[] = $record;
        }
        return $this->save_condition_records($records, 'format_flexpage_completion', $page);
    }

    /**
     * Attempts to re-use records and then deletes any remaining
     * records that were not re-used.
     *
     * @param stdClass[] $records Records to be saved
     * @param string $table The table to save the records to
     * @param course_format_flexpage_model_page $page The page that owns the records
     * @return $this
     */
    protected function save_condition_records($records, $table, course_format_flexpage_model_page $page) {
        global $DB;

        $saveids = array();

        foreach ($records as $record) {
            if (!empty($record->id)) {
                $saveids[]  = $record->id;
                $DB->update_record($table, $record);
            } else {
                $saveids[] = $DB->insert_record($table, $record);
            }
        }
        if (!empty($saveids)) {
            list($select, $params) = $DB->get_in_or_equal($saveids, SQL_PARAMS_QM, '', false);
            $params[] = $page->get_id();

            $DB->delete_records_select($table, "id $select AND pageid = ?", $params);
        } else {
            $DB->delete_records($table, array('pageid' => $page->get_id()));
        }
        return $this;
    }
}