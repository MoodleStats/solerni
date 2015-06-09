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
use local_orange_library\subscription_button\subscription_button_object;
use local_orange_library\extended_course\extended_course_object;
use local_orange_library\enrollment\enrollment_object;

require_once($CFG->dirroot . '/course/renderer.php');
require_once($CFG->dirroot . '/cohort/lib.php');
require_once($CFG->dirroot . '/theme/solerni/classes/catalogue.php');

class theme_solerni_core_course_renderer extends core_course_renderer
{
    protected function coursecat_coursebox(coursecat_helper $chelper, $course, $additionalclasses = '') {
        global $CFG;

        // Start code to display only allowed MOOC.
        global $DB, $USER;

        $badges = new badges_object();

        // By defaut the course is not displayed.
        $canview = false;
        // If user is loggedIn and has capability to create course then he can view all courses on the system.
        if (isloggedin()) {
            $usercontext = context_user::instance($USER->id);
            if (has_capability('moodle/course:create', $usercontext)) {
                $canview = true;
            }
        }

        if (!$canview) {
            // Self enrol enabled for this course.
            $selfenrolment = new enrollment_object();
            $enrolself = $selfenrolment->get_self_enrolment($course);
            if ($enrolself != null) {
                // If selfenrol and cohort associated, the must must be part of the cohort to see the course.
                $cohortid = (int)$enrolself->customint5;
                if ($cohortid == 0) {
                    $canview = true;
                } else {
                    $canview = cohort_is_member($cohortid, $USER->id);
                }
            } else {
                $canview = true;
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
            $classes = trim('coursebox '. $additionalclasses);
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
        $PAGE->requires->css('/local/orange_library/style.css');

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

        $params = array();
        $options = array();
        $options['summary'] = true;

        $chelper = new coursecat_helper();

        // Pagination.
        $perpage = $CFG->coursesperpage;
        $page = optional_param('pageid', 0, PARAM_INT);

        $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_COLLAPSED)->
                set_courses_display_options(array(
                        'recursive' => false,  // TODO, le recursif n'est pas traiter dans catalogue::get_courses
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
        global $CFG;
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
        $output .= "<input type='checkbox' id='statusall' name='statusid[]' class='solerni_checkboxall' value='0' $allchecked/>".$status[0];
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

        // Filter on thematic
        // TODO lecture des thématique
        $thematic = array (0 => get_string('filterthematicall', 'theme_solerni'));

        if ((count($filter->thematicsid) == 0) || (in_array(0, $filter->thematicsid))) {
            $allchecked = "checked";
        } else {
            $allchecked = '';
        }

        $output .= "<div class='filterthematic'>";
        $output .= "<h3 class='filter'>" . get_string('filterthematictitle', 'theme_solerni'). "</h3>";
        $output .= "<div class='filter'>";
        $output .= "<input type='checkbox' id='thematicall' name='thematicid[]' class='solerni_checkboxall' value='0' $allchecked/>".$thematic[0];
        $output .= "<ul class='filterthematic' id='ulthematicall'>";
        foreach ($thematic as $thematicid => $thematiclabel) {
            if ($thematicid != 0) {
                if (in_array($thematicid, $filter->thematicsid )) {
                    $checked = "checked";
                } else {
                    $checked = '';
                }
                $output .= "<li>";
                $output .= "<input type='checkbox' name='thematicid[]' class='solerni_checkbox' value='$thematicid' $checked />";
                $output .= $thematiclabel . "</li>";
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
        $output .= "<input type='checkbox' id='durationall' name='durationid[]' class='solerni_checkboxall' value='0' $allchecked/>".$duration[0];
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
        $output .= "<input type='checkbox' id='categoryall' name='categoryid[]' class='solerni_checkboxall' value='0' $allchecked/>" . get_string('filtercategoryall', 'theme_solerni');
        $output .= "<ul class='filtercategory' id='ulcategoryall'>";
        foreach ($categories as $catid => $category) {
            if ($catid != 0) {
                // Get customer information to make sure the category is associated to a customer
                if (in_array($catid, $filter->categoriesid)) {
                    $checked = "checked";
                } else {
                    $checked = '';
                }
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
}