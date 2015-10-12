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

use local_orange_library\utilities\utilities_course;
use local_orange_library\utilities\utilities_image;

require_once($CFG->dirroot . '/badges/renderer.php');
require_once($CFG->libdir . '/formslib.php');

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
                $name = html_writer::tag('span', $bname, array('class' => 'badge-name')) . html_writer::tag('span', $cname, array('class' => 'course-name'));
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


   /**
     * Displays the user badges
     *
     * This is an override from Moodle in order to display badges order by Mooc.
     * Other modifications : delete download button + delete search box + change wording when there is no badge.
     *
     * @return string
    */
    protected function render_badge_user_collection(badge_user_collection $badges) {
        global $CFG, $USER, $SITE, $PAGE;
        $backpack = $badges->backpack;
        $mybackpack = new moodle_url('/badges/mybackpack.php');

        $paging = new paging_bar($badges->totalcount, $badges->page, $badges->perpage, $this->page->url, 'page');
        $htmlpagingbar = $this->render($paging);

        // Set backpack connection string.
        $backpackconnect = '';
        if (!empty($CFG->badges_allowexternalbackpack) && is_null($backpack)) {
            $backpackconnect = $this->output->box(get_string('localconnectto', 'badges', $mybackpack->out()), 'noticebox');
        }
        // Search box : not display in Solerni.
        $searchform =  "";

        // Download all button.
        // Not displayed for Solerni.
        $downloadall = "";

        // Local badges.
        $localhtml = html_writer::start_tag('fieldset', array('id' => 'issued-badge-table', 'class' => 'generalbox'));
        $heading = get_string('localbadges', 'badges', format_string($SITE->fullname, true, array('context' => context_system::instance())));
        $localhtml .= html_writer::tag('legend', $this->output->heading_with_help($heading, 'localbadgesh', 'badges'));
        if ($badges->badges) {
            $downloadbutton = $this->output->heading(get_string('badgesearned', 'badges', $badges->totalcount), 4, 'activatebadge');
            $downloadbutton .= $downloadall;

            $htmllist = $this->print_badges_list_by_course($badges->badges, $USER->id);
            $localhtml .= $backpackconnect . $downloadbutton . $searchform . $htmlpagingbar . $htmllist . $htmlpagingbar;
        } else {
            $faqurl = $PAGE->theme->settings->faq;
            $localhtml .= $searchform . get_string('nobadges', 'badges', $faqurl);
        }
        $localhtml .= html_writer::end_tag('fieldset');

        // External badges.
        $externalhtml = "";
        if (!empty($CFG->badges_allowexternalbackpack)) {
            $externalhtml .= html_writer::start_tag('fieldset', array('class' => 'generalbox'));
            $externalhtml .= html_writer::tag('legend', $this->output->heading_with_help(get_string('externalbadges', 'badges'), 'externalbadges', 'badges'));
            if (!is_null($backpack)) {
                if ($backpack->totalcollections == 0) {
                    $externalhtml .= get_string('nobackpackcollections', 'badges', $backpack);
                } else {
                    if ($backpack->totalbadges == 0) {
                        $externalhtml .= get_string('nobackpackbadges', 'badges', $backpack);
                    } else {
                        $externalhtml .= get_string('backpackbadges', 'badges', $backpack);
                        $externalhtml .= '<br/><br/>' . $this->print_badges_list($backpack->badges, $USER->id, true, true);
                    }
                }
            } else {
                $externalhtml .= get_string('externalconnectto', 'badges', $mybackpack->out());
            }
            $externalhtml .= html_writer::end_tag('fieldset');
        }

        return $localhtml . $externalhtml;
    }

   /**
     * Outputs badges list
     *
     * This is an override from Moodle in order to display badges ordered by Mooc.
     * Other modifications : delete download buttons + add customer logo + add course selector.
     *
     * @return string
    */
    public function print_badges_list_by_course($badges, $userid, $profile = false, $external = false) {
        global $USER, $CFG, $DB;

        $courseid = optional_param('courseid',     0, PARAM_INT);

        $coursebadges = array();
        $courses = array(0 => "Tous les moocs");
        // change sort order of badges : order by course.
        foreach ($badges as $badge) {

            if (array_key_exists($badge->courseid, $coursebadges)) {
                array_push($coursebadges[$badge->courseid], $badge);
            } else {
                $coursebadges[$badge->courseid] = array();
                array_push($coursebadges[$badge->courseid], $badge);

                $coursename = $DB->get_field('course', 'fullname', array('id' => $badge->courseid));
                $courses[$badge->courseid] = $coursename;
            }
        }

        $furl = new moodle_url('/badges/mybadges.php', array('sesskey' => sesskey()));

        $attrs = [
            'onchange' => 'location.href = "' . $furl . '" + "&courseid=" + encodeURIComponent(this[this.selectedIndex].value)',
            'id' => 'courseid'
        ];

        $selectcourse = html_writer::start_tag('form', array('method' => 'post', 'action' => $url, 'id' => 'badge_order_course_form'));
        $selectcourse .= html_writer::select($courses, 'courseid', $courseid, null, $attrs);
        $selectcourse .= html_writer::end_tag('form');

        $output = "";
        foreach ($coursebadges as $key=>$course) {
            $items = array();

            if ($key == $courseid || intval($courseid) == 0){
                for($i=0;$i<count($course);$i++) {
                    $badge = $course[$i];

                    if (!$external) {
                        $context = ($badge->type == BADGE_TYPE_SITE) ? context_system::instance() : context_course::instance($badge->courseid);
                        $bname = $badge->name;
                        $imageurl = moodle_url::make_pluginfile_url($context->id, 'badges', 'badgeimage', $badge->id, '/', 'f1', false);
                    } else {
                        $bname = s($badge->assertion->badge->name);
                        $imageurl = $badge->imageUrl;
                    }

                    $name = html_writer::tag('span', $bname, array('class' => 'badge-name'));

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
                        $url = new moodle_url('mybadges.php', array('download' => $badge->id, 'hash' => $badge->uniquehash, 'sesskey' => sesskey()));
                        $notexpiredbadge = (empty($badge->dateexpire) || $badge->dateexpire > time());
                        $backpackexists = badges_user_has_backpack($USER->id);
                        if (!empty($CFG->badges_allowexternalbackpack) && $notexpiredbadge && $backpackexists) {
                            $assertion = new moodle_url('/badges/assertion.php', array('b' => $badge->uniquehash));
                            $action = new component_action('click', 'addtobackpack', array('assertion' => $assertion->out(false)));
                            $push = $this->output->action_icon(new moodle_url('#'), new pix_icon('t/backpack', get_string('addtobackpack', 'badges')), $action);
                        }

                        // Not displayed for Solerni.
                        $download = "";
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
                    $items[] = html_writer::link($url, $image . $name . $actions , array('title' => $bname));
                }

                $coursename = $DB->get_field('course', 'fullname', array('id' => $badge->courseid));
                $utilitiescourse = new utilities_course();
                $categoryid = $utilitiescourse->get_categoryid_by_courseid($badge->courseid);
                $customer = $utilitiescourse->solerni_course_get_customer_infos($categoryid);

                $customerlogo = '';
                if (isset($customer->id)) {
                    $customerlogo .= "";
                    if ($customer->urlimg != "") {
                        $customerlogo .= "<div class='orange-course-logo'><img  src='";
                        $customerlogo .= utilities_image::get_resized_url($customer->urlimg, array ('scale' => 'true', 'h' => 20));
                        $customerlogo .= "' /></div>";
                    }
                }
                $output .= html_writer::start_tag('div', array('class' => 'orange-course-name-logo'));
                $output .= html_writer::tag('div', $coursename, array('class' => 'orange-course-name'));
                $output .= $customerlogo;
                $output .= html_writer::end_tag('div');
                $output .= html_writer::start_tag('div', array('class' => 'orange-badges-list'));
                $output .= html_writer::alist($items, array('class' => 'badges'));
                $output .= html_writer::end_tag('div');
            }
        }

        $output = $selectcourse . $output;
        return $output;
    }
}
