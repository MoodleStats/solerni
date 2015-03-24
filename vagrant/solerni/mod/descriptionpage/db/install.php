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
 * Page module post install function
 *
 * This file replaces:
 *  - STATEMENTS section in db/install.xml
 *  - lib.php/modulename_install() post installation hook
 *  - partially defaults.php
 *
 * @package mod_descriptionpage
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die;

function xmldb_descriptionpage_install() {
    global $DB, $CFG;

    require_once($CFG->dirroot . '/course/lib.php');

    // Setup the global blog.
    $page = new stdClass;
    $page->course = SITEID;
    $page->name = 'Description Page';
    $page->intro = '';
    $page->introformat = FORMAT_HTML;
    $page->accesstoken = md5(uniqid(rand(), true));
    $page->maxvisibility = 300;// page_VISIBILITY_PUBLIC.
    $page->global = 1;
    $page->allowcomments = 2;// page_COMMENTS_ALLOWPUBLIC.

}
