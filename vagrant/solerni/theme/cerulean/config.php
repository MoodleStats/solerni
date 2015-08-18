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
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/*
 *  Add theme variables in $CFG config object.
 *  Useful for template inclusion files
 */
$CFG->themedir = $CFG->dirroot . '/theme/cerulean';
$CFG->partialsdir = $CFG->themedir . '/layout/partials';

/*
 * Theme definition and inheritance. We inherite from Moodle Bootstrap Theme
 * as it is one active theme using Boostrap v3.
 * See https://github.com/bmbrands/theme_bootstrap
 *
 * We fork the current theme from Cerulean which is an almost empty Child theme
 * for Bootstrap Theme designed for this purpose.
 * See https://github.com/bmbrands/theme_cerulean
 *
 */

$THEME->name = 'cerulean';
$THEME->parents = array('bootstrap');

/**
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

$THEME->lessfile = 'cerulean';

/**
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

$THEME->lessvariablescallback = 'theme_cerulean_less_variables';


/**
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

$THEME->extralesscallback = 'theme_cerulean_extra_less';

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
        'file' => 'columns3.php',
        'regions' => array('side-top', 'side-pre', 'main', 'side-post'),
        'defaultregion' => 'main',
        'options' => array('langmenu'=>true),
    ),
);

/*
 * Flexpage format CSS
 */

$THEME->sheets = array('flexpage');

/**
 * Using renderers.
 *
 * Mandatory declaration to use renderers.
 */

$THEME->rendererfactory = 'theme_overridden_renderer_factory';
