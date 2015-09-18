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
 * Renderer for use with the badges output
 *
 * @package     theme_solerni
 * @copyright   2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->dirroot . '/badges/renderer.php');

class theme_halloween_core_badges_renderer extends core_badges_renderer {

    // Outputs badges list.
    public function print_badges_list($badges, $userid, $profile = false, $external = false) {
        global $USER, $CFG, $PAGE;

        // If we are on the dashboard (My) then we customized the output for Solerni.
        $ismypage = ($PAGE->url->compare(new moodle_url('/my/index.php'), URL_MATCH_BASE) ||
                $PAGE->url->compare(new moodle_url('/my/indexsys.php'), URL_MATCH_BASE));

        $title = "";
        if ($ismypage) {
            $title = html_writer::tag('p', get_string('lastbadge', 'theme_halloween'), array('class' => 'todo-tobedefined'));
        }

        foreach ($badges as $badge) {
            // We need to have the course name here for Solerni and we don't have it in the input parameters
            // We read it even if it should not be done in a renderer. This prevent to create a new block.
            if ($ismypage) {
                $course = get_course($badge->courseid);
                $cname = $course->fullname;
            }

            if (!$external) {
                $context = ($badge->type == BADGE_TYPE_SITE) ?
                        context_system::instance() : context_course::instance($badge->courseid);
                $bname = $badge->name;
                    $imageurl = moodle_url::make_pluginfile_url($context->id, 'badges', 'badgeimage', $badge->id, '/', 'f1', false);
            } else {
                $bname = s($badge->assertion->badge->name);
                $imageurl = $badge->imageUrl;
            }

            if ($ismypage) {
                $name = html_writer::tag('span', $bname . "<br/>" . $cname, array('class' => 'badge-name'));
            } else {
                $name = html_writer::tag('span', $bname, array('class' => 'badge-name'));
            }

            $image = html_writer::empty_tag('img', array('src' => $imageurl, 'class' => 'badge-image'));
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
                $url = new moodle_url('badge.php', array('hash' => $badge->uniquehash));
            } else {
                if (!$external) {
                    $url = new moodle_url('/badges/badge.php', array('hash' => $badge->uniquehash));
                } else {
                    $hash = hash('md5', $badge->hostedUrl);
                    $url = new moodle_url('/badges/external.php', array('hash' => $hash, 'user' => $userid));
                }
            }
            $actions = html_writer::tag('div', $push . $download . $status, array('class' => 'badge-actions'));
            $items[] = html_writer::link($url, $image . $actions . $name, array('title' => $bname));
        }

        // On Dashboard display link to "my badges" page.
        $linkmybadges = "";
        if ($ismypage) {
            $mybadgesurl = new moodle_url('/badges/mybadges.php');
            $linkmybadges = html_writer::link($mybadgesurl, get_string('mybadges', 'badges'));
        }

        return $title . html_writer::alist($items, array('class' => 'badges')) . $linkmybadges;
    }

}
