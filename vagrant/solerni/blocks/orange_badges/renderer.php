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
 * Orange Badges block renderer
 *
 * @package    block_orange_badges
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
use local_orange_library\utilities\utilities_image;

class block_orange_badges_renderer extends plugin_renderer_base {

    // Outputs badges list.
    public function print_badges_list($badges, $userid, $profile = false, $external = false) {
        global $USER, $CFG, $PAGE;

        // If we are on the dashboard (My) then we customized the output for Solerni.
        $ismypage = ($PAGE->url->compare(new moodle_url('/my/index.php'), URL_MATCH_BASE) ||
                $PAGE->url->compare(new moodle_url('/my/indexsys.php'), URL_MATCH_BASE));

        // If we are on the dashboard (My) then we customized the output for Solerni.
        if (isset($PAGE->url) && !empty($PAGE->url)) {
            $ismypage = ($PAGE->url->compare(new moodle_url('/my/index.php'), URL_MATCH_BASE) ||
                $PAGE->url->compare(new moodle_url('/my/indexsys.php'), URL_MATCH_BASE));

            if ($ismypage) {
                $title = get_string('titledashboard', 'block_orange_badges');
            } else {
                $title = get_string('titlemooc', 'block_orange_badges');
            }
        } else {
            $title = get_string('titledashboard', 'block_orange_badges');
        }

        foreach ($badges as $badge) {
            // We need to have the course name here for Solerni and we don't have it in the input parameters
            // We read it even if it should not be done in a renderer. This prevent to create a new block.
            $cname = "";
            if ($ismypage) {
                $course = get_course($badge->courseid);
                $cname = $course->fullname;
            }

            if (!$external) {
                $context = ($badge->type == BADGE_TYPE_SITE) ?
                        context_system::instance() : context_course::instance($badge->courseid);
                $bname = $badge->name . " " . $cname;
                $imageurl = moodle_url::make_pluginfile_url($context->id, 'badges', 'badgeimage', $badge->id, '/', 'f1', false);
            } else {
                $bname = s($badge->assertion->badge->name . " " . $cname);
                $imageurl = $badge->imageUrl;
            }
            $linkmybadges = "";
            if ($ismypage) {
                $name = html_writer::tag('span', $bname,
                                array('class' => 'badge-name')) . html_writer::tag('span', $cname, array('class' => 'course-name'));
                $mybadgesurl = new moodle_url('/badges/mybadges.php');
                $linkmybadges = '<a class="btn btn-default" href="' . $mybadgesurl . '">' .
                            get_string('mybadges', 'theme_halloween') . '</a>';
            } else {
                $name = html_writer::tag('span', $bname, array('class' => 'badge-name'));
                $mybadgesurl = new moodle_url('/badges/view.php', array('type' => BADGE_TYPE_COURSE, 'id' => $badge->courseid));
                $linkmybadges = '<a class="btn btn-default" href="' . $mybadgesurl . '">' .
                            get_string('allmoocbadges', 'block_orange_badges') . '</a>';
            }

            // Image different if is earned or not.
            if (isset($badge->dateissued)) {
                $image = html_writer::empty_tag('img', array('src' => $imageurl, 'class' => 'badge-image'));
            } else {
                $image = html_writer::empty_tag('img', array('src' => $imageurl, 'class' => 'badge-image badge-image-notearn'));
            }
            if (!empty($badge->dateexpire) && $badge->dateexpire < time()) {
                $image .= $this->output->pix_icon('i/expired',
                                get_string('expireddate', 'badges', userdate($badge->dateexpire)),
                                'moodle',
                                array('class' => 'expireimage'));
                $name .= '(' . get_string('expired', 'badges') . ')';
            }

            $download = $status = $push = '';
            if (($userid == $USER->id) && !$profile) {
                $url = new moodle_url('mybadges.php', array('download' => $badge->id,
                    'hash' => $badge->uniquehash, 'sesskey' => sesskey()));
                $notexpiredbadge = (empty($badge->dateexpire) || $badge->dateexpire > time());
                $backpackexists = badges_user_has_backpack($USER->id);
                if (!empty($CFG->badges_allowexternalbackpack) && $notexpiredbadge && $backpackexists) {
                        $assertion = new moodle_url('/badges/assertion.php', array('b' => $badge->uniquehash));
                        $action = new component_action('click', 'addtobackpack', array('assertion' => $assertion->out(false)));
                        $push = $this->output->action_icon(new moodle_url('#'),
                                new pix_icon('t/backpack', get_string('addtobackpack', 'badges')), $action);
                }

                $download = $this->output->action_icon($url, new pix_icon('t/download', get_string('download')));
                if ($badge->visible) {
                        $url = new moodle_url('mybadges.php', array('hide' => $badge->issuedid, 'sesskey' => sesskey()));
                        $status = $this->output->action_icon($url, new pix_icon('t/hide', get_string('makeprivate', 'badges')));
                } else {
                        $url = new moodle_url('mybadges.php', array('show' => $badge->issuedid, 'sesskey' => sesskey()));
                        $status = $this->output->action_icon($url, new pix_icon('t/show', get_string('makepublic', 'badges')));
                }
            }

            if (!$profile) {
                $url = $mybadgesurl;
            } else {
                if (!$external) {
                    $url = $mybadgesurl;
                } else {
                    $hash = hash('md5', $badge->hostedUrl);
                    $url = new moodle_url('/badges/external.php', array('hash' => $hash, 'user' => $userid));
                }
            }
            $actions = html_writer::tag('div', $push . $download . $status, array('class' => 'badge-actions'));
            $items[] = html_writer::link($url, $image . $actions, array('title' => $bname));
        }

        // Title + link to "my badges" page.
        $output = html_writer::start_tag('div', array('class' => 'row u-row-table'));
            $output .= html_writer::start_tag('div', array('class' => 'col-md-8 text-left'));
                $output .= html_writer::tag('h2', $title);
            $output .= html_writer::end_tag('div');
            $output .= html_writer::start_tag('div', array('class' => 'col-md-4 text-right u-vertical-align'));
        if (!empty($CFG->enablebadges) && $badges) {
                $output .= $linkmybadges;
        }
            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        $content = "";
        // Create empty content.
        if (empty($CFG->enablebadges)) {
            $content .= get_string('badgesdisabled', 'badges');
        } else if (!$badges) {
            $content .= get_string('nothingtodisplay', 'block_orange_badges');
        } else if (!is_null($items)) {
            // Create badge list.
            $content = html_writer::alist($items, array('class' => 'orange-badge'));
        }

        $output .= html_writer::start_tag('div', array('class' => 'row'));
            $output .= html_writer::start_tag('div', array('class' => 'col-md-12 orange-badges'));
                $output .= $content;
            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');
        return $output;
    }
}
