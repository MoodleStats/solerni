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
require_once($CFG->dirroot.'/local/orange_event_course_created/lib.php');
/**
 * Event observer for block orange_ruels.
 */
class local_orange_event_course_created_observer {

    /**
     * Triggered via course_viewed event.
     *
     * @param \core\event\course_viewed $event
     */

    public static function course_created(\core\event\course_created $event) {
        
        if ($event->courseid == 1) {
            return false;
        }
        global $CFG, $DB;
        $site = get_site();
        $contact = core_user::get_support_user();
        $user = $DB->get_record('user', array('id' => $event->userid));
        // values usefull for call UsersManager.addUser method.
        $course = $DB->get_record('course', array('id' => $event->courseid));
        $category = $DB->get_record('course_categories', array('id' => $course->category));
        $url = $CFG->piwik_internal_url;             
        $module = 'module=API';
        $method = '&method=UsersManager.addUser';
        $userpiwik = $course->shortname;
        $password = md5($userpiwik);
        $email = '&email='.$course->shortname.'@yopmail.com'.
        $tokenauth = '&token_auth='.$CFG->piwik_token_admin;
        // values usefull for call UsersManager.setUserAccess method.
        $methodaccessuser = '&method=UsersManager.setUserAccess';
        $idsite = '&idSites=1';
        $access = '&access=view';
        // values usefull for call SegmentEditor.add2 method
        $methodsegment = '&method=SegmentEditor.add2';
        $name = '&name='.$course->shortname;
        $definition = '&definition=customVariablePageValue1=='.$course->fullname;
        $login = '&login='.$course->shortname;
        $idsite = '&idSites=1';
        $autoarchive = '&autoArchive=0';
        $enabledallusers = '&enabledAllUsers=0';
        $methodsegmentlogin = '&method=SegmentEditor.add2';
        // url calling piwik API
        $urlaccount = $url.'?'.$module.$method.'&userLogin='.$userpiwik.'&password='.$password.$email.$tokenauth;
        $urluseraccess = $url.'?'.$module.$methodaccessuser.'&userLogin='.$userpiwik.$access.$idsite.$tokenauth;
        $urlsegment = $url.'?'.$module.$methodsegment.$name.$definition.$idsite.$autoarchive.$enabledallusers.$tokenauth;
        $urlsegmentlogin = $url.'?'.$module.$methodsegmentlogin.$name.$definition.$idsite.$autoarchive.$enabledallusers.$login.$tokenauth;
        // We call the API PIWIK in order to create a account piwik.
        $xmlaccount = xml_from_piwik($urlaccount);
        $xmlaccess = xml_from_piwik($urluseraccess);
        $xmlsegment = xml_from_piwik($urlsegment);
        $xmllogin = xml_from_piwik($urlsegmentlogin);
        // We test xml Piwik responses to kwow if segment and user are correctly created and send mail
        $return = sendmail_to_admin_piwik($course,$event, $xmlaccount, $xmlaccess, $xmlsegment, $xmllogin);
    }
}
