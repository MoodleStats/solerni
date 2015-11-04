<?php
// This file is part of The Orange Halloween Moodle Theme
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

use local_orange_library\badges\badges_object;
use local_orange_library\utilities\utilities_object;
use local_orange_library\utilities\utilities_image;
use local_orange_library\utilities\utilities_course;
use local_orange_library\subscription_button\subscription_button_object;

require_once($CFG->dirroot . '/course/renderer.php');
require_once($CFG->dirroot . '/blocks/orange_progressbar/lib.php');
require_once($CFG->dirroot.'/blocks/orange_course_dashboard/locallib.php');


class theme_halloween_core_course_renderer extends core_course_renderer {

    /**
     * Returns HTML to print list of available courses for the frontpage
     *
     * This is an override from Moodle in order to add a custom heading on frontpage.
     * That's all Folks.
     *
     * @return string
     */
    public function frontpage_available_courses() {
        global $CFG;
        require_once($CFG->libdir. '/coursecatlib.php');

        $chelper = new coursecat_helper();
        $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_EXPANDED)->set_courses_display_options(
                array(
                'recursive' => true,
                'limit' => $CFG->frontpagecourselimit,
                'viewmoreurl' => new moodle_url('/course/index.php'),
                'viewmoretext' => new lang_string('fulllistofcourses')
            ));

        $chelper->set_attributes(array('class' => ''));
        $courses = coursecat::get(0)->get_courses($chelper->get_courses_display_options());
        $totalcount = coursecat::get(0)->get_courses_count($chelper->get_courses_display_options());
        if (!$totalcount && !$this->page->user_is_editing() && has_capability('moodle/course:create', context_system::instance())) {
            // Print link to create a new course, for the 1st available category.
            return $this->add_new_course_button();
        }

        // Add heading before frontpage mooc list.
        echo $this->halloween_frontpage_heading();

        return $this->coursecat_courses($chelper, $courses, $totalcount);
    }

    /**
     * Override from Moodle
     * to remplace Course Component rendering
     * and check user right to view the course
     *
     * @global type $CFG
     * @global type $USER
     * @global type $PAGE
     * @param coursecat_helper $chelper
     * @param type $course
     * @param string $additionalclasses
     * @return type : HTML Fraglent
     */
    protected function coursecat_coursebox(coursecat_helper $chelper, $course, $additionalclasses = '') {
        global $USER;
        $content = '';

        $utilitiescourse = new utilities_course();
        $additionalclasses = ' '. $additionalclasses;

        // End code to display only allowed MOOC.
        if ($utilitiescourse->can_user_view_course($course, $USER)) {
            $content = $this->render_halloween_mooc_component($chelper, $course, $additionalclasses);
        }

        return $content;
    }

    /**
     * Returns HTML to display the subcategories and courses in the given category
     *
     * This method is re-used by AJAX to expand content of not loaded category
     *
     * @param coursecat_helper $chelper various display options
     * @param coursecat $coursecat
     * @param int $depth depth of the category in the current tree
     * @return string
     */
    protected function coursecat_category_content(coursecat_helper $chelper, $coursecat, $depth) {

        Global $PAGE;

        // Category header for customer info and logo.
        $PAGE->requires->css('/theme/halloween/style/catalogue.css');
        $PAGE->requires->css('/local/orange_library/style.css');

        $utilitiescourse = new utilities_course();
        $customer = $utilitiescourse->solerni_course_get_customer_infos($coursecat->id);

        $content = '';
        if (isset($customer->id)) {
            $content .= "<div >";
            if ($customer->urlpicture != "") {
                $content .= "<div><img  src='";
                $content .= utilities_image::get_resized_url($customer->urlpicture, array ('scale' => 'true', 'h' => 216, 'w' => 966));
                $content .= "' alt='{$customer->name}' /></div>";
            }
            if ($customer->urlimg != "") {
                $content .= "<div ><img  src='";
                $content .= utilities_image::get_resized_url($customer->urlimg, array ('scale' => 'true', 'h' => 100));
                $content .= "' /></div>";
            }
            $content .= "<div ><h1>{$customer->name}</h1><div>{$customer->summary}</div></div>";
            $content .= "</div>";
        }
        // Subcategories.
        $content .= $this->coursecat_subcategories($chelper, $coursecat, $depth);

        // AUTO show courses: Courses will be shown expanded if this is not nested category,
        // and number of courses no bigger than $CFG->courseswithsummarieslimit.
        $showcoursesauto = $chelper->get_show_courses() == self::COURSECAT_SHOW_COURSES_AUTO;
        if ($showcoursesauto && $depth) {
                // This is definitely collapsed mode.
                $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_COLLAPSED);
        }

        // Courses.
        if ($chelper->get_show_courses() > core_course_renderer::COURSECAT_SHOW_COURSES_COUNT) {
            $courses = array();
            if (!$chelper->get_courses_display_option('nodisplay')) {
                    $courses = $coursecat->get_courses($chelper->get_courses_display_options());
            }
            if ($viewmoreurl = $chelper->get_courses_display_option('viewmoreurl')) {
                // The option for 'View more' link was specified, display more link
                // (if it is link to category view page, add category id).
                if ($viewmoreurl->compare(new moodle_url('/course/index.php'), URL_MATCH_BASE)) {
                        $chelper->set_courses_display_option('viewmoreurl', new moodle_url($viewmoreurl,
                            array('categoryid' => $coursecat->id)));
                }
            }
            $content .= $this->coursecat_courses($chelper, $courses, $coursecat->get_courses_count());
        }

        if ($showcoursesauto) {
            // Restore the show_courses back to AUTO.
            $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_AUTO);
        }

        return $content;
    }

    /**
     * Lists the available courses for the catalogue
     *
     * @global type $CFG
     * @param type $filter
     * @return type string (HTML)
     */
    public function catalog_available_courses($filter) {
        global $CFG;
        require_once($CFG->libdir. '/coursecatlib.php');

        $options = array();
        $options['summary'] = true;

        $chelper = new coursecat_helper();

        // Pagination.
        $perpage = (optional_param('perpage', 0, PARAM_INT)) ? optional_param('perpage', 0, PARAM_INT) : $CFG->coursesperpage;
        $page = optional_param('page', 0, PARAM_INT);

        $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_COLLAPSED)->set_courses_display_options(array(
                        'recursive' => false,
                        'limit' => $perpage,
                        'offset' => $page * $perpage,
                        'paginationallowall' => false,
                        'paginationurl' => new moodle_url('/catalog/index.php'),
                        'viewmoreurl' => new moodle_url('/catalog/index.php'),
                        'viewmoretext' => new lang_string('fulllistofcourses')));
        $chelper->set_attributes(array('class' => ''));

        /* @todo
         * Refacto : init utilities in construct.
         */
        $utilitiescourse = new utilities_course();
        $courses = $utilitiescourse->get_courses_catalogue($filter, $chelper->get_courses_display_options());
        $totalcount = $utilitiescourse->get_courses_catalogue_count($filter, $chelper->get_courses_display_options());

        if ($totalcount == 0) {
            $countstring = get_string('catalog0result', 'theme_halloween');
        } else if ($totalcount == 1) {
            $countstring = $totalcount . " " . get_string('catalog1result', 'theme_halloween');
        } else if ($totalcount > 1) {
            $countstring = $totalcount . " " . get_string('catalognresults', 'theme_halloween');
        }

        return "<p>" . $countstring . "</p>" . $this->coursecat_courses($chelper, $courses, $totalcount);
    }

    /**
     * Verifies if the current input id is checked or not :
     * by convention, the input tag id is the same as the filter array order.
     * Special case for the "all" where checked could be an empty array (defaut position)
     *
     * @param int $inputid
     * @param array $filter
     * @return string
     */
    protected function render_filter_input_checked($inputid, $filter) {
        if ( $inputid == 0 ) {
            $checked = (count($filter) == 0) || (in_array(0, $filter)) ? ' checked' : '';
        } else {
            $checked = (in_array($inputid, $filter)) ? ' checked' : '';
        }

        return $checked;
    }

    /**
     *
     * render HTML fragment for a $filter which is an associative issued from
     * data HTTP POST method on the catalog page
     *
     * Function strongly correlated with $this->catalog_available_courses($filters)
     * and the /catalog/index.php
     *
     * Requires : the filter, the filter name and the label for each input
     *
     * @param array $filter
     * @param string $filtername
     * @param array $labels
     * @return string
     */
    protected function render_filter_fieldset($filter, $filtername, $labels) {
        $output = '<fieldset class="filters-form-fieldset">';
            $output .= '<legend class="form-fieldset-legend">' . get_string("filter{$filtername}title", 'theme_halloween') . '</legend>';

        foreach ($labels as $inputid => $inputlabel) {
            $checked = $this->render_filter_input_checked($inputid, $filter);
            $output .= '<div class="checkbox">';
                $output .= '<input id="' . $filtername . $inputid . '" class="form-fieldset-checkbox o-checkbox" type="checkbox" name="' . $filtername . 'id[]" value="' . $inputid . '"' . $checked .'>';
                $output .= '<label for="' . $filtername . $inputid . '">' . $inputlabel . '</label>';
            $output .= '</div>';
        }
        $output .= '</fieldset>';

        return $output;
    }

    /**
     * Render the status filter which is an associative issued from 'statusid'
     * data HTTP POST method on the catalog page
     * Each value is associated with its order inside the catalog filter form.
     * @param array $filter
     */
    public function render_course_catalog_filter_status($filter) {
        $labels = array (
            0 => get_string('filterstatusall', 'theme_halloween'),
            1 => get_string('filterstatusinprogress', 'theme_halloween'),
            2 => get_string('filterstatuscomingsoon', 'theme_halloween'),
            3 => get_string('filterstatuscomplete', 'theme_halloween')
        );

        return $this->render_filter_fieldset($filter, 'status', $labels);
    }

    /**
     * Render the status filter which is an associative issued from 'thematicsid'
     * data HTTP POST method on the catalog page
     * Each value is associated with its order inside the catalog filter form.
     * @param array $filter
     */
    public function render_course_catalog_filter_thematics($filter) {
        global $DB;
        $labels = array (0 => get_string('filterthematicsall', 'theme_halloween'));
        $thematics = $DB->get_recordset('orange_thematics');

        if ($thematics) {
            foreach ($thematics as $thematic) {
                $labels[$thematic->id] = format_text($thematic->name);
            }
        }

        return $this->render_filter_fieldset($filter, 'thematics', $labels);
    }

    /**
     * Render the status filter which is an associative issued from 'durationid'
     * data HTTP POST method on the catalog page
     * Each value is associated with its order inside the catalog filter form.
     * @param array $filter
     */
    public function render_course_catalog_filter_duration($filter) {
        $labels = array (
            0 => get_string('filterdurationall', 'theme_halloween'),
            1 => get_string('filterdurationless4', 'theme_halloween'),
            2 => get_string('filterdurationfrom4to6', 'theme_halloween'),
            3 => get_string('filterdurationmore6', 'theme_halloween')
        );

        return $this->render_filter_fieldset($filter, 'duration', $labels);
    }

    /**
     * Render the status filter which is an associative issued from 'categoriesid'
     * data HTTP POST method on the catalog page (categories = customers)
     * Each value is associated with its order inside the catalog filter form.
     * @param array $filter
     */
    public function render_course_catalog_filter_categories($filter) {
        global $CFG;
        require_once($CFG->libdir . '/coursecatlib.php');
        $categories = coursecat::make_categories_list();

        $labels[] = get_string('filtercategoryall', 'theme_halloween');
        if ($categories) {
            foreach ($categories as $id => $category) {
                $labels[$id] = $category;
            }
        }

        return $this->render_filter_fieldset($filter, 'category', $labels);
    }

    /**
     * Render a halloween Mooc (CourseBox) HTML Fragment from partials/course_component template
     *
     *
     * @global type $CFG
     * @param type $chelper
     * @param type $course
     * @param type $additionalclasses
     * @return string
     */
    public function render_halloween_mooc_component($chelper, $course, $additionalclasses = '') {
            global $CFG;

            if (!$chelper) {
                $chelper = $this->halloween_create_mooc_helper();
            }
            $chelper = $this->halloween_create_mooc_helper();
            if ($chelper->get_show_courses() <= self::COURSECAT_SHOW_COURSES_COUNT) {
                return '';
            }

            if ($course instanceof stdClass) {
                require_once($CFG->libdir. '/coursecatlib.php');
                $course = new course_in_list($course);
            }

            if (!isset($this->strings->summary)) {
                $this->strings->summary = get_string('summary');
            }

            // Instanciate halloween objects.
            $badges                 = new badges_object();
            $utilitiescourse        = new utilities_course();
            $imageutilities         = new utilities_image();
            $subscriptionbutton     = new subscription_button_object($course);
            $utilities              = new utilities_object();

            // Get customer info related to Moodle category.
            $customer = $utilitiescourse->solerni_course_get_customer_infos($course->category);
            // Get course informations.
            $courseinfos = $utilitiescourse->solerni_get_course_infos($course);

            $classes = '';
            $coursename = $chelper->get_course_formatted_name($course);

            if ($chelper->get_show_courses() >= self::COURSECAT_SHOW_COURSES_EXPANDED) {
                    $nametag = 'h3';
            } else {
                    $classes .= ' ';
                    $nametag = 'div';
            }

            // Get information on user progress in course
            list ($progressstatus, $progresscompleteted, $progresstotal, $progress) = user_course_progress ($course);
            // Generate code with buffering to include partial.
            ob_start();
            include( $CFG->partialsdir . '/course_component.php');
            $content = ob_get_contents();
            ob_end_clean();

            return $content;
    }

    /**
     * Renders course info box.
     *
     * @param stdClass|course_in_list $course
     * @return string
     *
     * Overriden to make sure we use the same function everywhere
     * and output the Mooc Component
     *
     * @return string
     */
    public function course_info_box(stdClass $course) {
        $content = '';
        $content .= $this->output->box_start('generalbox info');
        $content .= $this->render_halloween_mooc_component(null, $course, null);
        $content .= $this->output->box_end();
        return $content;
    }

    /*
     * Create chelper object in case we don't have one
     *
     * no @param
     * return chelper object
     */
    public function halloween_create_mooc_helper() {
        global $CFG;

        require_once($CFG->libdir. '/coursecatlib.php');
        $chelper = new coursecat_helper();
        $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_EXPANDED);

        return $chelper;
    }

    /*
     * Print the halloween frontpage heading
     * Just before the courses list
     *
     * @return string
     */
     public function halloween_frontpage_heading() {

        global $PAGE;
        $heading = (isset($PAGE->theme->settings->catalogtitle) ) ?
                   $PAGE->theme->settings->catalogtitle :
                   get_string('catalogtitledefault', 'theme_halloween');
        ?>
        <div>
        <?php if (isset($PAGE->theme->settings->catalogue)) : ?>
            <a href="<?php echo $PAGE->theme->settings->catalogue; ?>" >
                 <?php echo get_string('seecatalog', 'theme_halloween'); ?>
            </a>
        <?php endif;?>
            <h2>
                <?php echo $heading; ?>
            </h2>
        </div>
        <?php }


    /**
     * Construct contents of Mymoocs page
     *
     * @param integer $filter
     *               0 : all moocs
     *               1 : moocs closed
     *               2 : moocs started
     *               3 : moocs running
     * @return string html to be displayed in page mymoocs
     */
    public function print_my_moocs($filter = utilities_course::MOOCRUNNING) {
        global $PAGE;

        $labels = array (
            3 => get_string('filterstatusinprogress', 'theme_halloween'),
            1 => get_string('filterstatuscomplete', 'theme_halloween'),
            2 => get_string('filterstatuscomingsoon', 'theme_halloween'),
            0 => get_string('filterstatusall', 'theme_halloween'),
        );

        foreach ($labels as $key => $label) {
            $nbcourses[$key] = 0;
        }
        list($sortedcourses, $sitecourses, $totalcourses) = block_orange_course_dashboard_get_sorted_courses();

        $moocslist = "";
        $utilitiescourse = new utilities_course();
        foreach ($sitecourses as $key => $course) {
            $status = $utilitiescourse->get_course_status($course);

            $nbcourses[0] = $nbcourses[0] + 1;
            if ($filter == 0 || $filter == $status) {
                $moocslist .= $this->output->box_start('coursebox', "course-{$course->id}");
                $moocslist .= html_writer::start_tag('div', array('class' => 'course_title'));
                $moocslist .= $this->render_halloween_mooc_component(null, $course);
                $moocslist .= html_writer::end_tag('div');
                $moocslist .= $this->output->box('', 'flush');
                $moocslist .= $this->output->box_end();

                $nbcourses[$status] = $nbcourses[$status] + 1;
            } else {
                $nbcourses[$status] = $nbcourses[$status] + 1;
            }
        }

        if ($nbcourses[$filter] == 0) {
            $moocslist .= get_string('nocourses', 'my');
        }

        $buttons = html_writer::start_tag('div', array('class' => ''));
        foreach ($labels as $key => $label) {
            if($filter == $key) {
                $arrayclass = array('class' => 'btn btn-default btn-lg btn-primary');
            } else {
                $arrayclass = array('class' => 'btn btn-default btn-lg');
            }
            $buttons .= html_writer::link($url.'?filter=' . $key, $label . " (" . $nbcourses[$key] . ")", $arrayclass);
        }
        $buttons .= html_writer::end_tag('div');

        $title = html_writer::start_tag('h2', array('class' => ''));
        $title .= get_string('titlefollowedcourses', 'block_orange_course_dashboard');
        $title .= html_writer::end_tag('h2');

        return $title . $buttons . $moocslist;
    }
}
