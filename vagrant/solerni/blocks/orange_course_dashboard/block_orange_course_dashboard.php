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
 * Orange Course Dashboard block
 *
 * @package    block_orange_course_dashboard
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->dirroot.'/blocks/orange_course_dashboard/locallib.php');

class block_orange_course_dashboard extends block_base {
    /**
     * If this is passed as mynumber then showallcourses, irrespective of limit by user.
     */
    const SHOW_ALL_COURSES = -2;

    /**
     * Block initialization
     */
    public function init() {
            $this->title   = get_string('pluginname', 'block_orange_course_dashboard');
    }

    /**
     * Return contents of orange_course_dashboard block
     *
     * @return stdClass contents of block
     */
    public function get_content() {
        global $USER, $CFG, $DB;

        if ($this->content !== null) {
            return $this->content;
        }

        $config = get_config('block_orange_course_dashboard');

        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';

        list($sortedcourses, $sitecourses, $totalcourses) =
                block_orange_course_dashboard_get_sorted_courses($config->defaultmaxcourses);

        $renderer = $this->page->get_renderer('block_orange_course_dashboard');

        if ($totalcourses) {
            // We present to the user the list of follow MOOCs.
            $overviews = block_orange_course_dashboard_get_overviews($sitecourses);
            if (empty($sortedcourses)) {
                $this->content->text .= get_string('nocourses', 'my');
            } else {
                // For each course, build category cache.
                $this->content->text .= $renderer->course_overview($sortedcourses, $overviews);
                $this->content->text .= $renderer->hidden_courses($totalcourses - count($sortedcourses));
            }
        } else {
            // Set default to 4.
            if ($config->defaultmaxrecommendations == 0) {
                $config->defaultmaxrecommendations = 4;
            }
            list($recommendedcourses, $recommendedcoursesdetails, $totalrecommendedcourses) =
                    block_orange_course_dashboard_get_recommended_courses($config->defaultmaxrecommendations);
            // We display recommandation to the user.
            if ($totalrecommendedcourses && !$this->hide_recommendation()) {
                $this->content->text .= $renderer->course_recommendation($recommendedcourses, $recommendedcoursesdetails);
            } else {
                $this->content->text .= $renderer->course_norecommendation();
            }
        }
        return $this->content;
    }

    /**
     * Allow the block to have a configuration page
     *
     * @return boolean
     */
    public function has_config() {
            return true;
    }

    /**
     * Locations where block can be displayed
     *
     * @return array
     */
    public function applicable_formats() {
            return array('my-index' => true);
    }

    /**
     * Sets block header to be hidden or visible
     *
     * @return bool if true then header will be visible.
     */
    public function hide_header() {
            $config = get_config('block_orange_course_dashboard');
            return !empty($config->hideblockheader);
    }

    /**
     * Force recommendation to be hidden
     *
     * @return bool if true then no recommendation displayed.
     */
    public function hide_recommendation() {
            $config = get_config('block_orange_course_dashboard');
            return !empty($config->forcednoavailabalemooc);
    }

}
