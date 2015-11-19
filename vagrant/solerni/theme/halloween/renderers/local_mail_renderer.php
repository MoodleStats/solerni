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
 * Renderer for local mail output
 *
 * @package     theme_halloween
 * @copyright   2015 Orange
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

include_once($CFG->dirroot . "/local/mail/renderer.php");

class theme_halloween_local_mail_renderer extends local_mail_renderer {

    /**
     * Override from Local mail plugin
     * to replace overview of sent and received messages
     *
     * @param message $message
     * @param int $userid
     * @param int $type
     * @param int $itemid
     * @return string html to be displayed in page local/mail/view.php?t=course
     */
    public function users($message, $userid, $type, $itemid) {
        if ($userid == $message->sender()->id) {
            if ($users = array_merge($message->recipients('to'), $message->recipients('cc'), $message->recipients('bcc'))) {
            $picto = html_writer::start_tag('span', array('class' => 'glyphicon glyphicon-log-out'));
            $picto .= html_writer::end_tag('span');
                $content = $picto . " " . s(implode(', ', array_map('fullname', $users)));
            } else {
                $content = s(get_string('norecipient', 'local_mail'));
            }
        } else {
            $picto = html_writer::start_tag('span', array('class' => 'glyphicon glyphicon-log-in'));
            $picto .= html_writer::end_tag('span');
            $content = $picto . " " .s(fullname($message->sender()));
        }
        return html_writer::tag('span', $content, array('class' => 'mail_users'));
    }

 }
