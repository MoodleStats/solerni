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
 * @subpackage contact
 * @copyright  Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../config.php');
require_once($CFG->dirroot . '/contact/forms/contact_form.php');
use local_orange_library\utilities\utilities_course;

redirect_if_major_upgrade_required();

const CONTACT_REQUEST_PB_ID         = -1;
const CONTACT_REQUEST_PARTNER_ID    = -2;
const CONTACT_REQUEST_COMMERCIAL_ID = -3;
const CONTACT_REQUEST_OTHER_ID      = -4;

// Attention : email hardcoded.
$contacts = array();
$contacts[CONTACT_REQUEST_PB_ID] = array ('libel' => get_string('contact_request_pb', 'theme_halloween'),
    'mail' => 'support-solerni@dev.orangeadd.com');
$contacts[CONTACT_REQUEST_PARTNER_ID] = array ('libel' => get_string('contact_request_partner', 'theme_halloween'),
    'mail' => 'partners-solerni@dev.orangeadd.com');
$contacts[CONTACT_REQUEST_COMMERCIAL_ID] = array ('libel' => get_string('contact_request_commercial', 'theme_halloween'),
    'mail' => 'marketing-solerni@dev.orangeadd.com');
$contacts[CONTACT_REQUEST_OTHER_ID] = array ('libel' => get_string('contact_request_other', 'theme_halloween'),
    'mail' => 'contact-solerni@dev.orangeadd.com');


$PAGE->set_context(context_system::instance());
$PAGE->set_url('/contact/index.php');
$PAGE->set_pagelayout('base');
$PAGE->blocks->add_region('side-pre');
$PAGE->set_title($SITE->shortname . ' : ' . get_string('contact_page_title', 'theme_halloween'));
$USER->editing = false;

$courserenderer = $PAGE->get_renderer('core', 'course');

function send_email($data, $contacts) {
    global $DB, $USER, $CFG, $SITE;

    if ($data->requestid > 0) {
        if ($foundcourse = $DB->get_record('course', array('id' => $data->requestid))) {
            if (!empty($foundcourse)) {
                $courseinfos = utilities_course::solerni_get_course_infos($foundcourse);

                if (isset($courseinfos->contactemail) && ($courseinfos->contactemail != "")) {
                    $tomail = $courseinfos->contactemail;
                } else {
                    $tomail = $contacts[CONTACT_REQUEST_OTHER_ID]['mail'];
                }
                $requestname = $foundcourse->fullname;
            }
        }
    } else {
        $tomail = $contacts[$data->requestid]['mail'];
        $requestname = $contacts[$data->requestid]['libel'];
    }

    $supportuser = core_user::get_support_user();

    $mail = get_mailer();
    $messagetext = sprintf(get_string('contact_email_body', 'theme_halloween'), $SITE->fullname) . '\n';
    $messagetext .= get_string('contact_request_type', 'theme_halloween') . " : " . $requestname . '\n';
    if ($data->civilityid == 1) {
        $messagetext .= get_string('contact_civility', 'theme_halloween') . " : " .
                get_string('contact_civility_mr', 'theme_halloween') . '\n';
    } else if ($data->civilityid == 2) {
        $messagetext .= get_string('contact_civility', 'theme_halloween') . " : " .
                get_string('contact_civility_mrs', 'theme_halloween') . '\n';
    }
    $messagetext .= get_string('contact_firstname', 'theme_halloween') . " : " . $data->firstname. '\n';
    $messagetext .= get_string('contact_lastname', 'theme_halloween') . " : " . $data->lastname. '\n';
    $messagetext .= get_string('contact_email', 'theme_halloween') . " : " . $data->email. '\n';
    if (!$CFG->solerni_isprivate) {
        $messagetext .= get_string('contact_company', 'theme_halloween') . " : " . $data->company. '\n';
        $messagetext .= get_string('contact_phone', 'theme_halloween') . " : " . $data->phone. '\n';
        $messagetext .= get_string('contact_jobtitle', 'theme_halloween') . " : " . $data->jobtitle. '\n';
    }
    $messagetext .= get_string('contact_question', 'theme_halloween') . " : " . $data->question. '\n';

    $messagehtml  = "<html><body>";
    $messagehtml .= "<p>" . sprintf(get_string('contact_email_body', 'theme_halloween'), $SITE->fullname). "</p>";
    $messagehtml .= "<p>" .get_string('contact_request_type', 'theme_halloween') . " : " . $requestname. "</p>";
    if ($data->civilityid == 1) {
        $messagehtml .= "<p>" .get_string('contact_civility', 'theme_halloween') . " : " .
                get_string('contact_civility_mr', 'theme_halloween') . "</p>";
    } else if ($data->civilityid == 2) {
        $messagehtml .= "<p>" .get_string('contact_civility', 'theme_halloween') . " : " .
                get_string('contact_civility_mrs', 'theme_halloween') . "</p>";
    }
    $messagehtml .= "<p>" .get_string('contact_firstname', 'theme_halloween') . " : " . $data->firstname. "</p>";
    $messagehtml .= "<p>" .get_string('contact_lastname', 'theme_halloween') . " : " . $data->lastname. "</p>";
    $messagehtml .= "<p>" .get_string('contact_email', 'theme_halloween') . " : " . $data->email. "</p>";
    if (!$CFG->solerni_isprivate) {
        $messagehtml .= "<p>" .get_string('contact_company', 'theme_halloween') . " : " . $data->company. "</p>";
        $messagehtml .= "<p>" .get_string('contact_phone', 'theme_halloween') . " : " . $data->phone. "</p>";
        $messagehtml .= "<p>" .get_string('contact_jobtitle', 'theme_halloween') . " : " . $data->jobtitle. "</p>";
    }
    $messagehtml .= "<p>" .get_string('contact_question', 'theme_halloween') . " : " . $data->question . "</p>";
    $messagehtml .= "</body></html>";

    if (!empty($mail->SMTPDebug)) {
        echo '<pre>' . "\n";
    }
    $mail->Sender = $supportuser->email;
    $mail->From     = $supportuser->email;
    $mail->FromName = fullname($supportuser, true);
    $mail->Subject = get_string('contact_email_subject', 'theme_halloween');
    $mail->addAddress($tomail);
    $mail->isHTML(true);
    $mail->Encoding = 'quoted-printable';
    $mail->Body = $messagehtml;
    $mail->AltBody = "\n$messagetext\n";
    if ($mail->send()) {
        if (!empty($mail->SMTPDebug)) {
            echo '</pre>';
        }
        return true;
    } else {
        if (!empty($mail->SMTPDebug)) {
            echo '</pre>';
        }
        return false;
    }
}

$mform = new contact_form();

if ($mform->is_cancelled()) {
    $returnurl = new moodle_url('contact/index.php', array('sesskey' => sesskey()));
    redirect($returnurl);
} else if ($fromform = $mform->get_data()) {
    echo $OUTPUT->header();
    // Send email.
    if (send_email($fromform, $contacts)) {
        echo $OUTPUT->notification(get_string('contact_email_sent', 'theme_halloween'), 'notifysuccess');
    } else {
        echo $OUTPUT->notification(get_string('contact_email_notsent', 'theme_halloween'), 'notifyproblem');
    }
    echo $OUTPUT->heading(get_string('contact_us', 'theme_halloween'));
    $mform->display();
    echo $OUTPUT->footer();
} else {
    // Display Form.
    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('contact_us', 'theme_halloween'));
    $mform->display();
    echo $OUTPUT->footer();
}

