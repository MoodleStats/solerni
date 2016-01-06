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
 * Email forwarding script. This uses the post selector infrastructure to
 * handle the situation when posts are being selected.
 * @package forumngfeature
 * @subpackage forward
 * @copyright 2011 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once('../forumngfeature_post_selector.php');
require_once('forward_form.php');
require_once($CFG->dirroot . '/local/orange_mail/classes/mail_object.php');

class forward_post_selector extends forumngfeature_post_selector {
    public function get_button_name() {
        return get_string('forward', 'forumngfeature_forward');
    }

    public function require_capability($context, $discussion) {
        require_capability('mod/forumng:forwardposts', $context);
    }

    public function get_form($discussion, $all, $selected = array()) {
        $customdata = (object)array(
            'subject' => $discussion->get_subject(),
            'discussionid' => $discussion->get_id(),
            'cloneid' => $discussion->get_forum()->get_course_module_id(),
            'postids' => $selected,
            'onlyselected' => !$all);
        return new mod_forumng_forward_form('forward.php', $customdata);
    }

    public function apply($discussion, $all, $selected, $formdata) {
        global $COURSE, $USER, $CFG;

        // Begin with standard text
        $a = (object)array('name' => fullname($USER, true));

        $allhtml = "\n";

        $preface = get_string('forward_preface', 'forumngfeature_forward', $a);
        $allhtml .= $preface;
        $alltext = format_text_email($preface, FORMAT_HTML);

        // Include intro if specified
        if (!preg_match('~^(<br[^>]*>|<p>|</p>|\s)*$~', $formdata->message['text'])) {
            $alltext .= "\n" . mod_forumng_cron::EMAIL_DIVIDER . "\n";
            $allhtml .= '<hr size="1" noshade="noshade" />';

            // Add intro
            $message = trusttext_strip($formdata->message['text']);
            $allhtml .= format_text($message, $formdata->message['format']);
            $alltext .= format_text_email($message, $formdata->message['format']);
        }

        // Get list of all post ids in discussion order
        $alltext .= "\n" . mod_forumng_cron::EMAIL_DIVIDER . "\n";
        $allhtml .= '<hr size="1" noshade="noshade" />';
        $poststext = '';
        $postshtml = '';
        $discussion->build_selected_posts_email(
            $selected, $poststext, $postshtml);
        $alltext .= $poststext;
        $allhtml .= $postshtml;

        $emails = preg_split('~[; ]+~', $formdata->email);
        $subject = $formdata->subject;
        foreach ($emails as $email) {
            $fakeuser = (object)array(
                'email' => $email,
                'mailformat' => 1,
                'id' => -1
            );

            $from = $USER;
            $from->maildisplay = 999; // Nasty hack required for OU moodle

            if (!email_to_user($fakeuser, $from, $subject, 
                    mail_object::get_mail($alltext, 'text', ''), 
                    mail_object::get_mail($allhtml, 'html', '') )) {
                print_error('error_forwardemail', 'forumng',
                        $discussion->get_moodle_url(), $formdata->email);
            }
        }

        // Log that it was sent
        $params = array(
            'context' => $discussion->get_forum()->get_context(),
            'objectid' => $discussion->get_id(),
            'other' => array('logurl' => $discussion->get_log_url(), 'info' => $formdata->email)
        );

        $event = \forumngfeature_forward\event\discussion_forwarded::create($params);
        $event->add_record_snapshot('course_modules', $discussion->get_course_module());
        $event->add_record_snapshot('course', $discussion->get_course());
        $event->trigger();

        if (!empty($formdata->ccme)) {
            if (!email_to_user($USER, $from, $subject, 
                    mail_object::get_mail($alltext, 'text', ''), 
                    mail_object::get_mail($allhtml, 'html', ''))) {
                print_error('error_forwardemail', 'forumng',
                        $discussion->get_moodle_url(), $USER->email);
            }
        }

        $out = $discussion->init_page($discussion->get_moodle_url(), $this->get_page_name());
        print $out->header();

        print $out->box(get_string('forward_done', 'forumngfeature_forward'));
        print $out->continue_button(new moodle_url('/mod/forumng/discuss.php',
                $discussion->get_link_params_array()));
        print $out->footer();
    }

    public function get_content_after_form($discussion, $all, $selected, $formdata) {
        // Print selected messages if they have any (rather than whole
        // discussion)
        if (!$all) {
            // Display selected messages below form
            $allhtml = '';
            $alltext = '';
            $discussion->build_selected_posts_email(
                $selected, $alltext, $allhtml);
            print '<div class="forumng-showemail">' . $allhtml . '</div>';
        }
    }
}

forumngfeature_post_selector::go(new forward_post_selector());
