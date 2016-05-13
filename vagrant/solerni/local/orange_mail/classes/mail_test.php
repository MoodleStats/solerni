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
 * @package    orange_mail
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

use theme_halloween\settings\options;
use theme_halloween\tools\theme_utilities;
use local_orange_library\utilities\utilities_course;
require_once($CFG->dirroot . '/local/orange_mail/classes/mail_object.php');
require_once($CFG->dirroot . '/mod/forumng/mod_forumng.php');

/**
 * All functions in this class are copy of Moodle code or Plugins code.
 * This code is for email test purpose only
 */
class mail_test {

    static public function reset_password_and_mail($user, $modetext=false) {
        global $CFG;

        $site  = get_site();
        $supportuser = core_user::get_support_user();

        $newpassword = "new password";

        $a = new stdClass();
        $a->firstname   = $user->firstname;
        $a->lastname    = $user->lastname;
        $a->sitename    = format_string($site->fullname);
        $a->username    = $user->username;
        $a->newpassword = $newpassword;
        $a->link        = $CFG->httpswwwroot .'/login/change_password.php';
        $a->signoff     = generate_email_signoff();

        // TODO - Bad format in Moodle.
        $messagehtml = get_string('newpasswordtext', '', $a);
        $message = html_to_text($messagehtml);

        $subject  = '(M1)' . format_string($site->fullname) .': '. get_string('changedpassword');

        if ($modetext) {
            $user->mailformat = 0;
        } else {
            $user->mailformat = 1;
        }

        // Directly email rather than using the messaging system to ensure its not routed to a popup or jabber.
        return email_to_user($user, $supportuser, $subject, $message, $messagehtml);
    }


    static public function user_account_mail_public($user, $modetext=false) {
        global $CFG;

        $profileurl = "$CFG->wwwroot/user/view.php?id=" . $user->id;
        $contact = core_user::get_support_user();
        $siteurl = $CFG->wwwroot;
        $site  = get_site();

        // Send account email reminder.
        $message = get_string('contentuseraccountemail', 'local_orange_event_user_loggedin');
        $key = array('{$a->fullname}', '{$a->email}', '{$a->sitename}', '{$a->siteurl}', '{$a->profileurl}');
        $value = array(fullname($user), $user->email, format_string($site->fullname),
            $siteurl, $profileurl);
        $message = str_replace($key, $value, $message);
        if (strpos($message, '<') === false) {
            // Plain text only.
            $messagetext = $message;
            $messagehtml = text_to_html($messagetext, null, false, true);
        } else {
            $messagehtml = $message;
            $messagetext = html_to_text($messagehtml);
        }

        $subject = get_string('subjectuseraccountemail', 'local_orange_event_user_loggedin');
        $subject = '(M2)' . str_replace('{$a->customername}', ucfirst($CFG->solerni_customer_name), $subject);

        if ($modetext) {
            $user->mailformat = 0;
        } else {
            $user->mailformat = 1;
        }

        email_to_user($user, $contact, $subject, $messagetext, $messagehtml);
    }

    static public function user_account_mail_private($user, $modetext=false) {
        global $CFG;

        $profileurl = "$CFG->wwwroot/user/view.php?id=" . $user->id;
        $contact = core_user::get_support_user();
        $siteurl = $CFG->wwwroot;
        $site  = get_site();

        // Send account email reminder.
        $message = get_string('contentuseraccountemailprivate', 'local_orange_event_user_loggedin');
        $key = array('{$a->fullname}', '{$a->email}', '{$a->sitename}', '{$a->siteurl}', '{$a->profileurl}');
        $value = array(fullname($user), $user->email, format_string($site->fullname),
            $siteurl, $profileurl);
        $message = str_replace($key, $value, $message);
        if (strpos($message, '<') === false) {
            // Plain text only.
            $messagetext = $message;
            $messagehtml = text_to_html($messagetext, null, false, true);
        } else {
            $messagehtml = $message;
            $messagetext = html_to_text($messagehtml);
        }

        $subject = get_string('subjectuseraccountemailprivate', 'local_orange_event_user_loggedin');
        $subject = '(M2)' . str_replace('{$a->customername}', ucfirst($CFG->solerni_customer_name), $subject);

        if ($modetext) {
            $user->mailformat = 0;
        } else {
            $user->mailformat = 1;
        }

        email_to_user($user, $contact, $subject, $messagetext, $messagehtml);
    }

    static public function send_password_change_confirmation_email($user, $modetext=false) {
        global $CFG;

        $site = get_site();
        $supportuser = core_user::get_support_user();
        $pwresetmins = isset($CFG->pwresettime) ? floor($CFG->pwresettime / MINSECS) : 30;

        $data = new stdClass();
        $data->firstname = $user->firstname;
        $data->lastname  = $user->lastname;
        $data->username  = $user->username;
        $data->sitename  = format_string($site->fullname);
        $data->link      = $CFG->httpswwwroot .'/login/forgot_password.php?token=null';
        $data->admin     = generate_email_signoff();
        $data->resetminutes = $pwresetmins;

        $messagehtml = get_string('emailresetconfirmation', '', $data);
        $message = html_to_text($messagehtml);
        $subject = '(M4)' . get_string('emailresetconfirmationsubject', '', format_string($site->fullname));

        if ($modetext) {
            $user->mailformat = 0;
        } else {
            $user->mailformat = 1;
        }

        // Directly email rather than using the messaging system to ensure its not routed to a popup or jabber.
        return email_to_user($user, $supportuser, $subject, $message, $messagehtml);

    }

    static public function send_confirmation_email($user, $modetext=false) {
        global $CFG;

        $site = get_site();
        $supportuser = core_user::get_support_user();

        $data = new stdClass();
        $data->firstname = fullname($user);
        $data->sitename  = format_string($site->fullname);
        $data->admin     = generate_email_signoff();

        $subject = '(M5)' . get_string('emailconfirmationsubject', '', format_string($site->fullname));

        $username = urlencode($user->username);
        $username = str_replace('.', '%2E', $username); // Prevent problems with trailing dots.
        $data->link  = $CFG->wwwroot .'/login/confirm.php?data='. $user->secret .'/'. $username;
        $messagehtml     = get_string('emailconfirmation', '', $data);
        $message = html_to_text(get_string('emailconfirmation', '', $data));

        if ($modetext) {
            $user->mailformat = 0;
        } else {
            $user->mailformat = 1;
        }

        // Directly email rather than using the messaging system to ensure its not routed to a popup or jabber.
        return email_to_user($user, $supportuser, $subject, $message, $messagehtml);
    }

    static public function email_welcome_message($instance, $user, $modetext=false) {
        global $CFG, $DB;

        $course = $DB->get_record('course', array('id' => $instance->courseid), '*', MUST_EXIST);
        $context = context_course::instance($course->id);
        $supportuser = core_user::get_support_user();

        $a = new stdClass();
        $a->coursename = format_string($course->fullname, true, array('context' => $context));
        $a->profileurl = "$CFG->wwwroot/user/view.php?id=$user->id&course=$course->id";

        if (trim($instance->customtext1) !== '') {
            $message = $instance->customtext1;
            $key = array('{$a->coursename}', '{$a->profileurl}', '{$a->fullname}', '{$a->email}');
            $value = array($a->coursename, $a->profileurl, fullname($user), $user->email);
            $message = str_replace($key, $value, $message);
            if (strpos($message, '<') === false) {
                // Plain text only.
                $messagetext = $message;
                $messagehtml = text_to_html($messagetext, null, false, true);
            } else {
                // This is most probably the tag/newline soup known as FORMAT_MOODLE.
                $messagehtml = format_text($message, FORMAT_MOODLE,
                        array('context' => $context, 'para' => false, 'newlines' => true, 'filter' => true));
                $messagetext = html_to_text($messagehtml);
            }
        } else {
            $messagehtml = get_string('welcometocoursetext', 'enrol_self', $a);
            $messagetext = html_to_text($messagehtml);
        }

        $subject = '(M6)' . get_string('welcometocourse', 'enrol_self',
                format_string($course->fullname, true, array('context' => $context)));

        if ($modetext) {
            $user->mailformat = 0;
        } else {
            $user->mailformat = 1;
        }

        // Directly emailing welcome message rather than using messaging.
        email_to_user($user, $supportuser, $subject, $messagetext, $messagehtml);
    }

    static public function email_information_message($instance, $user, $modetext=false) {
        global $CFG, $DB;

        $supportuser = core_user::get_support_user();
        $course = $DB->get_record('course', array('id' => $instance->courseid), '*', MUST_EXIST);

        $a = new stdClass();
        $a->coursename = format_string($course->fullname);
        $a->profileurl = "$CFG->wwwroot/user/view.php?id=$user->id&course=$course->id";
        $a->fullname = fullname($user);
        $a->learnmoreurl = utilities_course::get_course_findoutmore_url($instance->courseid);

        if (trim($instance->customtext1) !== '') {
            $messagehtml = $instance->customtext1;
            $messagehtml = str_replace('{$a->coursename}', $a->coursename, $message);
            $messagehtml = str_replace('{$a->profileurl}', $a->profileurl, $message);
        } else {
            $messagehtml = get_string('informationmessagetext', 'enrol_orangenextsession', $a);
        }

        $message = html_to_text($messagehtml);
        $subject = '(M7)' . get_string('informationmessage', 'enrol_orangenextsession', format_string($course->fullname));

        if ($modetext) {
            $user->mailformat = 0;
        } else {
            $user->mailformat = 1;
        }

        // Directly emailing welcome message rather than using messaging.
        email_to_user($user, $supportuser, $subject, $message, $messagehtml);
    }

    static public function send_email_deletion($user, $modetext=false) {

        $supportuser = core_user::get_support_user();
        $site = get_site();
        $message = get_config('local_eledia_makeanonymous', 'emailmsg');

        $a = new stdClass();
        $a->fullname = fullname($user);
        $a->email = $user->email;

        if (trim($message) !== '') {
            $key = array('{$a->fullname}', '{$a->email}');
            $value = array($a->fullname, $a->email);
            $message = str_replace($key, $value, $message);

            if (strpos($message, '<') === false) {
                // Plain text only.
                $messagetext = $message;
                $messagehtml = text_to_html($messagetext, null, false, true);
            } else {
                $messagehtml = format_text($message, FORMAT_MOODLE, array('para' => false, 'newlines' => true, 'filter' => true));
                $messagetext = html_to_text($messagehtml);
            }
        } else {
            $messagehtml = get_string('defaultemailmsg', 'local_eledia_makeanonymous', $a);
            $messagetext = html_to_text($messagehtml);
        }

        $subject = '(M8)' . get_config('local_eledia_makeanonymous', 'emailsubject');
        if (trim($subject) !== '') {
            $subject = '(M8)' . get_string('defaultemailsubject', 'local_eledia_makeanonymous', format_string($site->fullname));
        }

        if ($modetext) {
            $user->mailformat = 0;
        } else {
            $user->mailformat = 1;
        }

        if (!email_to_user($user, $supportuser, $subject, $messagetext, $messagehtml)) {
            mtrace('mail error : mail was not sent to '. $user->email);
        }
    }

    // Mail M9 to M13 in Forum NG plugin.
    static public function forum_delete_post($user, $modetext=false) {
        global $SITE, $USER;
        
        $supportuser = core_user::get_support_user();

        $postid = 1;
        $post = mod_forumng_post::get_from_id($postid, 0);
        $discussion = $post->get_discussion();
        $forum = $post->get_forum();
        $course = $forum->get_course();

        // Set up page
        $pagename = get_string(true ? 'deletepost' : 'undeletepost', 'forumng',
        $post->get_effective_subject(true));
        $pageparams = array('p'=>$postid);
        $url = new moodle_url('/mod/forumng/deletepost.php', $pageparams);
        $out = $discussion->init_page($url, $pagename);
        $messagepost = $post->display(true, array(mod_forumng_post::OPTION_NO_COMMANDS => true,
                mod_forumng_post::OPTION_SINGLE_POST => true));
        
        // Set up the email.
        $includepost = true;
        $user = $post->get_user();
        $from = $SITE->fullname;
        $subject = get_string('deletedforumpost', 'forumng');

        // Orange - 2016.05.12 - Add intro text
        $a = new stdClass();
        $a->fullname = fullname($user);
        $a->pseudo = $USER->username;
        $a->subject = $discussion->get_subject();
        $a->forum = $forum->get_name();
        $a->course = $course->fullname;
        $a->deleteurl = $discussion->get_moodle_url()->out(true);
        $messagehtml = get_string('deletedforumpostintro', 'forumng', $a);
        $messagehtml .= get_string('emailcontenthtml', 'forumng', $a); 
        // Always enable HTML version

        // Include the copy of the post in the email to the author.
        if ($includepost) {
            $messagehtml .= $messagepost;
            $message =  $post->display(false, array(mod_forumng_post::OPTION_NO_COMMANDS => true,
                mod_forumng_post::OPTION_SINGLE_POST => true));
        }

        if ($modetext) {
            $user->mailformat = 0;
        } else {
            $user->mailformat = 1;
        }

        // Send an email to the author of the post.
        if (!email_to_user($user, $supportuser, $subject, mail_object::get_mail($message, 'text', ''),
                mail_object::get_mail($messagehtml, 'html', ''))) {
            print_error(get_string('emailerror', 'forumng'));
        }
    }

    static public function setnew_password_and_mail($user, $modetext=false) {
        global $CFG;

        // We try to send the mail in language the user understands,
        // unfortunately the filter_string() does not support alternative langs yet
        // so multilang will not work properly for site->fullname.
        $lang = current_language();
        if ($lang != 'fr' && $lang != 'en') {
            $lang = 'fr';
        }

        $site  = get_site();

        $supportuser = core_user::get_support_user();

        $newpassword = "tobechanged";

        $a = new stdClass();
        $a->firstname   = fullname($user, true);
        $a->sitename    = format_string($site->fullname);
        $a->username    = $user->username;
        $a->newpassword = $newpassword;
        $a->link        = $CFG->wwwroot .'/login/';
        $a->signoff     = generate_email_signoff();

        $messagehtml = (string)new lang_string('newusernewpasswordtext', '', $a, $lang);
        $message = html_to_text($messagehtml);

        if ($modetext) {
            $user->mailformat = 0;
        } else {
            $user->mailformat = 1;
        }

        $subject = '(M14)' . format_string($site->fullname) .': '. (string)new lang_string('newusernewpasswordsubj', '', $a, $lang);

        // Directly email rather than using the messaging system to ensure its not routed to a popup or jabber.
        return email_to_user($user, $supportuser, $subject, $message, $messagehtml);

    }

    // Mail M15 solerni contact form.

    // Mail M16 Badge.

    static public function emailupdatemessage($user, $modetext=false) {
        global $CFG;

        $site  = get_site();

        $a = new stdClass();
        $a->url = $CFG->wwwroot . '/user/emailupdate.php?key=' . 'dummy' . '&id=' . $user->id;
        $a->site = format_string($site->fullname, true, array('context' => context_course::instance(SITEID)));
        $a->fullname = fullname($user, true);

        $emailupdatemessage = get_string('emailupdatemessage', 'auth', $a);
        $emailupdatetitle = '(M17)' . get_string('emailupdatetitle', 'auth', $a);

        if ($modetext) {
            $user->mailformat = 0;
        } else {
            $user->mailformat = 1;
        }

        // Email confirmation directly rather than using messaging so they will definitely get an email.
        $supportuser = core_user::get_support_user();

        return email_to_user($user, $supportuser, $emailupdatetitle, html_to_text($emailupdatemessage), $emailupdatemessage);
    }
}