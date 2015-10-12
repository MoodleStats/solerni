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
 * Orange Last Message block renderer
 *
 * @package    block_orange_last_message
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

use local_orange_library\utilities\utilities_object;
use local_mail\local_mail_renderer;

class block_orange_last_message_renderer extends plugin_renderer_base {

    /**
     * Display date
     *
     * @param array $message
     * @param boolean $viewmail
     * @return string html of date
     */
    public function date($message, $viewmail = false) {
        $offset = get_user_timezone_offset();
        $time = ($offset < 13) ? $message->time() + $offset : $message->time();
        $now = ($offset < 13) ? time() + $offset : time();
        $daysago = floor($now / 86400) - floor($time / 86400);
        $yearsago = (int) date('Y', $now) - (int) date('Y', $time);
        $tooltip = userdate($time, get_string('strftimedatetime'));

        if ($viewmail) {
            $content = userdate($time, get_string('strftimedatetime'));
            $beforedate = " " . get_string('beforedate', 'block_orange_last_message') . " ";
            $tooltip = '';
        } else if ($daysago == 0) {
            $content = userdate($time, get_string('strftimetime'));
            $beforedate = " " . get_string('beforehour', 'block_orange_last_message') . " ";
        } else if ($yearsago == 0) {
            $content = userdate($time, get_string('strftimedateshort'));
            $beforedate = " " . get_string('beforedate', 'block_orange_last_message') . " ";
        } else {
            $content = userdate($time, get_string('strftimedate'));
            $beforedate = " " . get_string('beforedate', 'block_orange_last_message') . " ";
        }

        return html_writer::tag('span',  $beforedate . s($content), array('class' => 'mail_date', 'title' => $tooltip));
    }

    /**
     * Construct message overview 
     *
     * @param array $message
     * @return string html of message overview
     */
    public function message_display(local_mail_message $message) {
        $utilities = new utilities_object();

        $output = html_writer::start_tag('div', array('class' => 'block_orange_last_message'));
        $output .= html_writer::start_tag('p', array('class' => 'title'));
        $output .= get_string('lastmessage', 'block_orange_last_message');
        $output .= html_writer::empty_tag('br');
        $output .= html_writer::end_tag('p');

        $messageurl = new moodle_url('/local/mail/view.php', array('t' => "inbox" , 'm' => $message->id()));

        $outputlink = html_writer::empty_tag('img',
                    array('src' => '/blocks/orange_last_message/pix/last_message.png',
                    'alt' => get_string('messagelink', 'block_orange_last_message'),
                    'title' => get_string('messagelink', 'block_orange_last_message')));
        $outputlink .= html_writer::empty_tag('br');
        $outputlink .= $utilities->trim_text($message->subject(), 15) .$this->date($message);

        $output .= html_writer::start_tag('span', array('class' => 'mailsubject'));
        $output .= html_writer::link($messageurl, $outputlink);
        $output .= html_writer::empty_tag('br');
        $output .= html_writer::end_tag('span');

        $output .= html_writer::start_tag('span', array('class' => 'content'));
        $output .= $utilities->trim_text($message->content(), 30);
        $output .= html_writer::empty_tag('br');
        $output .= html_writer::end_tag('span');

        $mailboxurl = new moodle_url('/local/mail/view.php', array('t' => "inbox" ));
        $output .= html_writer::start_tag('span', array('class' => 'mailboxlink'));
        $output .= html_writer::link($mailboxurl, get_string('mailboxlink', 'block_orange_last_message'));
        $output .= html_writer::end_tag('span');
        $output .= html_writer::end_tag('div');
        return $output;
    }

    /**
     * Construct output when there is no message to display
     *
     * @return string html
     */
    public function no_message_display() {
        $output = html_writer::start_tag('div', array('class' => 'block_orange_last_message'));
        $output .= html_writer::start_tag('div', array('class' => 'no_message'));
        $output .= get_string('nothingtodisplay', 'block_orange_last_message');
        $output .= html_writer::empty_tag('br');
        $output .= html_writer::empty_tag('img',
            array('src' => '/blocks/orange_last_message/pix/last_message_empty.png',
                  'alt' => get_string('messagelink', 'block_orange_last_message'),
                  'title' => get_string('messagelink', 'block_orange_last_message')));
        $output .= html_writer::empty_tag('br');
        $output .= html_writer::start_tag('p', array('class' => 'blockdesc'));
        $output .= get_string('blockdesc', 'block_orange_last_message');
        $output .= html_writer::empty_tag('br');
        $output .= html_writer::end_tag('p');
        $output .= html_writer::end_tag('div');

        $messageurl = new moodle_url('/local/mail/view.php', array('t' => "inbox" ));
        $output .= html_writer::start_tag('span', array('class' => 'mailboxlink'));
        $output .= "<a href='" . $messageurl . "'>" . get_string('mailboxlink', 'block_orange_last_message') . "</a>";
        $output .= html_writer::end_tag('span');
        $output .= html_writer::end_tag('div');
        return $output;
    }
}
