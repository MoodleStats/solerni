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

require_once($CFG->dirroot . '/course/renderer.php');
require_once($CFG->dirroot . '/cohort/lib.php');
require_once($CFG->dirroot . '/theme/solerni/renderers/catalogue.php');
require_once($CFG->dirroot . '/blocks/course_extended/locallib.php');

class theme_solerni_core_course_renderer extends core_course_renderer
{
    protected function coursecat_coursebox(coursecat_helper $chelper, $course, $additionalclasses = '') {
        global $CFG;

        // Start code to display only allowed MOOC.
        global $DB, $USER;

        // By defaut the course is not display.
        $canview = false;
        // If user is loggedIn and has capability to create course then he can view all courses on the system.
        if (isloggedin()) {
            $usercontext = context_user::instance($USER->id);
            if (has_capability('moodle/course:create', $usercontext)) {
                $canview = true;
            }
        }

        if (!$canview) {
            // Read enrolment method which are active.
            $enrols = $DB->get_records('enrol', array('courseid' => $course->id, 'status' => 0));
            foreach ($enrols as $enrol) {
                // Is self and user in the cohort => display the course, or no cohort set => display the course also.
                if ($enrol->enrol == 'self') {
                    // If a cohort is affected to the course, it is store in parameter customint5.
                    $cohortid = (int)$enrol->customint5;
                    if ($cohortid == 0) {
                        $canview = true;
                    } else {
                        $canview = cohort_is_member($cohortid, $USER->id);
                    }
                }
            }
        }

        // End code to display only allowed MOOC.
        if ($canview) {
            // Get customer info related to Moodle catagory.
            $customer = catalogue::solerni_catalogue_get_customer_infos($course->category);

            // Get course informations.
            $courseinfos = catalogue::solerni_catalogue_get_course_infos($course);

            if (!isset($this->strings->summary)) {
                $this->strings->summary = get_string('summary');
            }
            if ($chelper->get_show_courses() <= self::COURSECAT_SHOW_COURSES_COUNT) {
                return '';
            }
            if ($course instanceof stdClass) {
                require_once($CFG->libdir. '/coursecatlib.php');
                $course = new course_in_list($course);
            }
            $content = '';
            $classes = trim('coursebox clearfix '. $additionalclasses);
            if ($chelper->get_show_courses() >= self::COURSECAT_SHOW_COURSES_EXPANDED) {
                    $nametag = 'h3';
            } else {
                    $classes .= ' collapsed';
                    $nametag = 'div';
            }

            // Coursebox.
            $content .= html_writer::start_tag('div', array(
                    'class' => $classes,
                    'data-courseid' => $course->id,
                    'data-type' => self::COURSECAT_TYPE_COURSE,
            ));

            $content .= html_writer::start_tag('div', array('class' => 'info'));
            $content .= html_writer::start_tag('div', array('class' => 'presentation__mooc__block presentation__mooc__pic'));
            if (isset($courseinfos->imgurl) && (is_object($courseinfos->imgurl))) {
                $content .= html_writer::empty_tag('img', array('src' => $courseinfos->imgurl, 'class' => 'presentation__mooc__block__image'));
            }

            if (isset($customer->urlimg) && (is_object($customer->urlimg))) {
                $categoryimagelink = html_writer::link(new moodle_url(
                    '/course/index.php',
                    array('categoryid' => $course->category)),
                    html_writer::empty_tag('img', array('src' => $customer->urlimg, 'class' => 'presentation__mooc__block__logo'))
                    );
                $content .= $categoryimagelink;
            }
            $content .= html_writer::end_tag('div');

            // Course name.
            $coursename = $chelper->get_course_formatted_name($course);

            // Course image.
            $coursenamelink = html_writer::link(new moodle_url('/course/view.php', array('id' => $course->id)),
                $coursename, array('class' => $course->visible ? '' : 'dimmed'));
            $content .= html_writer::tag($nametag, $coursenamelink, array('class' => 'coursename'));
            // If we display course in collapsed form but the course has summary or course contacts,
            // display the link to the info page.
            $content .= html_writer::start_tag('div', array('class' => 'moreinfo'));
            if ($chelper->get_show_courses() < self::COURSECAT_SHOW_COURSES_EXPANDED) {
                if ($course->has_summary() || $course->has_course_contacts() || $course->has_course_overviewfiles()) {
                    $url = new moodle_url('/course/info.php', array('id' => $course->id));
                    $image = html_writer::empty_tag('img', array('src' => $this->output->pix_url('i/info'),
                            'alt' => $this->strings->summary));
                    $content .= html_writer::link($url, $image, array('title' => $this->strings->summary));
                    // Make sure JS file to expand course content is included.
                    $this->coursecat_include_js();
                }
            }
            $content .= html_writer::end_tag('div'); // Moreinfo.
            if (isset($courseinfos)) {
                $categorynamelink = html_writer::link(new moodle_url(
                    '/course/index.php',
                    array('categoryid' => $course->category)),
                    $courseinfos->categoryname);
                $content .= html_writer::start_tag('span', array('class' => 'presentation__mooc__text__subtitle'));
                // TODO à traduire.
                $content .= "proposé par " . $categorynamelink;
                $content .= html_writer::end_tag('span');
            }

            // Course info.
            $content .= html_writer::start_tag('div', array('class' => 'presentation__mooc__text'));
            if (isset($courseinfos)) {

                // Display course summary.
                if ($course->has_summary()) {
                    $content .= html_writer::start_tag('div', array('class' => 'presentation__mooc__text__desc'));
                    $content .= $chelper->get_course_formatted_summary($course,
                                    array('overflowdiv' => true, 'noclean' => true, 'para' => false));
                    $content .= html_writer::end_tag('div'); // Summary.
                }

                // En savoir plus.
                // TODO à traduire.
                $ensavoirpluslink = html_writer::link(new moodle_url(
                    '/course/view.php',
                    array('id' => $course->id)),
                    "En savoir plus",
                    array('class' => 'button_link presentation__mooc__text_link')
                    );

                $content .= $ensavoirpluslink;

                // Icons.
                $content .= html_writer::start_tag('div', array('class' => 'presentation__mooc__block presentation__mooc__meta'));

                // Dates.
                $content .= html_writer::start_tag('span', array('class' => 'presentation__mooc__meta__date'));
                $content .= html_writer::tag('p', get_string('startdate', 'format_flexpage') . date("d.m.Y", $course->startdate));
                $content .= html_writer::tag('p', get_string('enddate', 'format_flexpage') . date("d.m.Y", $courseinfos->enddate));
                $content .= html_writer::end_tag('span');

                // Badges.
                $content .= html_writer::start_tag('span', array('class' => 'presentation__mooc__meta__badge'));
                if (count_badges() != 0) {
                    $content .= html_writer::tag('p', "No Badge");
                } else {
                    $content .= html_writer::tag('p', get_string('certification_default', 'block_course_extended'));
                }
                $content .= html_writer::end_tag('span'); // Badges.

                // Price.
                $content .= html_writer::start_tag('span', array('class' => 'presentation__mooc__meta__price'));
                if ($courseinfos->price == 0) {
                    $content .= html_writer::tag('p', get_string('price_default', 'format_flexpage'));
                } else {
                    $content .= html_writer::tag('p', get_string('price', 'format_flexpage'). $courseinfos->price . "&euro;");
                }
                $content .= html_writer::end_tag('span'); // Price.

                $content .= html_writer::end_tag('div'); // Icons.
            }
            $content .= html_writer::end_tag('div'); // Presentation__mooc__text.

            $content .= html_writer::end_tag('div'); // Info.

            $content .= html_writer::end_tag('div'); // Coursebox.
        } else {
            $content = '';
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

        Global $CFG, $PAGE;

        // Category header for customer info and logo.
        $PAGE->requires->css('/theme/solerni/style/catalogue.css');
        $customer = catalogue::solerni_catalogue_get_customer_infos($coursecat->id);

        $content = '';
        if (isset($customer->id)) {
            $content .= "<div class='slrn-header__column'>";
            if ($customer->urlpicture != "") {
                $content .= "<div><img class='header-background-img' src='{$customer->urlpicture}' alt='{$customer->name}' /></div>";
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

            //$thematicid = NULL, $statusid = NULL, $durationid = NULL, $categoriesid = NULL
        
            $params = array();
            $options = array();
            $options['summary'] = true;
            //echo "<PRE>";
            // TODO : checkvisibility en fonction du profil du user.
            //print_r(catalogue::get_course_records('c.id != 0',$params, $options, true));
            //print_r(catalogue::get_courses($options));
            //echo "</PRE>";
            $chelper = new coursecat_helper();
//COURSECAT_SHOW_COURSES_EXPANDED
            $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_COLLAPSED)->
            set_courses_display_options(array(
                            'recursive' => FALSE,  // TODO, le recursif n'est pas traiter dans catalogue::get_courses
                            'limit' => $CFG->frontpagecourselimit,
                            'viewmoreurl' => new moodle_url('/course/index.php'),
                            'viewmoretext' => new lang_string('fulllistofcourses')));
            $chelper->set_attributes(array('class' => 'frontpage-course-list-all'));

            $courses = catalogue::get_courses($filter, $chelper->get_courses_display_options());
            $totalcount = count($courses);
            //catalogue::get_courses_count($chelper->get_courses_display_options());

            return $this->coursecat_courses($chelper, $courses, $totalcount);
    }

    /**
     * Renders html to display a course search form
     *
     * @param string $value default value to populate the search field
     * @param string $format display format - 'plain' (default), 'short' or 'navbar'
     * @return string
     */
    function course_catalog_filter_form($filter) {
            global $CFG;
            require_once($CFG->libdir. '/coursecatlib.php');
            require_once($CFG->dirroot . '/local/orange_customers/lib.php');
// $thematicid = NULL, $statusid = NULL, $durationid = NULL, $categoriesid = NULL
            static $count = 0;
            $formid = 'coursecatalog';
            if ((++$count) > 1) {
                    $formid .= $count;
            }

            $inputid = 'coursesearchbox';
            $inputsize = 30;

            // Fiels labels
            $strsearchcourses= get_string("searchcourses");
            $catalogurl = new moodle_url('/catalog/index.php');

            $categories = coursecat::make_categories_list();
            
            $output = html_writer::start_tag('form', array('id' => $formid, 'action' => $catalogurl, 'method' => 'get'));
            $output .= html_writer::start_tag('fieldset', array('class' => 'coursesearchbox invisiblefieldset'));
            //$output .= html_writer::tag('label', $strsearchcourses.': ', array('for' => $inputid));
            //$output .= html_writer::empty_tag('input', array('type' => 'text', 'id' => $inputid,
            //                'size' => $inputsize, 'name' => 'search', 'value' => s($value)));

            if (count($filter->categoriesid)==0) { 
                $allchecked = "checked";
            } else {
                $allchecked = '';                
            }
            $output .= "<br /><input type='checkbox' id='categoryall' name='categoryid[]' class='solerni_checkboxall' value='0' $allchecked/>Toutes les entreprises";
            $output .= "<ul id='ulcategoryall'>";
            foreach ($categories as $catid => $category ) {
                // Get customer information to make sure the category is associated to a customer
                //echo "CATID:$catid";
                $customer = customer_get_customerbycategoryid ($catid);
                if (isset($customer->id)) {
                    //print_r($customer);
                    $output .= "<br /><input type='checkbox' name='categoryid[]' class='solerni_checkbox' value='$catid' />$customer->name";
                }
            }
            $output .= "</ul>";
            
            $output .= "<br />";
            $output .= html_writer::empty_tag('input', array('type' => 'submit',
                            'value' => get_string('go')));
            $output .= html_writer::end_tag('fieldset');
            $output .= html_writer::end_tag('form');

            return $output;
    }
    
}