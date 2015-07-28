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

use local_orange_library\badges\badges_object;
use local_orange_library\utilities\utilities_object;
use local_orange_library\utilities\utilities_image;
use local_orange_library\utilities\utilities_course;
use local_orange_library\subscription_button\subscription_button_object;

// Required to extend core_course_renderer that does not have a namespace.
require_once($CFG->dirroot . '/course/renderer.php');
//require_once($CFG->dirroot . '/cohort/lib.php');

class theme_cerulean_core_course_renderer extends core_course_renderer {

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
		$chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_EXPANDED)->
		set_courses_display_options(array(
				'recursive' => true,
				'limit' => $CFG->frontpagecourselimit,
				'viewmoreurl' => new moodle_url('/course/index.php'),
				'viewmoretext' => new lang_string('fulllistofcourses')));

		$chelper->set_attributes(array('class' => 'frontpage-course-list-all'));
		$courses = coursecat::get(0)->get_courses($chelper->get_courses_display_options());
		$totalcount = coursecat::get(0)->get_courses_count($chelper->get_courses_display_options());
		if (!$totalcount && !$this->page->user_is_editing() && has_capability('moodle/course:create', context_system::instance())) {
			// Print link to create a new course, for the 1st available category.
			return $this->add_new_course_button();
		}

        // Add heading before frontpage mooc list.
        echo $this->cerulean_frontpage_heading();

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
        $additionalclasses = 'slrn-coursebox '. $additionalclasses;

        // End code to display only allowed MOOC.
        if ($utilitiescourse->can_user_view_course($course, $USER)) {
            $content = $this->render_cerulean_mooc_component($chelper, $course, $additionalclasses);
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
        $PAGE->requires->css('/theme/cerulean/style/catalogue.css');
        $PAGE->requires->css('/local/orange_library/style.css');

        $utilitiescourse = new utilities_course();
        $customer = $utilitiescourse->cerulean_course_get_customer_infos($coursecat->id);

        $content = '';
        if (isset($customer->id)) {
            $content .= "<div class='slrn-header__column'>";
            if ($customer->urlpicture != "") {
                $content .= "<div><img class='header-background-img' src='";
                $content .= utilities_image::get_resized_url($customer->urlpicture, array ('scale' => 'true', 'h' => 216, 'w' => 966));
                $content .= "' alt='{$customer->name}' /></div>";
            }
            if ($customer->urlimg != "") {
                $content .= "<div class='slrn-header__logo'><img class='header-logo-img' src='";
                $content .= utilities_image::get_resized_url($customer->urlimg, array ('scale' => 'true', 'h' => 100));
                $content .= "' /></div>";
            }
            $content .= "<div class='slrn-header__description'><h1>{$customer->name}</h1><div>{$customer->summary}</div></div>";
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
        $perpage = $CFG->coursesperpage;
        $page = optional_param('pageid', 0, PARAM_INT);

        $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_COLLAPSED)->set_courses_display_options(array(
                        'recursive' => false,  // TODO, le recursif n'est pas traiter dans catalogue::get_courses.
                        'limit' => $perpage,
                        'offset' => $page * $perpage,
                        'paginationallowall' => false,
                        'paginationurl' => new moodle_url('/catalog/index.php'),
                        'viewmoreurl' => new moodle_url('/catalog/index.php'),
                        'viewmoretext' => new lang_string('fulllistofcourses')));
        $chelper->set_attributes(array('class' => 'frontpage-course-list-all'));

        /* @todo
         * Refacto : init utilities in construct.
         */
        $utilitiescourse = new utilities_course();
        $courses = $utilitiescourse->get_courses_catalogue($filter, $chelper->get_courses_display_options());
        $totalcount = $utilitiescourse->get_courses_catalogue_count($filter, $chelper->get_courses_display_options());

        if ($totalcount == 0) {
            $countstring = get_string('catalog0result', 'theme_cerulean');
        } else if ($totalcount == 1) {
            $countstring = $totalcount . " " . get_string('catalog1result', 'theme_cerulean');
        } else if ($totalcount > 1) {
            $countstring = $totalcount . " " . get_string('catalognresults', 'theme_cerulean');
        }

        return "<p>" . $countstring . "</p>" . $this->coursecat_courses($chelper, $courses, $totalcount);
    }

    /**
     * Renders html to display the catalog filters
     *
     * @param string $filter : current filter
     * @return string
     */
    public function course_catalog_filter_form($filter) {
        global $CFG, $DB;
        require_once($CFG->libdir. '/coursecatlib.php');
        require_once($CFG->dirroot . '/local/orange_customers/lib.php');

        $formid = 'coursecatalog';
        $catalogurl = new moodle_url('/catalog/index.php');

        $output = html_writer::start_tag('form', array('id' => $formid, 'action' => $catalogurl, 'method' => 'post'));
        $output .= html_writer::start_tag('fieldset', array('class' => 'coursesearchbox invisiblefieldset'));

        // Filter on status.
        $status = array (0 => get_string('filterstatusall', 'theme_cerulean'),
                         1 => get_string('filterstatusinprogress', 'theme_cerulean'),
                         2 => get_string('filterstatuscomingsoon', 'theme_cerulean'),
                         3 => get_string('filterstatuscomplete', 'theme_cerulean'));

        if ((count($filter->statusid) == 0) || (in_array(0, $filter->statusid))) {
            $allchecked = "checked";
        } else {
            $allchecked = '';
        }

        $output .= "<div class='slrn-filter'>";

        $output .= "<div class='filterstatus'>";
        $output .= "<h3 class='filter'>" . get_string('filterstatustitle', 'theme_cerulean') . "</h3>";
        $output .= "<div class='filter'>";
        $output .= "<input type='checkbox' id='statusall' name='statusid[]' class='cerulean_checkboxall' ";
        $output .= "value='0' $allchecked/>".$status[0];
        $output .= "<ul class='filterstatus' id='ulstatusall'>";
        foreach ($status as $statusid => $statuslabel) {
            if ($statusid != 0) {
                if (in_array($statusid, $filter->statusid )) {
                    $checked = "checked";
                } else {
                    $checked = '';
                }
                $output .= "<li>";
                $output .= "<input type='checkbox' name='statusid[]' class='cerulean_checkbox' value='$statusid' $checked />";
                $output .= $statuslabel . "</li>";
            }
        }
        $output .= "</ul>";
        $output .= "</div>";
        $output .= "</div>";

        // Filter on thematic.
        $thematics = $DB->get_recordset('orange_thematics');
        $thematic = array (0 => get_string('filterthematicall', 'theme_cerulean'));

        if ((count($filter->thematicsid) == 0) || (in_array(0, $filter->thematicsid))) {
            $allchecked = "checked";
        } else {
            $allchecked = '';
        }

        $output .= "<div class='filterthematic'>";
        $output .= "<h3 class='filter'>" . get_string('filterthematictitle', 'theme_cerulean'). "</h3>";
        $output .= "<div class='filter'>";
        $output .= "<input type='checkbox' id='thematicall' name='thematicid[]' class='cerulean_checkboxall'";
        $output .= " value='0' $allchecked/>".$thematic[0];
        $output .= "<ul class='filterthematic' id='ulthematicall'>";
        foreach ($thematics as $theme) {
            if ($theme->id != 0) {
                if (in_array($theme->id, $filter->thematicsid )) {
                    $checked = "checked";
                } else {
                    $checked = '';
                }
                $output .= "<li>";
                $output .= "<input type='checkbox' name='thematicid[]' class='cerulean_checkbox' value='$theme->id' $checked />";
                $output .= $theme->name . "</li>";
            }
        }
        $output .= "</ul>";
        $output .= "</div>";
        $output .= "</div>";

        // Filter on duration.
        $duration = array (0 => get_string('filterdurationall', 'theme_cerulean'),
                           1 => get_string('filterdurationless4', 'theme_cerulean'),
                           2 => get_string('filterdurationfrom4to6', 'theme_cerulean'),
                           3 => get_string('filterdurationmore6', 'theme_cerulean'));

        if ((count($filter->durationsid) == 0) || (in_array(0, $filter->durationsid))) {
            $allchecked = "checked";
        } else {
            $allchecked = '';
        }

        $output .= "<div class='filterduration'>";
        $output .= "<h3 class='filter'>" . get_string('filterdurationtitle', 'theme_cerulean'). "</h3>";
        $output .= "<div class='filter'>";
        $output .= "<input type='checkbox' id='durationall' name='durationid[]' class='cerulean_checkboxall' ";
        $output .= "value='0' $allchecked/>".$duration[0];
        $output .= "<ul class='filterduration' id='uldurationall'>";
        foreach ($duration as $durationid => $durationlabel) {
            if ($durationid != 0) {
                if (in_array($durationid, $filter->durationsid )) {
                    $checked = "checked";
                } else {
                    $checked = '';
                }
                $output .= "<li>";
                $output .= "<input type='checkbox' name='durationid[]' class='cerulean_checkbox' value='$durationid' $checked />";
                $output .= $durationlabel. "</li>";
            }
        }
        $output .= "</ul>";
        $output .= "</div>";
        $output .= "</div>";

        // Filter on companies = moodle categories.
        $categories = coursecat::make_categories_list();

        if ((count($filter->categoriesid) == 0) || (in_array(0, $filter->categoriesid))) {
            $allchecked = "checked";
        } else {
            $allchecked = '';
        }
        $output .= "<div class='filtercategory'>";
        $output .= "<h3 class='filter'>" . get_string('filtercategorytitle', 'theme_cerulean'). "</h3>";
        $output .= "<div class='filter'>";
        $output .= "<input type='checkbox' id='categoryall' name='categoryid[]' class='cerulean_checkboxall' ";
        $output .= "value='0' $allchecked/>" . get_string('filtercategoryall', 'theme_cerulean');
        $output .= "<ul class='filtercategory' id='ulcategoryall'>";
        foreach ($categories as $catid => $category) {
            if ($catid != 0) {
                if (in_array($catid, $filter->categoriesid)) {
                    $checked = "checked";
                } else {
                    $checked = '';
                }
                // Get customer information to make sure the category is associated to a customer.
                $customer = customer_get_customerbycategoryid ($catid);
                if (isset($customer->id)) {
                    $output .= "<li>";
                    $output .= "<input type='checkbox' name='categoryid[]' class='cerulean_checkbox' value='$catid' $checked />";
                    $output .= $customer->name ."</li>";
                }
            }
        }
        $output .= "</ul>";
        $output .= "</div>";
        $output .= "</div>";

        $output .= "</div>";    // End .slrn-filter.

        $output .= html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'pageid', 'id' => 'pageid', 'value' => 0));
        $output .= html_writer::end_tag('fieldset');
        $output .= html_writer::end_tag('form');

        return $output;
    }

    /**
     * Render a cerulean Mooc (CourseBox) HTML Fragment from partials/course_component template
     *
     *
     * @global type $CFG
     * @param type $chelper
     * @param type $course
     * @param type $additionalclasses
     * @return string
     */
    function render_cerulean_mooc_component($chelper, $course, $additionalclasses = '') {
            global $CFG;

            if (!$chelper) {
                $chelper = $this->cerulean_create_mooc_helper();
            }
            $chelper = $this->cerulean_create_mooc_helper();
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

            // Instanciate cerulean objects
            $badges                 = new badges_object();
            $utilitiescourse        = new utilities_course();
            $imageutilities         = new utilities_image();
            $subscriptionbutton     = new subscription_button_object();
            $utilities              = new utilities_object();

            // Get customer info related to Moodle catagory.
            $customer = $utilitiescourse->solerni_course_get_customer_infos($course->category);
            // Get course informations.
            $courseinfos = $utilitiescourse->solerni_get_course_infos($course);

            $classes = trim('coursebox '. $additionalclasses);
            $coursename = $chelper->get_course_formatted_name($course);

            if ($chelper->get_show_courses() >= self::COURSECAT_SHOW_COURSES_EXPANDED) {
                    $nametag = 'h3';
            } else {
                    $classes .= ' collapsed';
                    $nametag = 'div';
            }

            // Generate code with buffering to include partial
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
		$content .= $this->render_cerulean_mooc_component(null,$course,null);
		$content .= $this->output->box_end();
		return $content;
	}

    /*
     * Create chelper object in case we don't have one
     *
     * no @param
     * return chelper object
     */
    public function cerulean_create_mooc_helper() {
        global $CFG;

        require_once($CFG->libdir. '/coursecatlib.php');
        $chelper = new coursecat_helper();
		$chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_EXPANDED);

        return $chelper;
    }

    /*
     * Print the cerulean frontpage heading
     * Just before the courses list
     *
     * @return string
     */
     public function cerulean_frontpage_heading() {

         global $PAGE;
         $heading =    ($PAGE->theme->settings->catalogtitle ) ?
                        $PAGE->theme->settings->catalogtitle :
                        get_string('catalogtitledefault', 'theme_cerulean');

         $cataloglink = $PAGE->theme->settings->catalogue;

         ?>
        <div class="frontpage_heading">
            <?php if ($cataloglink) : ?>
                <a href="<?php echo $cataloglink; ?>" class="link-top-right">
                     <?php echo get_string('seecatalog', 'theme_cerulean'); ?>
                </a>
            <?php endif;?>
            <h2>
                <?php echo $heading; ?>
            </h2>
        </div>
        <?php }
}
