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
 * Version details
 *
 * @package    local_orange_event_course_created
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/local/orange_mail/classes/mail_object.php');
/**
 * Event observer for block orange_ruels.
 */
class local_orange_event_course_created_observer {

    /**
     * Triggered via course_viewed event.
     *
     * @param \core\event\course_viewed $event
     */

    public static function course_created(\core\event\course_created  $event) {
        global $CFG, $DB;
        $site = get_site();
        $contact = core_user::get_support_user();
        $user = $DB->get_record('user', array('id' => $event->userid));

        if ($event->courseid != 1) {
            // Values usefull for call UsersManager.addUser method.
            $course = $DB->get_record('course', array('id' => $event->courseid));
            $category = $DB->get_record('course_categories', array('id' => $course->category));
            $url = $CFG->piwik_internal_url;             $module = 'module=API';
            $method = '&method=UsersManager.addUser';
            $userpiwik = $course->shortname;
            $password = md5($userpiwik);
            $email = '&email='.$course->shortname.'@yopmail.com'.
            $tokenauth = '&token_auth='.$CFG->piwik_token_admin;
            $urlaccount = $url.'?'.$module.$method.'&userLogin='.$userpiwik.'&password='.$password.$email.$tokenauth;
            // Values usefull for call UsersManager.setUserAccess method.
            $methodaccessuser = '&method=UsersManager.setUserAccess';
            $idsite = '&idSites=1';
            $access = '&access=view';
            $urluseraccess = $url.'?'.$module.$methodaccessuser.'&userLogin='.$userpiwik.$access.$idsite.$tokenauth;
            // Values usefull for call SegmentEditor.add method.
            $methodsegment = '&method=SegmentEditor.add';
            $name = '&name='.$course->shortname;
            $definition = '&definition=customVariablePageValue1=='.$course->fullname;
            $login = '&login='.$course->shortname;
            $idsite = '&idSite=1';
            $autoarchive = '&autoArchive=0';
            $enabledallusers = '&enabledAllUsers=0';
            $urlsegment = $url.'?'.$module.$methodsegment.$name.$definition.$idsite.$autoarchive.$enabledallusers.$tokenauth;
            $methodsegmentlogin = '&method=SegmentEditor.addwithlogin';
            $urlsegmentlogin = $url.'?'.$module.$methodsegmentlogin.$name.$definition.$login.$idsite.$autoarchive.$enabledallusers.$tokenauth;

            // We call the API PIWIK in order to create a account piwik.
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $urlaccount);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $response = curl_exec($ch);
            curl_close($ch);

            // We call the API PIWIK in order to give an access Piwik to a new account piwik.
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $urluseraccess);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $responseuseraccess = curl_exec($ch);
            curl_close($ch);

            // We call the API PIWIK in order to create a segment in piwik.
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $urlsegment);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $responsesegment = curl_exec($ch);
            curl_close($ch);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $urlsegmentlogin);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $responsesegmentlogin = curl_exec($ch);
            curl_close($ch);

           // We test XML Piwik responses to kwow if segment and user are correctly created and send mail
            $XML = new SimpleXMLElement($response);
            $XMLuseraccess = new SimpleXMLElement($responseuseraccess);
            $xmlsegment = new SimpleXMLElement($responsesegment);
            $xmlsegmentlogin = new SimpleXMLElement($responsesegmentlogin);
            $XMLsegment = intval($XMLsegment);
            $XMLsegmentlogin = intval($xmlsegmentlogin);
            $srtsuccess = 'ok';

            if (($XML->success['message'] == $srtsuccess) && ($XMLuseraccess->success['message'] == $srtsuccess) && is_int($XMLsegment) == true && is_int($XMLsegmentlogin) == true ) {
                $message = get_string('content_piwik_success', 'local_orange_event_course_created');
                $key = array('{$a->username}', '{$a->coursename}', '{$a->sitename}', '{$a->userpiwik}', '{$a->passwordpiwik}');
                $value = array($user->fullname, $course->fullname, $site->fullname, $userpiwik, $password);
                $message = str_replace($key, $value, $message);
                $subject = get_string('subject_piwik_success', 'local_orange_event_course_created');
                $subject = str_replace('{$a->sitename}', format_string($site->fullname), $subject);
                email_to_user($user, $contact, $subject, mail_object::get_mail($message, 'text', ''), mail_object::get_mail($message, 'html', ''));
                return true;
            } else {
                $message = get_string('content_piwik_fail', 'local_orange_event_course_created');
                $subject = get_string('subject_piwik_fail', 'local_orange_event_course_created');
                email_to_user($user, $contact, $subject, mail_object::get_mail($message, 'text', ''), mail_object::get_mail($message, 'html', ''));
                return false;
            }

        }
        return false;
    }
}