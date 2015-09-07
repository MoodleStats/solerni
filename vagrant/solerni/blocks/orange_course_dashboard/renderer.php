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
 * orange_course_dashboard block renderer
 *
 * @package    block_orange_course_dashboard
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

use local_orange_library\badges\badges_object;
use local_orange_library\utilities\utilities_image;
use local_orange_library\utilities\utilities_object;
use local_orange_library\utilities\utilities_course;
use local_orange_library\subscription_button\subscription_button_object;

class block_orange_course_dashboard_renderer extends plugin_renderer_base {

    /**
     * Construct contents of orange_course_dashboard block
     *
     * @return string html to be displayed in orange_course_dashboard block
     */
    public function course_recommendation($courses, $coursesdetails) {
        global $CFG;

        $html = '';
        $config = get_config('block_orange_course_dashboard');

        $html .= html_writer::start_tag('h2', array('class' => ''));
        $html .= get_string('titlerecommendations', 'block_orange_course_dashboard');
        $html .= html_writer::end_tag('h2');
        if (!empty($config->catalogurl)) {
            $html .= html_writer::start_tag('div', array('class' => 'block_orange_course_dashboard test'));
            $catalogurl = new moodle_url($config->catalogurl);
            $html .= html_writer::link($catalogurl, get_string('displaycatalog', 'block_orange_course_dashboard'));
            $html .= html_writer::end_tag('div');
        }
        $html .= html_writer::start_tag('p', array('class' => ''));
        $html .= get_string('nomoocfollow', 'block_orange_course_dashboard');
        $html .= html_writer::end_tag('p');

        // Display each recommended course.
        foreach ($courses as $key => $course) {
            $html .= $this->output->box_start('coursebox', "course-{$course->id}");
            $html .= html_writer::start_tag('div', array('class' => 'course_title'));

            $coursename = format_string(get_course_display_name_for_list($course), true, $course->id);

            $html .= $this->output->box('', 'flush');
            $html .= html_writer::end_tag('div');

            // BEGIN TODO : To be changed when will have the design of this block.
            // Get course info to display individual course block.
            $courseinfos = $coursesdetails[$course->id];
            $imageutilities         = new utilities_image();
            $utilitiescourse        = new utilities_course();
            $subscriptionbutton     = new subscription_button_object($course);
            $badges                 = new badges_object();
            $customer = $utilitiescourse->solerni_course_get_customer_infos($course->category);
            $customerurl = new moodle_url('/course/index.php', array('categoryid' => $course->category ));
            $classes = "";

            ob_start();

            if ( $courseinfos ) :
                    ?>
                <div class="<?php echo $classes; ?>"
                     data-course-id="<?php echo $course->id; ?>" >
                    <div class="slrn-coursebox__column slrn-coursebox__column--image">
                        <?php if (isset($courseinfos->imgurl)) : ?>
                            <img class="slrn-coursebox__course-image"
                                 src="<?php echo $imageutilities->get_resized_url($courseinfos->imgurl,
                                         array('w' => 500, 'h' => 357, 'scale' => false), $courseinfos->file); ?>">
                        <?php endif; ?>
                        <?php if (isset($customer->urlimg)) : ?>
                            <a class="slrn-coursebox__course-image-customer" href="<?php echo $customerurl; ?>">
                                <img src="<?php echo $imageutilities->get_resized_url($customer->urlimg,
                                             array('w' => 35, 'h' => 35, 'scale' => true), $customer->fileimg); ?>">
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="slrn-coursebox__column slrn-coursebox__column--description">
                        <h3 class="slrn-coursebox__coursename"><?php echo $coursename; ?></h3>
                        <span class="slrn-coursebox__courseby font-variant--type1">
                            <?php echo get_string('courseproposedby', 'theme_cerulean'); ?>
                            <?php if ($customerurl) : ?>
                                <a class="link-primary" href="<?php echo $customerurl; ?>" class="slrn-coursebox__course-customer">
                                    <?php if (isset($customer->name)) {
                                        echo $customer->name;
                                    }?>
                                </a>
                            <?php endif; ?>
                        </span>
                        <div class="slrn-coursebox__summary">
                            <?php // @todo adapt length depending on viewport width ?
                            //echo $utilities->trim_text( $chelper->get_course_formatted_summary($course,
                              //          array('overflowdiv' => false, 'noclean' => true, 'para' => false)), 155); ?>
                            <a class="link-secondary" href="<?php echo $utilitiescourse->get_description_page_url($course); ?>">
                                <?php echo get_string('coursefindoutmore', 'theme_cerulean'); ?>
                            </a>
                        </div>
                        <div class="slrn-coursebox__column--subscription_button">
                            <?php echo $subscriptionbutton->set_button($course); ?>
                        </div>
                    </div>
                    <div class="slrn-coursebox__column slrn-coursebox__column--metadata font-variant--type1">
                        <div class="slrn-coursebox__metadata slrn-coursebox__metadata--dates">
                            <div class="slrn-coursebox__metadata__icone -sprite-cerulean"></div>
                            <?php if ($course->startdate || $course->startdate ) : ?>
                                <span class="slrn-coursebox__metadata__item">
                                    <?php if ( $course->startdate) : ?>
                                        <div class="">
                                            <?php echo get_string('coursestartdate', 'theme_cerulean') .
                                                    " " . date("d.m.Y", $course->startdate); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ( $courseinfos->enddate) : ?>
                                        <div class="">
                                            <?php echo get_string('courseenddate', 'theme_cerulean') .
                                                " " . date("d.m.Y", $courseinfos->enddate); ?>
                                        </div>
                                    <?php endif; ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="slrn-coursebox__metadata slrn-coursebox__metadata--badges">
                            <div class="slrn-coursebox__metadata__icone -sprite-cerulean"></div>
                            <?php if ( $badges->count_badges($course->id)) : ?>
                                <span class="slrn-coursebox__metadata__item">
                                    <?php echo get_string('coursebadge', 'theme_cerulean'); ?>
                                </span>
                            <?php else : ?>
                                <span class="slrn-coursebox__metadata__item">
                                    <?php echo get_string('coursenobadge', 'theme_cerulean'); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="slrn-coursebox__metadata slrn-coursebox__metadata--price">
                            <div class="slrn-coursebox__metadata__icone -sprite-cerulean"></div>
                            <span class="slrn-coursebox__metadata__item">
                                <?php echo $courseinfos->price; ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <div class="coursebox slrn-coursebox slrn-coursebox--invalid"
                     data-course-id="<?php echo $course->id; ?>" data-type="<?php echo self::COURSECAT_TYPE_COURSE; ?>">
                    <h3 class="slrn-coursebox__coursename">
                        <a href="<?php echo new moodle_url('/course/view.php', array('id' => $course->id)); ?>">
                            <?php echo $coursename; ?>
                        </a>
                    </h3>
                    <p>(Ce cours n'est pas au format flexpage)</p>
                </div>
            <?php endif;

            $html .= ob_get_contents();
            ob_end_clean();
            // END TODO : To be changed when will have the design of this block.

            $html .= $this->output->box('', 'flush');
            $html .= $this->output->box_end();
        }
        return $html;
    }

    /**
     * Construct contents of orange_course_dashboard block
     *
     * @return string html to be displayed in orange_course_dashboard block
     */
    public function course_norecommendation() {
        $html = '';
        $config = get_config('block_orange_course_dashboard');

        $html .= html_writer::start_tag('h2', array('class' => ''));
        $html .= get_string('titlerecommendations', 'block_orange_course_dashboard');
        $html .= html_writer::end_tag('h2');
        if (!empty($config->catalogurl)) {
            $html .= html_writer::start_tag('div', array('class' => 'block_orange_course_dashboard test'));
            $catalogurl = new moodle_url($config->catalogurl);
            $html .= html_writer::link($catalogurl, get_string('displaycatalog', 'block_orange_course_dashboard'));
            $html .= html_writer::end_tag('div');
        }
        $html .= html_writer::start_tag('p', array('class' => ''));
        $html .= get_string('nomooctodisplay', 'block_orange_course_dashboard');
        $html .= html_writer::end_tag('p');
        $html .= html_writer::empty_tag('img',
                    array('src' => '/blocks/orange_course_dashboard/pix/ban_catalog.png',
                    'alt' => get_string('displaycatalog', 'block_orange_course_dashboard'),
                    'title' => get_string('displaycatalog', 'block_orange_course_dashboard')));

        return $html;
    }

    /**
     * Construct contents of orange_course_dashboard block
     *
     * @param array $courses list of courses in sorted order
     * @param array $overviews list of course overviews
     * @return string html to be displayed in orange_course_dashboard block
     */
    public function course_overview($courses, $overviews) {
        $html = '';
        $config = get_config('block_orange_course_dashboard');
        $courseordernumber = 0;
        $maxcourses = count($courses);
        $userediting = false;
        // Intialise string/icon etc if user is editing and courses > 1.
        if ($this->page->user_is_editing() && (count($courses) > 1)) {
                $userediting = true;
        }
        $html .= html_writer::start_tag('h2', array('class' => ''));
        $html .= get_string('titlefollowedcourses', 'block_orange_course_dashboard');
        $html .= html_writer::end_tag('h2');
            $html .= html_writer::start_tag('div', array('class' => 'block_orange_course_dashboard test'));
        if (!empty($config->mymoocurl)) {
            $mymoocsurl = new moodle_url($config->mymoocsurl);
        } else {
            $mymoocsurl = new moodle_url('/my');
        }
        $html .= html_writer::link($mymoocsurl, get_string('displaymymoocs', 'block_orange_course_dashboard'));
        $html .= html_writer::end_tag('div');

        foreach ($courses as $key => $course) {
            $html .= $this->output->box_start('coursebox', "course-{$course->id}");
            $html .= html_writer::start_tag('div', array('class' => 'course_title'));

            $attributes = array('title' => $course->fullname);
            if ($course->id > 0) {
                if (empty($course->visible)) {
                        $attributes['class'] = 'dimmed';
                }
                $courseurl = new moodle_url('/course/view.php', array('id' => $course->id));
                $coursefullname = format_string(get_course_display_name_for_list($course), true, $course->id);
                $link = html_writer::link($courseurl, $coursefullname, $attributes);
                $html .= $this->output->heading($link, 2, 'title');
            } else {
                $html .= $this->output->heading(html_writer::link(
                        new moodle_url('/auth/mnet/jump.php', array('hostid' => $course->hostid,
                            'wantsurl' => '/course/view.php?id='.$course->remoteid)),
                            format_string($course->shortname, true),
                            $attributes) . ' (' . format_string($course->hostname) . ')', 2, 'title');
            }
            $html .= $this->output->box('', 'flush');
            $html .= html_writer::end_tag('div');

            if (!empty($config->showchildren) && ($course->id > 0)) {
                // List children here.
                if ($children = block_orange_course_dashboard_get_child_shortnames($course->id)) {
                    $html .= html_writer::tag('span', $children, array('class' => 'coursechildren'));
                }
            }

            if (isset($overviews[$course->id])) {
                $html .= $this->activity_display($course->id, $overviews[$course->id]);
            }

            $html .= $this->output->box('', 'flush');
            $html .= $this->output->box_end();
            $courseordernumber++;
        }
        // Wrap course list in a div and return.
        return html_writer::tag('div', $html, array('class' => 'course_list'));
    }

    /**
     * Coustuct activities overview for a course
     *
     * @param int $cid course id
     * @param array $overview overview of activities in course
     * @return string html of activities overview
     */
    protected function activity_display($cid, $overview) {
        $output = html_writer::start_tag('div', array('class' => 'activity_info'));
        foreach (array_keys($overview) as $module) {
            $output .= html_writer::start_tag('div', array('class' => 'activity_overview'));
            $url = new moodle_url("/mod/$module/index.php", array('id' => $cid));
            $modulename = get_string('modulename', $module);
            $icontext = html_writer::link($url,
                    $this->output->pix_icon('icon', $modulename, 'mod_'.$module, array('class' => 'iconlarge')));
            if (get_string_manager()->string_exists("activityoverview", $module)) {
                $icontext .= get_string("activityoverview", $module);
            } else {
                $icontext .= get_string("activityoverview", 'block_course_overview', $modulename);
            }

            // Add collapsible region with overview text in it.
            $output .= $this->collapsible_region($overview[$module], '', 'region_'.$cid.'_'.$module, $icontext, '', true);

            $output .= html_writer::end_tag('div');
        }
        $output .= html_writer::end_tag('div');
        return $output;
    }


    /**
     * Show hidden courses count
     *
     * @param int $total count of hidden courses
     * @return string html
     */
    public function hidden_courses($total) {
        if ($total <= 0) {
            return;
        }
        $output = $this->output->box_start('notice');
        $plural = $total > 1 ? 'plural' : '';

        $a = new stdClass();
        $a->coursecount = $total;
        $output .= get_string('hiddencoursecountwithshowall'.$plural, 'block_orange_course_dashboard', $a);

        $output .= $this->output->box_end();
        return $output;
    }

    /**
     * Creates collapsable region
     *
     * @param string $contents existing contents
     * @param string $classes class names added to the div that is output.
     * @param string $id id added to the div that is output. Must not be blank.
     * @param string $caption text displayed at the top. Clicking on this will cause the region to expand or contract.
     * @param string $userpref the name of the user preference that stores the user's preferred default state.
     *      (May be blank if you do not wish the state to be persisted.
     * @param bool $default Initial collapsed state to use if the user_preference it not set.
     * @return bool if true, return the HTML as a string, rather than printing it.
     */
    protected function collapsible_region($contents, $classes, $id, $caption, $userpref = '', $default = false) {
        $output  = $this->collapsible_region_start($classes, $id, $caption, $userpref, $default);
        $output .= $contents;
        $output .= $this->collapsible_region_end();

        return $output;
    }

    /**
     * Print (or return) the start of a collapsible region, that has a caption that can
     * be clicked to expand or collapse the region. If JavaScript is off, then the region
     * will always be expanded.
     *
     * @param string $classes class names added to the div that is output.
     * @param string $id id added to the div that is output. Must not be blank.
     * @param string $caption text displayed at the top. Clicking on this will cause the region to expand or contract.
     * @param string $userpref the name of the user preference that stores the user's preferred default state.
     *      (May be blank if you do not wish the state to be persisted.
     * @param bool $default Initial collapsed state to use if the user_preference it not set.
     * @return bool if true, return the HTML as a string, rather than printing it.
     */
    protected function collapsible_region_start($classes, $id, $caption, $userpref = '', $default = false) {
        // Work out the initial state.
        if (!empty($userpref) and is_string($userpref)) {
            user_preference_allow_ajax_update($userpref, PARAM_BOOL);
            $collapsed = get_user_preferences($userpref, $default);
        } else {
            $collapsed = $default;
            $userpref = false;
        }

        if ($collapsed) {
            $classes .= ' collapsed';
        }

        $output = '';
        $output .= '<div id="' . $id . '" class="collapsibleregion ' . $classes . '">';
        $output .= '<div id="' . $id . '_sizer">';
        $output .= '<div id="' . $id . '_caption" class="collapsibleregioncaption">';
        $output .= $caption . ' ';
        $output .= '</div><div id="' . $id . '_inner" class="collapsibleregioninner">';
        $this->page->requires->js_init_call('M.block_course_overview.collapsible',
                array($id, $userpref, get_string('clicktohideshow')));

        return $output;
    }

    /**
     * Close a region started with print_collapsible_region_start.
     *
     * @return string return the HTML as a string, rather than printing it.
     */
    protected function collapsible_region_end() {
            $output = '</div></div></div>';
            return $output;
    }
}
