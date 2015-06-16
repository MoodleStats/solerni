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
use theme_solerni\catalogue;

require_once($CFG->dirroot . '/course/renderer.php');
require_once($CFG->dirroot . '/cohort/lib.php');

class theme_solerni_core_course_renderer extends core_course_renderer {

    /**
	 * Returns HTML to print list of available courses for the frontpage
     *
     * This is an override for adding a custom heading on frontpage
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
        echo $this->solerni_frontpage_heading();

		return $this->coursecat_courses($chelper, $courses, $totalcount);
	}

    protected function coursecat_coursebox(coursecat_helper $chelper, $course, $additionalclasses = '') {
        global $CFG, $USER, $PAGE;
        $content = '';

        $utilities = new utilities_object();
        $additionalclasses = 'slrn-coursebox '. $additionalclasses;

        // End code to display only allowed MOOC.
        if ($utilities->can_user_view_course($course, $USER)) {
            $content = $this->render_solerni_mooc_component($chelper, $course, $additionalclasses);
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
        $PAGE->requires->css('/theme/solerni/style/catalogue.css');
        $PAGE->requires->css('/local/orange_library/style.css');

        $customer = catalogue::solerni_catalogue_get_customer_infos($coursecat->id);

        $content = '';
        if (isset($customer->id)) {
            $content .= "<div class='slrn-header__column'>";
            if ($customer->urlpicture != "") {
                $content .= "<div><img class='header-background-img' src='{$customer->urlpicture}'";
                $content .= " alt='{$customer->name}' /></div>";
            }
            if ($customer->urlimg != "") {
                $content .= "<div class='slrn-header__logo'><img class='header-logo-img' src='{$customer->urlimg}'  /></div>";
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
     * Returns HTML to print list of available courses for the catalog
     *
     * @return string
     */
    public function catalog_available_courses($filter) {
        global $CFG;
        require_once($CFG->libdir. '/coursecatlib.php');

        $params = array();
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

        $courses = catalogue::get_courses_catalogue($filter, $chelper->get_courses_display_options());
        $totalcount = catalogue::get_courses_catalogue_count($filter, $chelper->get_courses_display_options());

        if ($totalcount == 0) {
            $countstring = get_string('catalog0result', 'theme_solerni');
        } else if ($totalcount == 1) {
            $countstring = $totalcount . " " . get_string('catalog1result', 'theme_solerni');
        } else if ($totalcount > 1) {
            $countstring = $totalcount . " " . get_string('catalognresults', 'theme_solerni');
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

        $inputid = 'coursesearchbox';
        $inputsize = 30;

        $catalogurl = new moodle_url('/catalog/index.php');

        $output = html_writer::start_tag('form', array('id' => $formid, 'action' => $catalogurl, 'method' => 'post'));
        $output .= html_writer::start_tag('fieldset', array('class' => 'coursesearchbox invisiblefieldset'));

        // Filter on status.
        $status = array (0 => get_string('filterstatusall', 'theme_solerni'),
                         1 => get_string('filterstatusinprogress', 'theme_solerni'),
                         2 => get_string('filterstatuscomingsoon', 'theme_solerni'),
                         3 => get_string('filterstatuscomplete', 'theme_solerni'));

        if ((count($filter->statusid) == 0) || (in_array(0, $filter->statusid))) {
            $allchecked = "checked";
        } else {
            $allchecked = '';
        }

        $output .= "<div class='slrn-filter'>";

        $output .= "<div class='filterstatus'>";
        $output .= "<h3 class='filter'>" . get_string('filterstatustitle', 'theme_solerni') . "</h3>";
        $output .= "<div class='filter'>";
        $output .= "<input type='checkbox' id='statusall' name='statusid[]' class='solerni_checkboxall' ";
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
                $output .= "<input type='checkbox' name='statusid[]' class='solerni_checkbox' value='$statusid' $checked />";
                $output .= $statuslabel . "</li>";
            }
        }
        $output .= "</ul>";
        $output .= "</div>";
        $output .= "</div>";

        // Filter on thematic.
        $thematics = $DB->get_recordset('orange_thematics');
        $thematic = array (0 => get_string('filterthematicall', 'theme_solerni'));

        if ((count($filter->thematicsid) == 0) || (in_array(0, $filter->thematicsid))) {
            $allchecked = "checked";
        } else {
            $allchecked = '';
        }

        $output .= "<div class='filterthematic'>";
        $output .= "<h3 class='filter'>" . get_string('filterthematictitle', 'theme_solerni'). "</h3>";
        $output .= "<div class='filter'>";
        $output .= "<input type='checkbox' id='thematicall' name='thematicid[]' class='solerni_checkboxall'";
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
                $output .= "<input type='checkbox' name='thematicid[]' class='solerni_checkbox' value='$theme->id' $checked />";
                $output .= $theme->name . "</li>";
            }
        }
        $output .= "</ul>";
        $output .= "</div>";
        $output .= "</div>";

        // Filter on duration.
        $duration = array (0 => get_string('filterdurationall', 'theme_solerni'),
                           1 => get_string('filterdurationless4', 'theme_solerni'),
                           2 => get_string('filterdurationfrom4to6', 'theme_solerni'),
                           3 => get_string('filterdurationmore6', 'theme_solerni'));

        if ((count($filter->durationsid) == 0) || (in_array(0, $filter->durationsid))) {
            $allchecked = "checked";
        } else {
            $allchecked = '';
        }

        $output .= "<div class='filterduration'>";
        $output .= "<h3 class='filter'>" . get_string('filterdurationtitle', 'theme_solerni'). "</h3>";
        $output .= "<div class='filter'>";
        $output .= "<input type='checkbox' id='durationall' name='durationid[]' class='solerni_checkboxall' ";
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
                $output .= "<input type='checkbox' name='durationid[]' class='solerni_checkbox' value='$durationid' $checked />";
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
        $output .= "<h3 class='filter'>" . get_string('filtercategorytitle', 'theme_solerni'). "</h3>";
        $output .= "<div class='filter'>";
        $output .= "<input type='checkbox' id='categoryall' name='categoryid[]' class='solerni_checkboxall' ";
        $output .= "value='0' $allchecked/>" . get_string('filtercategoryall', 'theme_solerni');
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
                    $output .= "<input type='checkbox' name='categoryid[]' class='solerni_checkbox' value='$catid' $checked />";
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
     *  Render a Solerni Mooc (CourseBox) HTML Fragment
     *
     * @param $course
     *
     * @return (string)
     */
    function render_solerni_mooc_component($chelper, $course, $additionalclasses = '') {
            global $CFG;

            if (!$chelper) {
                $chelper = $this->solerni_create_mooc_helper();
            }
            $chelper = $this->solerni_create_mooc_helper();
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

            // Instanciate Solerni objects
            $badges = new badges_object();
            $catalogue = new catalogue();
            $image_utilities = new utilities_image();

            // Get customer info related to Moodle catagory.
            $customer = $catalogue->solerni_catalogue_get_customer_infos($course->category);
            // Get course informations.
            $courseinfos = $catalogue->solerni_catalogue_get_course_infos($course);

            $content = '';
            $classes = trim('coursebox '. $additionalclasses);
            $coursename = $chelper->get_course_formatted_name($course);

            if ($chelper->get_show_courses() >= self::COURSECAT_SHOW_COURSES_EXPANDED) {
                    $nametag = 'h3';
            } else {
                    $classes .= ' collapsed';
                    $nametag = 'div';
            }

            include( $CFG->partialsdir . '/mooc_component.php');
            /*

            // Coursebox.
            $content .= html_writer::start_tag('div', array(
                    'class' => $classes,
                    'data-courseid' => $course->id,
                    'data-type' => self::COURSECAT_TYPE_COURSE,
            ));

            $content .= html_writer::start_tag('div', array('class' => 'info'));
            $content .= html_writer::start_tag('div', array('class' => 'presentation__mooc__block presentation__mooc__pic'));
            if (isset($courseinfos->imgurl) && (is_object($courseinfos->imgurl))) {
                $content .= html_writer::empty_tag('img', array('src' => $courseinfos->imgurl,
                    'class' => 'presentation__mooc__block__image'));

                if (isset($customer->urlimg) && (is_object($customer->urlimg))) {
                    $categoryimagelink = html_writer::link(new moodle_url(
                        '/course/index.php',
                        array('categoryid' => $course->category)),
                        html_writer::empty_tag('img', array('src' => $customer->urlimg,
                            'class' => 'presentation__mooc__block__logo'))
                        );
                    $content .= $categoryimagelink;
                }
            }
            $content .= html_writer::end_tag('div');

            // Course name.
            $coursename = $chelper->get_course_formatted_name($course);
            if (isset($courseinfos)) {
                $content .= html_writer::tag($nametag, $coursename, array('class' => 'presentation__mooc__text__title'));
            } else {
                $coursenamelink = html_writer::link(new moodle_url('/course/view.php', array('id' => $course->id)),
                    $coursename, array('class' => $course->visible ? '' : 'dimmed'));
                $content .= html_writer::tag($nametag, $coursenamelink, array('class' => 'coursename'));
            }

            // Course image.
            if (isset($courseinfos)) {
                $categorynamelink = html_writer::link(new moodle_url(
                    '/course/index.php',
                    array('categoryid' => $course->category)),
                    $courseinfos->categoryname);
                $content .= html_writer::start_tag('span', array('class' => 'presentation__mooc__text__subtitle'));
                $content .= get_string('courseproposedby', 'theme_solerni') . " " . $categorynamelink;
                $content .= html_writer::end_tag('span');
            }

            // Course info.
            $content .= html_writer::start_tag('div', array('class' => 'presentation__mooc__text'));
            if (isset($courseinfos)) {

                // En savoir plus.
                $ensavoirpluslink = html_writer::link(new moodle_url(
                    '/course/view.php',
                    array('id' => $course->id)),
                    get_string('coursefindoutmore', 'theme_solerni'),
                    array('class' => 'subscription_btn btn-primary')
                    );

                // Display course summary.
                if ($course->has_summary()) {
                    $content .= html_writer::start_tag('div', array('class' => 'presentation__mooc__text__desc'));
                    $content .= $chelper->get_course_formatted_summary($course,
                        array('overflowdiv' => true, 'noclean' => true, 'para' => false));
                    $content .= $ensavoirpluslink;
                    $content .= html_writer::end_tag('div'); // Summary.
                } else {
                    $content .= html_writer::start_tag('div', array('class' => 'presentation__mooc__text__desc'));
                    $content .= $ensavoirpluslink;
                    $content .= html_writer::end_tag('div');
                }

                // Icons.
                $content .= html_writer::start_tag('div', array('class' => 'presentation__mooc__block presentation__mooc__meta'));

                // Dates.
                $content .= html_writer::start_tag('span', array('class' => 'presentation__mooc__meta__date'));
                $content .= html_writer::tag('p', get_string('coursestartdate', 'theme_solerni') . " " .
                        date("d.m.Y", $course->startdate));
                $content .= html_writer::tag('p', get_string('courseenddate', 'theme_solerni') . " " .
                        date("d.m.Y", $courseinfos->enddate));
                $content .= html_writer::end_tag('span');

                // Badges.
                $content .= html_writer::start_tag('span', array('class' => 'presentation__mooc__meta__badge'));

                if ($badges->count_badges($course->id)) {
                    $content .= html_writer::tag('p', get_string('coursebadge', 'theme_solerni'));
                } else {
                    $content .= html_writer::tag('p', get_string('coursenobadge', 'theme_solerni'));
                }
                $content .= html_writer::end_tag('span'); // Badges.

                // Price.
                $content .= html_writer::start_tag('span', array('class' => 'presentation__mooc__meta__price'));
                $content .= html_writer::tag('p', $courseinfos->price);
                $content .= html_writer::end_tag('span'); // Price.

                $content .= html_writer::end_tag('div'); // Icons.
            }
            $content .= html_writer::end_tag('div'); // Presentation__mooc__text.

            $content .= html_writer::end_tag('div'); // Info.

            $content .= html_writer::end_tag('div'); // Coursebox.
            */
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
		$content .= $this->render_solerni_mooc_component($course);
		$content .= $this->output->box_end();
		return $content;
	}

    /*
     * Create chelper object in case we don't have one
     *
     * no @param
     * return chelper object
     */
    public function solerni_create_mooc_helper() {
        global $CFG;

        require_once($CFG->libdir. '/coursecatlib.php');
        $chelper = new coursecat_helper();
		$chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_EXPANDED);

        return $chelper;
    }

    /*
     * Print the Solerni frontpage heading
     * Jus before the courses list
     *
     * @return string
     */
     public function solerni_frontpage_heading() {

         global $PAGE;
         $heading =    ($PAGE->theme->settings->catalogtitle ) ?
                        $PAGE->theme->settings->catalogtitle :
                        get_string('catalogtitledefault', 'theme_solerni');

         $cataloglink = $PAGE->theme->settings->catalogue;

         ?>
        <div class="frontpage_heading">
            <?php if ($cataloglink) : ?>
                <a href="<?php echo $cataloglink; ?>" class="link-top-right">
                     <?php echo get_string('seecatalog', 'theme_solerni'); ?>
                </a>
            <?php endif;?>
            <h2>
                <?php echo $heading; ?>
            </h2>
        </div>
        <?php }
}
