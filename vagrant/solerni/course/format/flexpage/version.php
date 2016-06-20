<?php
/**
 * Flexpage
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://opensource.org/licenses/gpl-3.0.html.
 *
 * @copyright Copyright (c) 2009 Moodlerooms Inc. (http://www.moodlerooms.com)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @package format_flexpage
 * @author Mark Nielsen
 */

/**
 * Format Version
 *
 * @author Mark Nielsen
 * @package format_flexpage
 *
 *
 *
 * orange 2015050500 : adding extended course data
 * orange 2015120300 : modifing default to flexpage creation : visible in menu and flexpage next and previous
 * orange 2016011800 : migration Moodle 2.9
 * orange 2016020505 : migration Flexpage to Moodle 2.9
 * orange 2016022300 : add 2 different messages when delete activity or block
 */

$plugin->version      = 2016062000; //fork 2016012600
$plugin->requires     = 2014051203;
$plugin->component    = 'format_flexpage';
$plugin->release      = '2.9.3 (Build: 20160204)';
$plugin->maturity     = MATURITY_STABLE;
$plugin->dependencies = array(
    'block_flexpagenav' => 2014093000,
    'block_flexpagemod' => 2014093000,
    'theme_flexpage'    => 2014093000,
    'local_mr'          => 2010090201,
);
