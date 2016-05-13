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
 * @package    block_orange_local
 * @subpackage orange_event_course_created
 * @copyright  2016 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function xml_from_piwik($url) {   
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $response = curl_exec($ch);
  curl_close($ch);
  if ($response === false) {
      return false;
  }
  $xmlresponse = new SimpleXMLElement($response);
  return ($xmlresponse);
}

function sendmail_to_admin_piwik($course,$event,$pass,$xmlaccount,$xmlaccess,$xmldashboard) {
    global $CFG, $DB;
    $site = get_site();
    $contact = core_user::get_support_user();
    $user = $DB->get_record('user', array('id' => $event->userid));
    $srtsuccess = 'ok';
    $userpiwik = $course->shortname;
    $xmldashboard = intval($xmldashboard);
    $key = array('{$a->username}', '{$a->coursename}', '{$a->sitename}', '{$a->userpiwik}', '{$a->passwordpiwik}','{$a->emailcontact}', '{$a->firstname}','{$a->lastname}');
    $value = array($user->username, $course->fullname, $site->fullname, $userpiwik, $pass,$CFG->supportemail,$user->firstname,$user->lastname);
    if (($xmlaccount->success['message'] == $srtsuccess) && ($xmlaccess->success['message'] == $srtsuccess) && (is_int($xmldashboard) == true)) {
        $message = get_string('content_piwik_success', 'local_orange_event_course_created');
        $message = str_replace($key, $value, $message);
        $subject = get_string('subject_piwik_success', 'local_orange_event_course_created');
        $subject = str_replace($key, $value, $subject);
        email_to_user($user, $contact, $subject, mail_object::get_mail($message, 'text', ''), mail_object::get_mail($message, 'html', ''));
        return true;
    } 
    $message = get_string('content_piwik_fail', 'local_orange_event_course_created');
    $subject = get_string('subject_piwik_fail', 'local_orange_event_course_created');
    email_to_user($user, $contact, $subject, mail_object::get_mail($message, 'text', ''), mail_object::get_mail($message, 'html', ''));
        return false;
 }


 