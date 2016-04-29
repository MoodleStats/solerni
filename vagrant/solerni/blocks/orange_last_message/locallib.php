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
 * Helper functions for Orange Last Message block (from plugin local mail)
 *
 * @package    block_orange_last_message
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


/**
 * Return array with last message informations
 *
 * @param array $courses courses for which overview needs to be shown
 * @return array
 */
function get_user_last_message($USER) {

    if (!class_exists('local_mail_message')) {
        global $CFG;
        require_once($CFG->dirroot.'/local/mail/message.class.php');
    }

    $query['limit'] = 1;
    $lastmsg = local_mail_message::search_index ($USER->id, 'inbox', 0, $query);

    return $lastmsg;
}


