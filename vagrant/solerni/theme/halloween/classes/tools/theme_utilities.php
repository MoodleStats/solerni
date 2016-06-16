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

namespace theme_halloween\tools;
use local_orange_library\extended_course\extended_course_object;
use local_orange_library\utilities\utilities_course;
use theme_halloween\tools\log_and_session_utilities;
use local_orange_library\utilities\utilities_network;
use html_writer;

class theme_utilities {

    /**
     * Check if a theme setting exists and if it has a value.
     * We could ask for a unique setting or an array of settings,
     * with a option to check if all settings needs to be true,
     * or at least one.
     *
     * @param array or string $settings : setting name or array of settings names
     * @param string $option : 'atleastone' or 'all' values
     *
     * @return boolean
     */
    public static function is_theme_settings_exists_and_nonempty($settings, $option = null) {
        if (is_string($settings)) {
            return self::is_theme_setting_exists($settings);
        }

        if (is_array($settings) && $option === 'all') {
            foreach ($settings as $setting) {
                if (!self::is_theme_setting_exists($setting)) {
                    return false;
                }
            }
            return true;
        }

        if (is_array($settings) && $option === 'atleastone') {
            foreach ($settings as $setting) {
                if (self::is_theme_setting_exists($setting)) {
                    return true;
                }
            }
            return false;
        }

        return false;
    }

    /**
     *
     * Returns true if the settings exists in the $PAGE object
     * and that it is truly not empty (i.e. not a empty tag),
     * otherwise, return false.
     *
     * @global type $PAGE
     * @param string $setting
     * @return boolean
     */
    private static function is_theme_setting_exists($setting) {
        global $PAGE;

        if (property_exists($PAGE->theme->settings, $setting)) {
            return !empty(strip_tags($PAGE->theme->settings->$setting));
        }

        return false;
    }

    /**
     * Return the url of the FAQ.
     * Assume that the faq link is the first one of the second column of the footer.
     *
     * Return false if the settings is not existent.
     *
     * @return string || false
     */
    public static function get_platform_faq_url() {
        global $PAGE;
        if (self::is_theme_settings_exists_and_nonempty(array('footerlistscolumn2anchor1', 'footerlistscolumn2link1'), 'all')) {
            return $PAGE->theme->settings->footerlistscolumn2link1;
        }

        return false;
    }

    /**
     * Return the url of the CGU.
     * Assume that the faq link is the fourth one of the first column of the footer.
     *
     * Return false if the settings is not existent.
     *
     * @return string || false
     */
    public static function get_platform_cgu_url() {
        global $PAGE;
        if (self::is_theme_settings_exists_and_nonempty(array('footerlistscolumn1anchor4', 'footerlistscolumn1link4'), 'all')) {
            return $PAGE->theme->settings->footerlistscolumn1link4;
        }

        return false;
    }

    /*
     * Function to concentrate the load of required plugins or libraries.
     * Currently loads the plugin local_analytics.
     */
    public static function load_required_plugins() {
        global $CFG;
        if (file_exists($CFG->dirroot . '/local/analytics/lib.php')) {
            require_once($CFG->dirroot . '/local/analytics/lib.php');
        }
    }

    /**
     *  Identifying helper for page layout without breadcrumb
     *
     * @return bool
     */
    public static function is_layout_uses_breadcrumbs() {
        global $PAGE;

        $pageswithoutbreadcrumbs = array('login');

        if (in_array($PAGE->pagelayout, $pageswithoutbreadcrumbs)) {
            return false;
        }

        return true;
    }

    /**
     *  Identifying helper for page layout without breadcrumb
     *
     * @return bool
     */
    public static function is_layout_uses_page_block_title() {
        global $PAGE;

        $pagelayoutswithoutpageblocktitle = array('admin', 'mydashboard',
            'forum', 'basenotitle');

        $pagetypeswithoutpageblocktitle = array();

        // Check for pagetype static-*.
        if (strpos($PAGE->pagetype, 'static-') !== false) {
            return false;
        }

        // Check pagelayouts.
        if (in_array($PAGE->pagelayout, $pagelayoutswithoutpageblocktitle)) {
            return false;
        }

        // Check pagetypes.
        if (in_array($PAGE->pagetype, $pagetypeswithoutpageblocktitle)) {
            return false;
        }

        return true;
    }

    /**
     * Returns the titles for the page
     * meta_title, meta_desc, pageblocktitleh1, pageblockdesc, pageblockurl
     *
     *
     *
     * @return object
     */
    public static function define_page_titles_and_desc() {

        global $PAGE, $CFG, $COURSE;

        require_once($CFG->dirroot . '/filter/multilang/filter.php');
        $filtermultilang = new \filter_multilang($PAGE->context, array());

        // Object definition
        $return = new \stdClass;
        $return->pageblockmetatitle = '';
        $return->pageblockmetadesc = '';
        $return->pageblocktitleh1 = '';
        $return->pageblockdesc = '';
        $return->pageblockurl = '';

        switch ($PAGE->pagetype) {

            case 'login-index':
                if (theme_utilities::is_theme_settings_exists_and_nonempty('logintitle')) {
                    $return->pageblocktitleh1 .= $filtermultilang->filter($PAGE->theme->settings->logintitle);
                } else {
                    $return->pageblocktitleh1 .= get_string('login');
                }

                if (theme_utilities::is_theme_settings_exists_and_nonempty('logintext')) {
                    $return->pageblockdesc .= $filtermultilang->filter($PAGE->theme->settings->logintext);
                } elseif(!$CFG->solerni_isprivate) {
                    $return->pageblockdesc .= get_string('not_registered_yet', 'theme_halloween');
                    $return->pageblockdesc .= ' ';
                    $return->pageblockdesc .= \html_writer::tag('a', get_string('i_do_register', 'theme_halloween'),
                        array('class' => 'tag-platform-subscription',
                            'href' => log_and_session_utilities::get_register_form_url()));
                }
                break;

            case 'login-signup':
                if (theme_utilities::is_theme_settings_exists_and_nonempty('signuptitle')) {
                    $return->pageblocktitleh1 .= $filtermultilang->filter($PAGE->theme->settings->signuptitle);
                } else {
                    $return->pageblocktitleh1 .= get_string('signup');
                }

                if (theme_utilities::is_theme_settings_exists_and_nonempty('signuptext')) {
                    $return->pageblockdesc .= $filtermultilang->filter($PAGE->theme->settings->signuptext);
                } elseif(!$CFG->solerni_isprivate) {
                    $return->pageblockdesc .= get_string('already_registered', 'theme_halloween');
                    $return->pageblockdesc .= ' ';
                    $return->pageblockdesc .= \html_writer::tag('a', get_string('i_do_login', 'theme_halloween'),
                        array('class' => 'tag-platform-subscription', 'href' => $CFG->wwwroot . '/login/index.php'));
                }
                break;

            case 'site-index':
                if (utilities_network::is_platform_uses_mnet() && utilities_network::is_home()) {
                    $return->pageblocktitleh1 .= get_string('hometitle', 'theme_halloween');
                    $return->pageblockdesc .= ' ';
                } else {
                    $return->pageblocktitleh1 .= $PAGE->title;
                    $return->pageblockdesc .= '';
                }
                break;

            default:

                if(utilities_course::is_on_course_page()) {
                    $return->pageblockurl .= utilities_course::get_course_home_url();
                    // If the page title don't have the mooc name, add it.
                    if (strpos($PAGE->title, $COURSE->fullname) === false) {
                        $return->pageblocktitleh1 .= $COURSE->fullname;
                    }

                }

                if ($PAGE->title && $return->pageblocktitleh1) {
                    $return->pageblocktitleh1 .=  ': ';
                }

                $return->pageblocktitleh1 .= $PAGE->title;
                $return->pageblockdesc .= '';
                break;
        }

        return $return;

    }

      /**
     * Display button for Page en Savoir Plus
     *
     * @return string $output
     */
    public static function display_subscription_button($course, $buttonsetting ='', $containersetting = '') {

        $context = \context_course::instance($course->id);
        $extendedcourse = new extended_course_object();
        $extendedcourse->get_extended_course($course, $context);
        $cssbutton = ($buttonsetting) ? $buttonsetting : '';
        $csscontainer = ($containersetting) ? ' ' . $containersetting : '';

        // Display first line.
        $output = html_writer::start_tag('div', array('class' => 'row' . $csscontainer));
            $output .= html_writer::tag('div', $extendedcourse->displaybutton, array('class' => $cssbutton));

            if ($extendedcourse->statuslink != "#") {
                $output .= html_writer::tag('a', $extendedcourse->statuslinktext, 
                        array('class' => 'status-link', 'href' => $extendedcourse->statuslink ));
            }
        $output .= html_writer::end_tag('div');

        return $output;
    }

    /**
     * Display a separation line
     *
     * @return string $output
     */
    public static function display_line($containersetting) {
    $csscontainer = ($containersetting) ? $containersetting : '';

    $output = html_writer::start_tag('div', array('class' => 'row'));
        if($csscontainer) {
            $output .= html_writer::start_tag('div', array('class' => $csscontainer));
        }
        $output .= html_writer::tag('div', '',
                array('class' => "col-xs-12 fullwidth-line"));
        if($csscontainer) {
            $output .= html_writer::end_tag('div');
        }
    $output .= html_writer::end_tag('div');

    return $output;
    }

    public static function display_need_more_infos($containersetting) {
        $csscontainer = ($containersetting) ? $containersetting : '';
        global $PAGE;
        $contactlink = $PAGE->theme->settings->footerlistscolumn2link2;

        $output = html_writer::start_tag('div', array('class' => 'row'));
        if($csscontainer) {
            $output .= html_writer::start_tag('div', array('class' => $csscontainer));
        }
            $output .= html_writer::tag('div', get_string('more_info', 'theme_halloween'),
                    array('class' => 'pull-left page_view_more_contact__text'));
            $output .= html_writer::link($contactlink, get_string('contact_us', 'theme_halloween'),
                    array('title' => get_string('contact_us', 'theme_halloween'),
                        'class' => 'pull-left page_view_more_contact__link'));
            if($csscontainer) {
                $output .= html_writer::end_tag('div');
            }
        $output .= html_writer::end_tag('div');

        return $output;
    }

}
