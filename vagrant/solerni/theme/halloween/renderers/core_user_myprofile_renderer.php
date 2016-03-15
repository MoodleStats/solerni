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
 * myprofile renderer.
 *
 * @package    core_user
 * @copyright  2015 onwards Ankit Agarwal <ankit.agrr@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
use core_user\output\myprofile;
use local_orange_library\utilities\utilities_user;

/**
 * Report log renderer's for printing reports.
 *
 * @since      Moodle 2.9
 * @package    core_user
 * @copyright  2015 onwards Ankit Agarwal <ankit.agrr@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class theme_halloween_core_user_myprofile_renderer extends core_user\output\myprofile\renderer {

    /**
     * Render the whole tree.
     *
     * @param tree $tree
     *
     * @return string
     */
    public function render_tree(core_user\output\myprofile\tree $tree) {
        global $USER, $OUTPUT;
        $userid = optional_param('id', 0, PARAM_INT);
        $ismyprofile = ($userid == $USER->id) || empty($userid);

        $return = "";
        if ($ismyprofile) {
            // Display using the same format of other user profile (taken form /user/view.php).
            $usercontext   = context_user::instance($USER->id, IGNORE_MISSING);
            $headerinfo = array('heading' => fullname($USER), 'user' => $USER, 'usercontext' => $usercontext);
            $return = $OUTPUT->context_header($headerinfo, 2);
        }
        $return .= \html_writer::start_tag('div', array('class' => 'profile_tree'));
        $categories = $tree->categories;
        foreach ($categories as $category) {
            $return .= $this->render($category);
        }
        $return .= \html_writer::end_tag('div');
        if ($ismyprofile) {
            // Add delete account button.
            $deleteaccount = \html_writer::link(new moodle_url('/local/goodbye/index.php'),
                    get_string('manageaccount', 'local_goodbye'),
                    array('class' => 'btn btn-danger btn-sm'));
            $return .= $deleteaccount;
        }
        return $return;
    }

    /**
     * Render a category.
     *
     * @param category $category
     *
     * @return string
     */
    public function render_category(core_user\output\myprofile\category $category) {

        // For Solerni we hide some entries.
        $entriestohide = array ('blogs', 'forumposts', 'forumdiscussions');
        $displaycategorie = false;
        foreach ($category->nodes as $node) {
            if (!in_array($node->name, $entriestohide)) {
                $displaycategorie = true;
            }
        }

        if (!$displaycategorie) {
            return;
        }
        $classes = $category->classes;
        if (empty($classes)) {
            $return = \html_writer::start_tag('section', array('class' => 'node_category', 'style' => 'background-color:#EAEAEA;'));
        } else {
            $return = \html_writer::start_tag('section', array('class' => 'node_category ' . $classes));
        }
        $return .= \html_writer::tag('h3', $category->title,
                array ('style' => 'color:black!important;margin-left:15px;padding-top:10px;'));
        $nodes = $category->nodes;
        if (empty($nodes)) {
            // No nodes, nothing to render.
            return '';
        }
        $return .= \html_writer::start_tag('ul', array ('style' => 'margin-left:0px;padding-bottom:25px;'));
        foreach ($nodes as $node) {
            $return .= $this->render($node);
        }
        $return .= \html_writer::end_tag('ul');
        $return .= \html_writer::end_tag('section');
        return $return;
    }

    /**
     * Render a node.
     *
     * @param node $node
     *
     * @return string
     */
    public function render_node(core_user\output\myprofile\node $node) {
        Global $USER;

        $return = '';

        // For Solerni we hide some entries.
        $entriestohide = array ('blogs', 'forumposts', 'forumdiscussions');
        if (in_array($node->name, $entriestohide)) {
            return;
        }
        if (is_object($node->url)) {
            if ($node->name == "editprofile") {
                $header = \html_writer::link($node->url, $node->title, array('class' => 'btn btn-primary btn-sm pull-right'));
            } else {
                $header = \html_writer::link($node->url, $node->title);
            }
        } else {
            $header = $node->title;
        }
        $icon = $node->icon;
        if (!empty($icon)) {
            $header .= $this->render($icon);
        }
        $content = $node->content;
        $classes = $node->classes;
        if (!empty($content)) {
            if (($node->name == "custom_field_blog") ||
                       ($node->name == "custom_field_googleplus") ||
                       ($node->name == "custom_field_linkedin") ||
                       ($node->name == "custom_field_facebook") ||
                       ($node->name == "custom_field_twitter")) {
                if ((strpos($content, "http://" ) !== 0) && (strpos($content, "https://" ) !== 0)) {
                    $content = "http://" . $content;
                }
                $content = \html_writer::link(new moodle_url($content), $content, array('target' => '_new'));
            } else if (($node->name == "mnet") && ($node->classes == "remoteuserinfo")) {
                // Replace link to home by link to edit profile on MNET home.
                // Link only available on "my profile".
                $userid = optional_param('id', 0, PARAM_INT);
                $ismyprofile = ($userid == $USER->id) || empty($userid);
                if ($ismyprofile) {
                    $editprofileurl = utilities_user::get_edituserprofile_url();
                    $content = \html_writer::link($editprofileurl, get_string('editmyprofile'),
                            array('class' => 'btn btn-primary btn-sm pull-right'));
                    $header = "";
                } else {
                    $content = "";
                }
            } else if ($node->name == "custom_field_ddn") {
                // Hide the field il value if "Not fixed".
                if ($content == get_string('notset', 'profilefield_datetime')) {
                    $content = "";
                }
            } else if ($node->name == "webpage") {
                // Add target to link.
                $content = str_replace("<a href=", "<a target='_new' href=", $content);
            }
            if (!empty($content)) {
                $return = \html_writer::tag('b', $header);
                $return .= \html_writer::tag('div', $content, array ('style' => 'padding-bottom:10px;'));

                if ($classes) {
                    $return = \html_writer::tag('div', $return, array('class' => 'contentnode ' . $classes));
                } else {
                    $return = \html_writer::tag('div', $return, array('class' => 'contentnode'));
                }
            }
        } else {
            $return = \html_writer::span($header);
            if ($node->name != "editprofile") {
                $return = \html_writer::tag('div', $return, array('class' => $classes));
            }
        }

        return $return;
    }
}
