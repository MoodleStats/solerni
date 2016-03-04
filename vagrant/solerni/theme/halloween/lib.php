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
 * Theme halloween lib.
 *
 * @package    theme_halloween
 * @copyright  2014 Bas Brands
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function theme_halloween_bootstrap_grid($hassidepre, $hassidepost) {

    if ($hassidepre && $hassidepost) {
        $regions = array('content' => 'col-sm-6 col-sm-push-3 col-lg-8 col-lg-push-2');
        $regions['pre'] = 'col-sm-3 col-sm-pull-6 col-lg-2 col-lg-pull-8';
        $regions['post'] = 'col-sm-3 col-lg-2';
    } else if ($hassidepre && !$hassidepost) {
        $regions = array('content' => 'col-sm-8 col-sm-push-4 col-lg-9 col-lg-push-3');
        $regions['pre'] = 'col-sm-4 col-sm-pull-8 col-lg-3 col-lg-pull-9';
        $regions['post'] = 'emtpy';
    } else if (!$hassidepre && $hassidepost) {
        $regions = array('content' => 'col-sm-8 col-lg-9');
        $regions['pre'] = 'empty';
        $regions['post'] = 'col-sm-4 col-lg-3';
    } else if (!$hassidepre && !$hassidepost) {
        $regions = array('content' => 'col-md-12');
        $regions['pre'] = 'empty';
        $regions['post'] = 'empty';
    }

    if ('rtl' === get_string('thisdirection', 'langconfig')) {
        if ($hassidepre && $hassidepost) {
            $regions['pre'] = 'col-sm-3  col-sm-push-3 col-lg-2 col-lg-push-2';
            $regions['post'] = 'col-sm-3 col-sm-pull-9 col-lg-2 col-lg-pull-10';
        } else if ($hassidepre && !$hassidepost) {
            $regions = array('content' => 'col-sm-9 col-lg-10');
            $regions['pre'] = 'col-sm-3 col-lg-2';
            $regions['post'] = 'empty';
        } else if (!$hassidepre && $hassidepost) {
            $regions = array('content' => 'col-sm-9 col-sm-push-3 col-lg-10 col-lg-push-2');
            $regions['pre'] = 'empty';
            $regions['post'] = 'col-sm-3 col-sm-pull-9 col-lg-2 col-lg-pull-10';
        }
    }

    return $regions;
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_halloween_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    static $theme;
    if (!$theme) {
        $theme = theme_config::load('halloween');
    }
    if ($context->contextlevel == CONTEXT_SYSTEM && ($filearea === 'loginlogo')) {
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    } else {
        send_file_not_found();
    }
}

/**
 *
 * Function declared in theme config.php which gets a theme config objects
 * and returns a associative array ( bootstrap variable name => value )
 * which allow us to changes bootstrap variables values on-the-fly.
 *
 * We get the colors settings from get_colors_array() in the options object
 *
 * Note about the str_replace : As Moodle forbids the use of the dash (-) in variable names, and Boostraps
 * uses dashes in variables names, we use underscores (_) in Moodle settings variables names,
 * and replace them on the fly.
 *
 * Another solution would had been to do a mapping of variables names in the variables.less file
 * like @boostrap-name : @moodle_name;
 *
 * @param type $themeconfig
 *
 * @return array
 */
function theme_halloween_less_variables($themeconfig) {
    $colorsettings = \theme_halloween\settings\options::get_colors_list();
    foreach ($colorsettings as $key => $value) {
        if (!empty( $themeconfig->settings->$key ) ) {
            $value = $themeconfig->settings->$key;
        }
        $colorvalues[str_replace('_', '-', $key)] = $value;
    }

    return $colorvalues;
}

/**
 * Adds code snippet to a moodle form object for custom profile fields that
 * should appear on the signup page. Duplicate from Moodle to remove unecessary fieldset
 * @param moodleform $mform moodle form object
 */
function halloween_profile_signup_fields($mform) {
    global $CFG, $DB;

    // Only retrieve required custom fields (with category information)
    // results are sort by categories, then by fields.
    $sql = "SELECT uf.id as fieldid, ic.id as categoryid, ic.name as categoryname, uf.datatype
                FROM {user_info_field} uf
                JOIN {user_info_category} ic
                ON uf.categoryid = ic.id AND uf.signup = 1 AND uf.visible<>0
                ORDER BY ic.sortorder ASC, uf.sortorder ASC";

    if ( $fields = $DB->get_records_sql($sql)) {
        foreach ($fields as $field) {
            require_once($CFG->dirroot.'/user/profile/field/'.$field->datatype.'/field.class.php');
            $newfield = 'profile_field_'.$field->datatype;
            $formfield = new $newfield($field->fieldid);
            $formfield->edit_field($mform);
        }
    }
}

/**
 * Check if user is connected,
 * if user if on different page that we could be redirects to or chose to go,
 * like enrol, policy, logout, that we are not in some kind of loop,
 * and if we have a wantsurl in $SESSION we redirects accordingly.
 *
 * @global $SESSION
 * @global $PAGE
 *
 * return @void
 */
function theme_halloween_redirect_if_wantsurl() {
    global $PAGE, $SESSION;

    if(!isloggedin()) {
            return;
    }

    // Those page are redirection free.
    if( strpos('/enrol/index.php', $PAGE->url->get_path()) !== false
        || strpos('/user/policy.php', $PAGE->url->get_path()) !== false
        || strpos('/logout.php', $PAGE->url->get_path()) !== false
        || strpos('/change_password.php', $PAGE->url->get_path()) !== false) {
            return;
    }

    // Loop detector. It means the system has redirected the user,
    // or the user has clicked something different,
    // meaning we need to stop forcing user journey.
    if (isset($SESSION->hasbeenredirected) && !empty($SESSION->hasbeenredirected)
         && isset($SESSION->wantsurl) && !empty($SESSION->wantsurl)) {
        unset($SESSION->wantsurl);
        unset($SESSION->hasbeenredirected);
            return;
    }

    // We had been redirected but wantsurl is empty. Unprobable but we never know.
    if(isset($SESSION->hasbeenredirected)
        && (!isset($SESSION->wantsurl) || empty($SESSION->wantsurl))) {
            unset($SESSION->hasbeenredirected);
            return;
    }

    if (isset($SESSION->wantsurl) && !empty($SESSION->wantsurl)) {
        $SESSION->hasbeenredirected = 1;
        $urltogo = $SESSION->wantsurl;
        unset($SESSION->wantsurl);
        redirect($urltogo);
    }
}

/*
 * Loads core jQuery in theme
 */
function theme_halloween_page_init(moodle_page $page) {
    $page->requires->jquery();
}
