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
 * Theme More config file.
 *
 * @package    theme_halloween
 * @copyright  2014 Bas Brands
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/*
 *  Add theme variables in $CFG config object.
 *  Useful for template inclusion files
 */
$CFG->themedir = $CFG->dirroot . '/theme/halloween';
$CFG->partialsdir = $CFG->themedir . '/layout/partials';

/*
 * Theme definition and inheritance. We inherite from Moodle Bootstrap Theme
 * as it is one active theme using Boostrap v3.
 * See https://github.com/bmbrands/theme_bootstrap
 *
 * We fork the current theme from halloween which is an almost empty Child theme
 * for Bootstrap Theme designed for this purpose.
 * See https://github.com/bmbrands/theme_cerulean
 *
 */

$THEME->name = 'halloween';
$THEME->parents = array('bootstrap');

/*
 * The LESS file to compile. (Advanced)
 *
 * Since Moodle 2.7 it is possible to compile a LESS file on the fly.
 *
 * The LESS file has to be located in the less/ folder of the theme. You
 * can only ever have one LESS file. In order to change the values of
 * the variables or add custom LESS content on the fly, you must also
 * declare the settings $THEME->lessvariablescallback and
 * $THEME->extralesscallback.
 *
 * In most cases if you use this setting you should not need to use
 * $THEME->sheets any more.
 *
 * Please note that $THEME->lessfile is NEVER inherited from
 * the parent theme. Also, as compiling LESS is a slow process, the compiled
 * file is cached, make sure that you turn designer mode on when you are
 * working on your theme.
 *
 * You can refer to the theme More (theme_more) as an example.
 */

$THEME->lessfile = 'base-mixin';

/*
 * Injecting LESS variables. (Advanced)
 *
 * Used in combination with $THEME->lessfile, this declares a callback
 * function to inject LESS variables. By convention, the name of
 * this function should start by theme_yourthemename and be placed in
 * a file call lib.php. That function must return an associative
 * array of variable names and values. For example, if you want to change
 * the variable @bodyBackground to #ffffff, you would return the following
 * array from the function:
 *
 *     array('bodyBackground' => '#ffffff');
 *
 * The first parameter passed to the function is the theme_config object.
 */

$THEME->lessvariablescallback = 'theme_halloween_less_variables';


/*
 * Injecting LESS content. (Advanced)
 *
 * Used in combination with $THEME->lessfile, this declares a callback
 * function to inject LESS code. By convention, the name of
 * this function should start by theme_yourthemename and be placed in
 * a file call lib.php. That function must return a string
 * containing LESS code. This code will be injected after the LESS content
 * of the file declared in $THEME->lessfile. If you want to dynamically
 * declare variables it is highly recommended that you use
 * $THEME->lessvariablescallback instead.
 */

$THEME->extralesscallback = 'theme_halloween_extra_less';

$THEME->parents_exclude_sheets = true;

/*
 * The layout files list
 * Each page has been attributed a page type. Each page type has
 * been associated to a specific layout file (see layout directory).
 * This theme inherits the page type association set in the parent theme.
 *
 * The flexpage layout is required to use flexpage_format.
 */

$THEME->layouts = array(
    'format_flexpage' => array(
        'file' => 'default.php',
        'regions' => array('side-top', 'side-pre', 'main'),
        'defaultregion' => 'main',
        'options' => array('langmenu' => true)
    ),
    // Most backwards compatible layout without the blocks - this is the layout used by default.
    'base' => array(
        'file' => 'default.php',
        'regions' => array()
    ),
    // Base but no page block title.
    'basenotitle' => array(
        'file' => 'default.php',
        'regions' => array()
    ),
    // Standard layout with blocks, this is recommended for most pages with general information.
    'standard' => array(
        'file' => 'default.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre'
    ),
    // Main course page.
    'course' => array(
        'file' => 'default.php',
        'regions' => array()
    ),
    'coursecategory' => array(
        'file' => 'default.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre'
    ),
    // Part of course, typical for modules - default page layout if $cm specified in require_login().
    'incourse' => array(
        'file' => 'default.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre'
    ),
    // The site home page.
    'frontpage' => array(
        'file' => 'default.php',
        'regions' => array('main'),
        'defaultregion' => 'main',
        'options' => array('nonavbar' => true)
    ),
    // Server administration scripts.
    'admin' => array(
        'file' => 'default.php',
        'regions' => array('side-pre'),
        'defaultregion' => '',
        'options' => array('fluid' => true)
    ),
    // My dashboard page.
    'mydashboard' => array(
        'file' => 'default.php',
        'regions' => array(),
        'defaultregion' => 'content',
        'options' => array('langmenu' => true)
    ),
    // My public page.
    'mypublic' => array(
        'file' => 'default.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre'
    ),
    // Login page
    'login' => array(
        'file' => 'default.php',
        'regions' => array()
    ),
    // Pages that appear in pop-up windows - no navigation, no blocks, no header.
    'popup' => array(
        'file' => 'popup.php',
        'regions' => array(),
        'options' => array('nofooter' => true, 'nonavbar' => true)
    ),
    // No blocks and minimal footer - used for legacy frame layouts only!
    'frametop' => array(
        'file' => 'default.php',
        'regions' => array(),
        'options' => array('nofooter' => true, 'nocoursefooter' => true)
    ),
    // Embeded pages, like iframe/object embeded in moodleform - it needs as much space as possible.
    'embedded' => array(
        'file' => 'embedded.php',
        'regions' => array()
    ),
    // Used during upgrade and install, and for the 'This site is undergoing maintenance' message.
    // This must not have any blocks, links, or API calls that would lead to database or cache interaction.
    // Please be extremely careful if you are modifying this layout.
    'maintenance' => array(
        'file' => 'maintenance.php',
        'regions' => array()
    ),
    // Should display the content and basic headers only.
    'print' => array(
        'file' => 'default.php',
        'regions' => array(),
        'options' => array('nofooter' => true, 'nonavbar' => false)
    ),
    // The pagelayout used when a redirection is occuring.
    'redirect' => array(
        'file' => 'redirect.php',
        'regions' => array()
    ),
    // The pagelayout used for reports.
    'report' => array(
        'file' => 'default.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre'
    ),
    // The pagelayout used for safebrowser and securewindow.
    'secure' => array(
        'file' => 'secure.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre'
    )
);

/*
 * Flexpage format CSS
 */

$THEME->sheets = array('flexpage');

/*
 * Using renderers.
 *
 * Mandatory declaration to use renderers.
 */

$THEME->rendererfactory = 'theme_overridden_renderer_factory';

/*
 * An array of javascript files located in /javascript/
 * $THEME->javascripts includes files in the header
 * $THEME->javascripts_footer includes files in the footer
 */

$THEME->javascripts_footer = array('piwik_tag_events', 'modernizr-custom');
