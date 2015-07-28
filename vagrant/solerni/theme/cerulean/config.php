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
 * Theme More config file.
 *
 * @package    theme_cerulean
 * @copyright  2014 Bas Brands
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$THEME->name = 'cerulean';
$THEME->parents = array('bootstrap');
// Theme variable
$CFG->themedir = $CFG->dirroot . '/theme/cerulean';
$CFG->partialsdir = $CFG->themedir . '/layout/partials';

$THEME->doctype = 'html5';
//$THEME->sheets = array('custom');

// general style sheets.
$THEME->parentsheets = true;
$THEME->sheets          = array(
                            'custom',
                            'blockicons',
                            'profilebar',
                            'font-awesome',
                            'general',
                            'footer-header',
                            'utils',
                            'frontpage',
                            'block-social',
                            'queries-1180',
                            'queries-980',
                            'queries-768',
                            'queries-400',
                            'override'
                        );
$THEME->lessfile = 'cerulean';
//$THEME->parents_exclude_sheets = array('bootstrap' => array('moodle'));
$THEME->lessvariablescallback = 'theme_cerulean_less_variables';
$THEME->extralesscallback = 'theme_cerulean_extra_less';
$THEME->supportscssoptimisation = false;
$THEME->yuicssmodules = array();
$THEME->enable_dock = true;
$THEME->editor_sheets = array();
$THEME->layouts = array(
    // Most backwards compatible layout without the blocks - this is the layout used by default.
    'base' => array(
        'file' => 'columns1.php',
        'regions' => array(),
    ),
    // Standard layout with blocks, this is recommended for most pages with general information.
    'standard' => array(
        'file' => 'columns3.php',
        'regions' => array('side-pre', 'side-post'),
        'defaultregion' => 'side-pre',
    ),
    // Main course page.
    'course' => array(
        'file' => 'columns3.php',
        'regions' => array('side-pre', 'side-post'),
        'defaultregion' => 'side-pre',
        'options' => array('langmenu' => true),
    ),
    'coursecategory' => array(
        'file' => 'columns3.php',
        'regions' => array('side-pre', 'side-post'),
        'defaultregion' => 'side-pre',
    ),
    // Part of course, typical for modules - default page layout if $cm specified in require_login().
    'incourse' => array(
        'file' => 'columns3.php',
        'regions' => array('side-pre', 'side-post'),
        'defaultregion' => 'side-pre',
    ),
    // The site home page.
    // We removed all regions.
    'frontpage' => array(
        'file' => 'frontpage.php',
        'regions' => array()
    ),
    // Server administration scripts.
    'admin' => array(
        'file' => 'columns2.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
    ),
    // My dashboard page.
    'mydashboard' => array(
        'file' => 'columns3.php',
        'regions' => array('side-pre', 'side-post'),
        'defaultregion' => 'side-pre',
        'options' => array('langmenu' => true),
    ),
    // My public page.
    'mypublic' => array(
        'file' => 'columns3.php',
        'regions' => array('side-pre', 'side-post'),
        'defaultregion' => 'side-pre',
    ),


    // Pages that appear in pop-up windows - no navigation, no blocks, no header.
    'popup' => array(
        'file' => 'popup.php',
        'regions' => array(),
        'options' => array('nofooter' => true, 'nonavbar' => true),
    ),
    // No blocks and minimal footer - used for legacy frame layouts only!
    'frametop' => array(
        'file' => 'columns1.php',
        'regions' => array(),
        'options' => array('nofooter' => true, 'nocoursefooter' => true),
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
        'regions' => array(),
    ),
    // Should display the content and basic headers only.
    'print' => array(
        'file' => 'columns1.php',
        'regions' => array(),
        'options' => array('nofooter' => true, 'nonavbar' => false),
    ),
    // The pagelayout used when a redirection is occuring.
    'redirect' => array(
        'file' => 'embedded.php',
        'regions' => array(),
    ),
    // The pagelayout used for reports.
    'report' => array(
        'file' => 'columns2.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
    ),
    // The pagelayout used for safebrowser and securewindow.
    'secure' => array(
        'file' => 'secure.php',
        'regions' => array('side-pre', 'side-post'),
        'defaultregion' => 'side-pre'
    ),
    // The pagelayout used for format_flexpage.
       'format_flexpage' => array(
        'file' => 'columns3.php',
        'regions' => array('side-top', 'side-pre', 'main', 'side-post'),
        'defaultregion' => 'main',
        'options' => array('langmenu'=>true),
    ),
);

$THEME->javascripts = array( 'modernizr' );

$THEME->javascripts_footer = array(
    'moodlebootstrap',
    'jquery.placeholder.min',
    'cerulean-general'
);

$THEME->rendererfactory = 'theme_overridden_renderer_factory';
$THEME->csspostprocess = 'theme_cerulean_process_css';
