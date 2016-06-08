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
 * Forum -- a forum page
 *
 * - this page is completed with any blocks by moosh
 * - if user has capability moodle/block:edit , he can manage the blocks
 *
 * @package    moodlecore
 * @subpackage forum
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../config.php');

redirect_if_major_upgrade_required();

// TODO Add sesskey check to edit
$edit   = optional_param('edit', null, PARAM_BOOL);    // Turn editing on and off.

$hassiteconfig = has_capability('moodle/site:config', context_system::instance());
if ($hassiteconfig && moodle_needs_upgrading()) {
    redirect(new moodle_url('/admin/index.php'));
}

if (isloggedin()) {
    $context = context_user::instance($USER->id);
    if (has_capability('moodle/block:edit', $context)) {
        $PAGE->set_blocks_editing_capability('moodle/block:edit');
    }
} else {
    $USER->editing = $edit = 0;  // Just in case.
    $context = context_system::instance();
}


// Start setting up the page.
$params = array();
$PAGE->set_context($context);
$PAGE->set_url('/forum/index.php', array());
$PAGE->set_pagelayout('basenotitle');
$PAGE->set_pagetype('forum-index');
$PAGE->set_title(get_string('forum_page_title', 'theme_halloween') . $SITE->fullname);
$PAGE->blocks->add_region('content');
$loginsite  = get_string("forumnavbar", "theme_halloween");
$PAGE->navbar->add($loginsite);

// This page is not available on Solerni HOME
if (local_orange_library\utilities\utilities_network::is_platform_uses_mnet() &&
        local_orange_library\utilities\utilities_network::is_home()) {
    redirect($CFG->wwwroot);
}

// Toggle the editing state and switches.
if ($PAGE->user_allowed_editing()) {
    if ($edit !== null) {             // Editing state was specified.
        $USER->editing = $edit;       // Change editing state.
    } else {                          // Editing state is in session.
        if (!empty($USER->editing)) {
            $edit = 1;
        } else {
            $edit = 0;
        }
    }

    // Add button for editing page.
    $params = array('edit' => !$edit);

    if (empty($edit)) {
        $editstring = get_string('updatemymoodleon');
    } else {
        $editstring = get_string('updatemymoodleoff');
    }

    $url = new moodle_url("$CFG->wwwroot/forum/index.php", $params);
    $button = $OUTPUT->single_button($url, $editstring);
    $PAGE->set_button($button);

} else {
    $USER->editing = $edit = 0;
}

echo $OUTPUT->header();
echo $OUTPUT->custom_block_region('content');
echo $OUTPUT->footer();
