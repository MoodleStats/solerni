<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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

function sendmail_to_admin_piwik($course,$event,$pass,$xmlaccount,$xmlaccess,$xmlsegment,$xmllogin) {
    global $CFG, $DB;
    $site = get_site();
    $contact = core_user::get_support_user();
    $user = $DB->get_record('user', array('id' => $event->userid));
    $xmlsegment = intval($xmlsegment);
    $xmllogin = intval($xmllogin);
    $srtsuccess = 'ok';
    $userpiwik = $course->shortname;
    if (($xmlaccount->success['message'] == $srtsuccess) && ($xmlaccess->success['message'] == $srtsuccess) && is_int($xmlsegment) == true && is_int($xmllogin) == true ) {
        $message = get_string('content_piwik_success', 'local_orange_event_course_created');
        $key = array('{$a->username}', '{$a->coursename}', '{$a->sitename}', '{$a->userpiwik}', '{$a->passwordpiwik}');
        $value = array($user->username, $course->fullname, $site->fullname, $userpiwik, $pass);
        $message = str_replace($key, $value, $message);
        $subject = get_string('subject_piwik_success', 'local_orange_event_course_created');
        $subject = str_replace('{$a->sitename}', format_string($site->fullname), $subject);
        email_to_user($user, $contact, $subject, mail_object::get_mail($message, 'text', ''), mail_object::get_mail($message, 'html', ''));
        return true;
    } 
    $message = get_string('content_piwik_fail', 'local_orange_event_course_created');
    $subject = get_string('subject_piwik_fail', 'local_orange_event_course_created');
    email_to_user($user, $contact, $subject, mail_object::get_mail($message, 'text', ''), mail_object::get_mail($message, 'html', ''));
        return false;
 }


 