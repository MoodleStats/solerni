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
require_once($CFG->dirroot . '/local/orange_thematics/lib.php');

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
     *
     *
     *  orange 2015050500 : adding extended course data
     *     */
    public function course_format_options($foreditform = false) {
        global $CFG;
        static $courseformatoptions = false;

        if ($courseformatoptions === false) {
            $courseconfig = get_config('moodlecourse');
            $courseformatoptions = array(
                'courseenddate' => array(
                    'default' => get_config('enddate', 'format_flexpage'),
                    'type' => PARAM_INT,
                ),
                'coursethematics' => array(
                    'default' => get_config('workingtime', 'format_flexpage'),
                    'type' => PARAM_SEQUENCE,
                ),
                'coursepicture' => array(
                    'default' => get_config('picture', 'format_flexpage'),
                    'type' => PARAM_CLEANFILE,
                ),
                'coursereplay' => array(
                    'default' => get_config('coursereplay', 'format_flexpage'),
                    'type' => PARAM_INT,
                ),
                'courseduration' => array(
                    'default' => get_config('duration', 'format_flexpage'),
                    'type' => PARAM_INT,
                ),
                'courseworkingtime' => array(
                    'default' => get_config('workingtime', 'format_flexpage'),
                    'type' => PARAM_INT,
                ),
                'coursebadge' => array(
                    'default' => get_config('badge', 'format_flexpage'),
                    'type' => PARAM_INT,
                ),
                'coursecertification' => array(
                    'default' => get_config('certification', 'format_flexpage'),
                    'type' => PARAM_INT,
                ),
                'courseprice' => array(
                    'default' => get_config('price', 'format_flexpage'),
                    'type' => PARAM_INT,
                ),
                'courselanguage' => array(
                    'default' => get_config('language', 'format_flexpage'),
                    'type' => PARAM_INT,
                ),

                'coursesubtitle' => array(
                    'default' => get_config('coursesubtitle', 'format_flexpage'),
                    'type' => PARAM_INT,
                ),
                'courseregistration' => array(
                    'default' => get_config('registration', 'format_flexpage'),
                    'type' => PARAM_INT,
                ),

                'courseprerequesites' => array(
                    'default' => get_config('prerequesites', 'format_flexpage'),
                    'type' => PARAM_RAW,
                ),
                'courseteachingteam' => array(
                    'default' => get_config('teachingteam', 'format_flexpage'),
                    'type' => PARAM_RAW,
                ),
                'coursecontactemail' => array(
                    'default' => get_config('contactemail', 'format_flexpage'),
                    'type' => PARAM_TEXT,
                    'default' => 'contact@solerni.com'
                ),
                'coursethumbnailtext' => array(
                    'default' => get_config('thumbnailtext', 'format_flexpage'),
                    'type' => PARAM_TEXT
                ),
                'coursevideoplayer' => array(
                    'default' => get_config('videoplayer', 'format_flexpage'),
                    'type' => PARAM_RAW
                ),
                'courseinactivitydelay' => array(
                    'default' => get_config('inactivitydelay', 'format_flexpage'),
                    'type' => PARAM_INT,
                    'default' => 7
                )
            );
        }
        if ($foreditform && !isset($courseformatoptions['coursedisplay']['label'])) {
            $courseconfig = get_config('moodlecourse');

            // Get list Id of thematic.
            global $DB;
            $listthematics = array();
            $thematics = thematic_get_thematic();
            foreach ($thematics as $thematic) {
                $listthematics[$thematic->id] = $thematic->name;
            }

            $courseformatoptionsedit = array(
                'courseenddate' => array(
                    'label' => get_string('enddate', 'format_flexpage'),
                    'help' => 'enddate',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'date_selector'
                ),

                'coursethematics' => array(
                    'label' => get_string('coursethematics', 'format_flexpage'),
                    'help' => 'coursethematics',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'select',
                    'element_attributes' => array(
                        $listthematics
                     )
                ),
                'coursepicture' => array(
                    'label' => get_string('picture', 'format_flexpage'),
                    'element_type' => 'filemanager',
                    'element_attributes' => array(
                        array(
                            'subdirs' => 0,
                            'maxbytes' => $CFG->maxbytes,
                            'maxfiles' => 1,
                            'accepted_types' => array('document'),
                            'return_types' => FILE_INTERNAL | FILE_EXTERNAL
                            )
                        ),
                    'help' => 'picture',
                    'help_component' => 'format_flexpage',
                ),
                'coursereplay' => array(
                    'label' => get_string('coursereplay', 'format_flexpage'),
                    'help' => 'coursereplay',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'select',
                    'element_attributes' => array(
                        array(
                            0 => get_string('replay', 'format_flexpage'),
                            1 => get_string('notreplay', 'format_flexpage')
                            )
                    )
                ),
                'courseworkingtime' => array(
                    'label' => get_string('workingtime', 'format_flexpage'),
                    'help' => 'workingtime',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'duration',
                    'element_attributes' => array(
                    'defaultunit' => 86400,
                    'units' => array(3600, 86400),
                    'optional' => true
                        )
                ),
                'courseprice' => array(
                    'label' => get_string('price', 'format_flexpage'),
                    'help' => 'price',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'select',
                    'element_attributes' => array(
                        array(
                            0 => get_string('price_case1', 'format_flexpage'),
                            1 => get_string('price_case2', 'format_flexpage'),
                            2 => get_string('price_case3', 'format_flexpage')
                        )
                        )
                ),
                'coursebadge' => array(
                    'label' => get_string('badge', 'format_flexpage'),
                    'help' => 'badge',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'advcheckbox'
                ),
                'coursecertification' => array(
                    'label' => get_string('certification', 'format_flexpage'),
                    'help' => 'certification',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'advcheckbox'
                ),

                'coursesubtitle' => array(
                    'label' => get_string('subtitle', 'format_flexpage'),
                    'help' => 'subtitle',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'advcheckbox'
                ),

                'courseregistration' => array(
                    'label' => get_string('registration', 'format_flexpage'),
                    'help' => 'registration',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'select',
                    'element_attributes' => array(
                        array(
                            0 => get_string('registration_case1', 'format_flexpage'),
                            1 => get_string('registration_case2', 'format_flexpage'),
                            2 => get_string('registration_case3', 'format_flexpage')
                        )
                        )
                ),
                'courselanguage' => array(
                    'label' => get_string('language', 'format_flexpage'),
                    'help' => 'language',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'select',
                    'element_attributes' => array(
                        array(
                            0 => get_string('french', 'format_flexpage'),
                            1 => get_string('english', 'format_flexpage')
                            )
                    )
                ),
                'courseteachingteam' => array(
                    'label' => get_string('teachingteam', 'format_flexpage'),
                    'help' => 'teachingteam',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'htmleditor'
                ),
                'courseprerequesites' => array(
                    'label' => get_string('prerequesites', 'format_flexpage'),
                    'element_type' => 'htmleditor'
                ),
                'courseduration' => array(
                    'label' => get_string('duration', 'format_flexpage'),
                    'help' => 'duration',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'duration',
                    'element_attributes' => array(
                    'defaultunit' => 86400,
                    'optional' => false
                    )
                ),
                'coursecontactemail' => array(
                    'label' => get_string('contactemail', 'format_flexpage'),
                    'help' => 'contactemail',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'text'
                ),
                'coursethumbnailtext' => array(
                    'label' => get_string('thumbnailtext', 'format_flexpage'),
                    'help' => 'thumbnailtext',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'text'
                ),
                'coursevideoplayer' => array(
                    'label' => get_string('videoplayer', 'format_flexpage'),
                    'help' => 'videoplayer',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'textarea'
                ),
                'courseinactivitydelay' => array(
                    'label' => get_string('inactivitydelay', 'format_flexpage'),
                    'help' => 'inactivitydelay',
                    'help_component' => 'format_flexpage',
                    'element_type' => 'text'
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
        $data = (array)$data;

        if (isset($data['coursethematics'])) {
            $selectedids = implode(",", $data['coursethematics']);
            $data['coursethematics'] = $selectedids;
        }

        return $this->update_format_options($data);
    }

    /**
     * Adds format options elements to the course/section edit form.
     *
     * This function is called from {@link course_edit_form::definition_after_data()}.
     *
     * @param MoodleQuickForm $mform form the elements are added to.
     * @param bool $forsection 'true' if this is a section edit form, 'false' if this is course edit form.
     * @return array array of references to the added form elements.
     */
    public function create_edit_form_elements(&$mform, $forsection = false) {
        $elements = parent::create_edit_form_elements($mform, $forsection);

        // Increase the number of sections combo box values if the user has increased the number of sections
        // using the icon on the course page beyond course 'maxsections' or course 'maxsections' has been
        // reduced below the number of sections already set for the course on the site administration course
        // defaults page.  This is so that the number of sections is not reduced leaving unintended orphaned
        // activities / resources.
        if (!$forsection) {
            $coursethematics = & $mform->getElement('coursethematics');
            $coursethematics->setMultiple(true);
        }

        return $elements;
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

    // ...requirelogin supressed to allow course image.
    // ...require_login();.
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
