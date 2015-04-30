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
 * Private page module utility functions
 *
 * @package mod
 * @subpackage descriptionpage
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die;

require_once("$CFG->libdir/filelib.php");
require_once("$CFG->libdir/resourcelib.php");
require_once("$CFG->dirroot/mod/descriptionpage/lib.php");


/**#@+
 * Constants defining the visibility levels of blog posts
 */
define('DESCRIPTIONPAGE_VISIBILITY_COURSEUSER',   100);
define('DESCRIPTIONPAGE_VISIBILITY_LOGGEDINUSER', 200);
define('DESCRIPTIONPAGE_VISIBILITY_PUBLIC',       300);
/**#@-*/



/**
 * File browsing support class
 */
class descriptionpage_page_content_file_info extends file_info_stored {
    public function get_parent() {
        if ($this->lf->get_filepath() === '/' and $this->lf->get_filename() === '.') {
            return $this->browser->get_file_info($this->context);
        }
        return parent::get_parent();
    }
    public function get_visible_name() {
        if ($this->lf->get_filepath() === '/' and $this->lf->get_filename() === '.') {
            return $this->topvisiblename;
        }
        return parent::get_visible_name();
    }
}

function descriptionpage_page_get_editor_options($context) {
    global $CFG;
    return array(
        'subdirs' => 1,
        'maxbytes' => $CFG->maxbytes,
        'maxfiles' => -1,
        'changeformat' => 1,
        'context' => $context,
        'noclean' => 1,
        'trusttext' => 0
        );
}

/**
 * Checks if a user is allowed to view a blog. If not, will not return (calls
 * an error function and exits).
 * @param object $page
 * @param object $context
 * @param object $cm
 * @return void
 */
function descriptionpage_page_check_view_permissions($page, $context, $cm=null) {
    global $COURSE, $PAGE, $DB;

    $capability = 'mod/descriptionpage:view';

    switch ($page->maxvisibility) {
        case DESCRIPTIONPAGE_VISIBILITY_PUBLIC:
            if ($page->course == $COURSE->id or empty($page->course)) {
                $pagecourse = $COURSE;
            } else {
                $pagecourse = $DB->get_record('course', array('id' => $page->course),
                        '*', MUST_EXIST);
            }
            $PAGE->set_course($pagecourse);
            $PAGE->set_cm($cm, $pagecourse);
            $PAGE->set_pagelayout('incourse');
            return;

        case DESCRIPTIONPAGE_VISIBILITY_LOGGEDINUSER:
            require_login(SITEID, false);
            if ($page->course == $COURSE->id or empty($page->course)) {
                $pagecourse = $COURSE;
            } else {
                $pagecourse = $DB->get_record('course', array('id' => $page->course),
                        '*', MUST_EXIST);
            }
            $PAGE->set_course($pagecourse);
            $PAGE->set_cm($cm, $pagecourse);
            $PAGE->set_pagelayout('incourse');
            // Check page:view cap.
            if (!has_capability($capability, $context)) {
                require_course_login($pagecourse, true, $cm);
            }
            return;

        case DESCRIPTIONPAGE_VISIBILITY_COURSEUSER:
            require_course_login($page->course, false, $cm);
            // Check page:view cap.
            if (!has_capability($capability, $context)) {
                require_course_login($pagecourse, true, $cm);
            }
            return;

        default:
            require_course_login($pagecourse, true, $cm);
    }
}