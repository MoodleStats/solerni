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

defined('MOODLE_INTERNAL') || die();

require_once(dirname(dirname(dirname(__FILE__))).'/format/lib.php');

/**
 * Main class for the Flexpage course format
 *
 * @package format_flexpage
 * @author Mark Nielsen
 */
class format_flexpage extends format_base {
    /**
     * Load the navigation with all of the course's flexpages
     *
     * @param global_navigation $navigation
     * @param navigation_node $node
     * @return array
     */
    public function extend_course_navigation($navigation, navigation_node $node) {
        global $CFG, $COURSE;

        if (!$course = $this->get_course()) {
            return array();
        }
        require_once($CFG->dirroot.'/course/format/flexpage/locallib.php');

        $cache         = format_flexpage_cache($course->id);
        $current       = $cache->get_current_page();
        $activepageids = $cache->get_page_parents($current);
        $activepageids = array_keys($activepageids);
        $parentnodes   = array(0 => $node);
        $modinfo       = get_fast_modinfo($course);

        foreach ($cache->get_pages() as $page) {
            /**
             * @var navigation_node $childnode
             * @var navigation_node $parentnode
             */

            if (!$cache->is_page_in_menu($page)) {
                continue;
            }
            if (!array_key_exists($page->get_parentid(), $parentnodes)) {
                continue;
            }
            $parentnode = $parentnodes[$page->get_parentid()];

            if ($parentnode->hidden) {
                continue;
            }
            $availability = $cache->is_page_available($page, $modinfo);

            if ($availability === false) {
                continue;
            }
            $childnode = $parentnode->add(format_string($page->get_name()), $page->get_url());
            $childnode->hidden = is_string($availability);
            $parentnodes[$page->get_id()] = $childnode;

            // Only force open or make active when it's the current course
            if ($COURSE->id == $course->id) {
                if (in_array($page->get_id(), $activepageids)) {
                    $childnode->force_open();
                } else if ($page->get_id() == $current->get_id()) {
                    $childnode->make_active();
                }
            }
        }
        unset($activepageids, $parentnodes);

        // @todo Would be neat to return section zero with the name of "Activities" and it had every activity underneath it.
        // @todo This would require though that every activity was stored in section zero and had proper ordering

        return array();
    }

    public function supports_ajax() {
        return (object) array(
            'capable'        => true,
            'testedbrowsers' => array(
                'MSIE'   => 6.0,
                'Gecko'  => 20061111,
                'Safari' => 531,
                'Chrome' => 6.0
            )
        );
    }

    public function get_view_url($section, $options = array()) {
        return new moodle_url('/course/view.php', array('id' => $this->get_courseid()));
    }

    public function get_default_blocks() {
        return array(
            BLOCK_POS_LEFT  => array(),
            BLOCK_POS_RIGHT => array(),
        );
    }

    /**
     * Modify the page layout if view the course page
     *
     * @param moodle_page $page
     */
    public function page_set_course(moodle_page $page) {
        global $CFG, $SCRIPT;

        // ONLY modify layout if we are going to view the course page
        if ($SCRIPT != '/course/view.php') {
            return;
        }
        require_once($CFG->dirroot.'/course/format/flexpage/locallib.php');

        if ($page->pagelayout == 'admin') {
            return; // This is for block editing.
        }
        if (format_flexpage_set_pagelayout($page)) {
            // Hack alert - we call this to "freeze" the page layout et al
            // See format_flexpage_renderer::__construct for the rest of the hack
            $page->theme;
        }
    }

    /**
     * Prevent viewing of the activity if all of the
     * flexpages it is on are not available to the user.
     *
     * @param moodle_page $page
     * @throws moodle_exception
     */
    public function page_set_cm(moodle_page $page) {
        global $DB, $CFG;

        require_once($CFG->dirroot.'/course/format/flexpage/locallib.php');

        $context = context_course::instance($page->cm->course);

        $records = $DB->get_recordset_sql('
            SELECT DISTINCT i.subpagepattern AS pageid
              FROM {block_instances} i
        INNER JOIN {block_flexpagemod} f ON i.id = f.instanceid
             WHERE f.cmid = ?
               AND i.parentcontextid = ?
               AND i.subpagepattern IS NOT NULL
        ', array($page->cm->id, $context->id));

        if ($records->valid()) {
            $cache   = format_flexpage_cache($page->cm->course);
            $visible = false;
            foreach ($records as $record) {
                $parents = $cache->get_page_parents($cache->get_page($record->pageid), true);
                foreach ($parents as $parent) {
                    if ($cache->is_page_available($parent) !== true) {
                        // If any parent not available, then go onto next page
                        continue 2;
                    }
                }
                // Means the page is visible (because itself and parents are visible),
                // If one page is visible then cm is available
                $visible = true;
                break;
            }
            $records->close();

            // Means no pages were visible, cm is not available
            if (!$visible) {
                throw new moodle_exception('preventactivityview', 'format_flexpage', new moodle_url('/course/view.php', array('id' => $page->cm->course)));
            }
        }
        $records->close();
    }
    
    /**
     * Definitions of the additional options that this course format uses for course
     *
     * This function may be called often, it should be as fast as possible.
     * Avoid using get_string() method, use "new lang_string()" instead
     * It is not recommended to use dynamic or course-dependant expressions here
     * This function may be also called when course does not exist yet.
     *
     * Option names must be different from fields in the {course} talbe or any form elements on
     * course edit form, it may even make sence to use special prefix for them.
     *
     * Each option must have the option name as a key and the array of properties as a value:
     * 'default' - default value for this option (assumed null if not specified)
     * 'type' - type of the option value (PARAM_INT, PARAM_RAW, etc.)
     *
     * Additional properties used by default implementation of
     * {@link format_base::create_edit_form_elements()} (calls this method with $foreditform = true)
     * 'label' - localised human-readable label for the edit form
     * 'element_type' - type of the form element, default 'text'
     * 'element_attributes' - additional attributes for the form element, these are 4th and further
     *    arguments in the moodleform::addElement() method
     * 'help' - string for help button. Note that if 'help' value is 'myoption' then the string with
     *    the name 'myoption_help' must exist in the language file
     * 'help_component' - language component to look for help string, by default this the component
     *    for this course format
     *
     * This is an interface for creating simple form elements. If format plugin wants to use other
     * methods such as disableIf, it can be done by overriding create_edit_form_elements().
     *
     * Course format options can be accessed as:
     * $this->get_course()->OPTIONNAME (inside the format class)
     * course_get_format($course)->get_course()->OPTIONNAME (outside of format class)
     *
     * All course options are returned by calling:
     * $this->get_format_options();
     *
     * @param bool $foreditform
     * @return array of options
     */
    public function course_format_options($foreditform = false) {
        global $CFG,$DB;
        static $courseformatoptions = false;
           
        if ($courseformatoptions === false) {
            $courseconfig = get_config('moodlecourse');
            $courseformatoptions = array(
                'numsections' => array(
                    'default' => $courseconfig->numsections,
                    'type' => PARAM_INT,
                ),
                'hiddensections' => array(
                    'default' => $courseconfig->hiddensections,
                    'type' => PARAM_INT,
                ),
                'coursedisplay' => array(
                    'default' => $courseconfig->coursedisplay,
                    'type' => PARAM_INT,
                ),
                'coursestatus' => array(
                    'default' => get_config('status','format_flexpage'),
                    'type' => PARAM_INT,
                ),
                'coursepicture' => array(
                    'default' => get_config('picture','format_flexpage'),
                    'type' => PARAM_CLEANFILE,
                ),
                'courseenddate' => array(
                    'default' => get_config('enddate','format_flexpage'),
                    'type' => PARAM_INT,
                ),
                'courseworkingtime' => array(
                    'default' => get_config('workingtime','format_flexpage'),
                    'type' => PARAM_INT,
                ),
                'courseprice' => array(
                    'default' => get_config('price','format_flexpage'),
                    'type' => PARAM_INT,
                ),
                'coursevideo' => array(
                    'default' => get_config('video','format_flexpage'),
                    'type' => PARAM_INT,
                ),
                'registration_startdate' => array(
                    'default' => get_config('registration_startdate','format_flexpage'),
                    'type' => PARAM_INT,
                ),
                'registration_enddate' => array(
                    'default' => get_config('registration_enddate','format_flexpage'),
                    'type' => PARAM_INT,
                ),
                'courseteachingteam' => array(
                    'default' => get_config('teachingteam','format_flexpage'),
                    'type' => PARAM_NOTAGS,
                ),
                'courseprerequesites' => array(
                    'default' => get_config('prerequesites','format_flexpage'),
                    'type' => PARAM_TEXT,
                ),
                'duration' => array(
                    'default' => get_config('duration','format_flexpage'),
                    'type' => PARAM_INT,
                )
            );
        }
        if ($foreditform && !isset($courseformatoptions['coursedisplay']['label'])) {
            $courseconfig = get_config('moodlecourse');
            $max = $courseconfig->maxsections;
            if (!isset($max) || !is_numeric($max)) {
                $max = 52;
            }
            $sectionmenu = array();
            for ($i = 0; $i <= $max; $i++) {
                $sectionmenu[$i] = "$i";
            }
            $courseformatoptionsedit = array(
                'numsections' => array(
                    'label' => new lang_string('numberweeks'),
                    'element_type' => 'select',
                    'element_attributes' => array($sectionmenu)
                ),
                'hiddensections' => array(
                    'label' => new lang_string('hiddensections'),
                    'help' => 'hiddensections',
                    'help_component' => 'moodle',
                    'element_type' => 'select',
                    'element_attributes' => array(
                        array(
                            0 => new lang_string('hiddensectionscollapsed'),
                            1 => new lang_string('hiddensectionsinvisible')
                        )
                    )
                ),
                'coursedisplay' => array(
                    'label' => new lang_string('coursedisplay'),
                    'element_type' => 'select',
                    'element_attributes' => array(
                        array(
                            COURSE_DISPLAY_SINGLEPAGE => new lang_string('coursedisplay_single'),
                            COURSE_DISPLAY_MULTIPAGE => new lang_string('coursedisplay_multi')
                        )
                    ),
                    'help' => 'coursedisplay',
                    'help_component' => 'moodle'
                ),
                'coursestatus' => array(
                    'label' => new lang_string('status', 'format_flexpage'),
                    'help' => 'status',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'select',
                    'element_attributes' => array(
                        array(
                            0 => get_string('current', 'format_flexpage'),
                            1 => get_string('startingsoon', 'format_flexpage'),
                            2 => get_string('closed', 'format_flexpage')
                        )
                    )
                ),
                'coursepicture' => array(
                    'label' => new lang_string('picture', 'format_flexpage'),
                    'element_type' => 'filemanager',
                    'element_attributes' => array(
                            'subdirs' => 0, 
                            'maxbytes' => $CFG->maxbytes, 
                            'maxfiles' => 1,
                            'accepted_types' => array('document'), 
                            'return_types'=> FILE_INTERNAL | FILE_EXTERNAL
                        ),
                    'help' => 'picture',
                    'help_component' => 'format_flexpage',
                ),
                'courseenddate' => array(
                    'label' => get_string('enddate', 'format_flexpage'),
                    'help' => 'enddate',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'date_selector'                 
                ),
                'courseworkingtime' => array(
                    'label' => get_string('workingtime', 'format_flexpage'),
                    'help' => 'workingtime',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'select',
                    'element_attributes' => array(
                        array(
                            0 => get_string('inf_one', 'format_flexpage'),
                            1 => get_string('one_two', 'format_flexpage'),
                            2 => get_string('two_three', 'format_flexpage')
                        )
                     )
                ),
                'courseprice' => array(
                    'label' => new lang_string('price', 'format_flexpage'),
                    'element_type' => 'text',
                    'help' => 'price',
                    'help_component' => 'format_flexpage',
                ),
                'coursevideo' => array(
                    'label' => get_string('video', 'format_flexpage'),
                    'help' => 'video',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'select',
                    'element_attributes' => array(
                        array(
                            0 => get_string('true', 'format_flexpage'),
                            1 => get_string('false', 'format_flexpage')
                        )
                    )
                ),
               'registration_startdate' => array(
                    'label' => get_string('registration_startdate', 'format_flexpage'),
                    'help' => 'registration_startdate',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'date_selector'                 
                ),
               'registration_enddate' => array(
                    'label' => get_string('registration_enddate', 'format_flexpage'),
                    'help' => 'registration_enddate',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'date_selector'                 
                ),
                'courseteachingteam' => array(
                    'label' => get_string('teachingteam', 'format_flexpage'),
                    'help' => 'teachingteam',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'text'
                ),
                'courseprerequesites' => array(
                    'label' => get_string('prerequesites', 'format_flexpage'),
                    'help' => 'prerequesites',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'text'
                ),
                'duration' => array(
                    'label' => get_string('duration', 'format_flexpage'),
                    'help' => 'duration',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'select',
                    'element_attributes' => array(
                        array(
                            0 => get_string('in_four_weeks', 'format_flexpage'),
                            1 => get_string('four_six_weeks', 'format_flexpage'),
                            2 => get_string('sup_six_weeks', 'format_flexpage')
                        )
                    )
                )
            );
            $courseformatoptions = array_merge_recursive($courseformatoptions, $courseformatoptionsedit);
        }
        return $courseformatoptions;    
        
    }
        /**
     * Updates format options for a course
     *
     * If $data does not contain property with the option name, the option will not be updated
     *
     * @param stdClass|array $data return value from {@link moodleform::get_data()} or array with data
     * @param stdClass $oldcourse if this function is called from {@link update_course()}
     *     this object contains information about the course before update
     * @return bool whether there were any changes to the options values
     */
    public function update_course_format_options($data, $oldcourse = null) {
        $context = context_course::instance($this->courseid);
        $saved = file_save_draft_area_files($data->coursepicture, $context->id, 'format_flexpage',
        'coursepicture', 0, array('subdirs' => 0, 'maxfiles' => 1));
        return $this->update_format_options($data);
    }

}

/**
 * Cleanup all things flexpage on course deletion
 *
 * @param int $courseid
 * @return void
 */
/*function format_flexpage_delete_course($courseid) {
    global $CFG;

    require_once($CFG->dirroot.'/blocks/flexpagenav/repository/menu.php');
    require_once($CFG->dirroot.'/course/format/flexpage/repository/page.php');
    require_once($CFG->dirroot.'/course/format/flexpage/repository/cache.php');

    //$menurepo = new block_flexpagenav_repository_menu();
    //$menurepo->delete_course_menus($courseid);

    //$pagerepo = new course_format_flexpage_repository_page();
    //$pagerepo->delete_course_pages($courseid);

    //$cacherepo = new course_format_flexpage_repository_cache();
    //$cacherepo->delete_course_cache($courseid);
}*/
/**
 * 
 *
 * @param int $courseid
 * @return file
 */
function format_flexpage_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $DB;
       
    if ($context->contextlevel != CONTEXT_COURSE) {
        return false;
    }
    
    require_login();
    if ($filearea != 'coursepicture') {
        return false;
    }
    
    $itemid = (int)array_shift($args);
    if ($itemid != 0) {
        return false;
    }
    
    $fs = get_file_storage();
    $filename = array_pop($args);
    
    if (empty($args)) {
        $filepath = '/';
    } else {
        $filepath = '/'.implode('/', $args).'/';
    }
    
    $file = $fs->get_file($context->id, 'format_flexpage', $filearea, $itemid, $filepath, $filename);
    if (!$file) {
        return false;
    }
    
    send_stored_file($file, 0, 0, $forcedownload, $options);
}
