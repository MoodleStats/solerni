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
 * Orange Mooc Badges block for displaying badges to users
 *
 * @package    block_orange_badges
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . "/badgeslib.php");

/**
 * Displays mooc badges
 */
class block_orange_badges extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_orange_badges');
    }

    public function instance_allow_multiple() {
        return false;
    }

    public function has_config() {
        return false;
    }

    public function instance_allow_config() {
        return true;
    }

    public function applicable_formats() {
        return array(
                'admin' => false,
                'site-index' => false,
                'course-view' => true,
                'mod' => false,
                'my' => true
        );
    }

    public function specialization() {
        global $PAGE;

        $url = $PAGE->url;
        // If we are on the dashboard (My) then we customized the output for Solerni.
        if (!empty($url)) {
            $ismypage = ($PAGE->url->compare(new moodle_url('/my/index.php'), URL_MATCH_BASE) ||
                $PAGE->url->compare(new moodle_url('/my/indexsys.php'), URL_MATCH_BASE));

            if ($ismypage) {
                $this->title = get_string('pluginname', 'block_orange_badges');
            } else {
                $this->title = get_string('titlemooc', 'block_orange_badges');
            }
        } else {
            $this->title = get_string('pluginname', 'block_orange_badges');
        }
    }

    public function get_content() {
        global $USER, $PAGE, $CFG;

        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->config)) {
            $this->config = new stdClass();
        }

        // Number of badges to display.
        if (!isset($this->config->numberofbadges)) {
            $this->config->numberofbadges = 10;
        }

        // Create empty content.
        $this->content = new stdClass();
        $this->content->text = '';

        if (empty($CFG->enablebadges)) {
            $this->content->text .= get_string('badgesdisabled', 'badges');
            return $this->content;
        }

        $courseid = $this->page->course->id;
        if ($courseid == SITEID) {
            $courseid = null;
        }

        // If we are on the dashboard (My) then we customized the output for Solerni.
        $ismypage = ($PAGE->url->compare(new moodle_url('/my/index.php'), URL_MATCH_BASE) ||
                $PAGE->url->compare(new moodle_url('/my/indexsys.php'), URL_MATCH_BASE));

        if ($ismypage) {
            $badges = badges_get_user_badges($USER->id, $courseid, 0, $this->config->numberofbadges);
        } else {
            $badges = badges_get_badges(BADGE_TYPE_COURSE, $courseid, '', '', 0, $this->config->numberofbadges, $USER->id);
        }

        // All badges or Mooc badges.
        if ($badges) {
            $output = $this->page->get_renderer('block_orange_badges');
            $this->content->text = $output->print_badges_list($badges, $USER->id, true);
        } else {
            $this->content->text .= get_string('nothingtodisplay', 'block_orange_badges');
        }

        return $this->content;
    }
}
