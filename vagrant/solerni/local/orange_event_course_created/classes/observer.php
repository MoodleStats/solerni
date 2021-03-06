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
 * @package    block_orange_local
 * @subpackage orange_event_course_created
 * @copyright  2016 Orange
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
        $contact = core_user::get_support_user();
        $user= $DB->get_record('user', array('id' => $event->userid));
        // values usefull for call UsersManager.addUser method.
        $course = $DB->get_record('course', array('id' => $event->courseid));
        $category = $DB->get_record('course_categories', array('id' => $course->category));
        
        $url = $CFG->piwik_internal_url;
        $module = 'module=API';
        $method = '&method=UsersManager.addUser';
        $userpiwik = '&userLogin='.$course->shortname;
        $logindashboard = '&login='.$course->shortname;
        $pass = substr(md5($userpiwik),0,8);  
        $password = '&password='.$pass;
        $email = '&email='.$course->shortname.'@yopmail.com';
        $tokenauth = '&token_auth='.$CFG->piwik_token_admin;
        // values usefull for call UsersManager.setUserAccess method.
        $methodaccessuser = '&method=UsersManager.setUserAccess';
        $access = '&access=view';
        $methoddashboarduser = '&method=Dashboard.addDashboards';
        $namedashboard = '&name=Dashboard of '.$course->shortname;
        //$layout = '&layout={"config":{"layout":"33-33-33"},"columns":[[{"uniqueId":"widgetVisitsSummarygetEvolutionGraphcolumnsArray","parameters":{"module":"VisitsSummary","action":"getEvolutionGraph","columns":["nb_visits","nb_uniq_visitors","nb_users"],"widget":1,"columns_to_display":["nb_visits","nb_uniq_visitors","nb_users"],"rows":[],"rows_to_display":[],"isFooterExpandedInDashboard":true,"evolution_day_last_n":30},"isHidden":false},{"uniqueId":"widgetLivewidget","parameters":{"module":"Live","action":"widget","widget":1},"isHidden":false},{"uniqueId":"widgetVisitorInterestgetNumberOfVisitsPerVisitDuration","parameters":{"module":"VisitorInterest","action":"getNumberOfVisitsPerVisitDuration","widget":1},"isHidden":false}],[{"uniqueId":"widgetReferrersgetWebsites","parameters":{"module":"Referrers","action":"getWebsites","widget":1},"isHidden":false},{"uniqueId":"widgetVisitTimegetVisitInformationPerServerTime","parameters":{"module":"VisitTime","action":"getVisitInformationPerServerTime","widget":1},"isHidden":false}],[{"uniqueId":"widgetUserCountryMapvisitorMap","parameters":{"module":"UserCountryMap","action":"visitorMap","widget":1},"isHidden":false},{"uniqueId":"widgetDevicesDetectiongetBrowsers","parameters":{"module":"DevicesDetection","action":"getBrowsers","widget":1},"isHidden":false},{"uniqueId":"widgetReferrersgetSearchEngines","parameters":{"module":"Referrers","action":"getSearchEngines","widget":1},"isHidden":false}]]}';
        $layout = '&layout={"config":{"layout":"33-33-33"},"columns":[[{"uniqueId":"widgetVisitsSummarygetSparklines","parameters":{"module":"VisitsSummary","action":"getSparklines","widget":1},"isHidden":false},{"uniqueId":"widgetActionsgetPageUrls","parameters":{"module":"Actions","action":"getPageUrls","widget":1},"isHidden":false},{"uniqueId":"widgetActionsgetEntryPageUrls","parameters":{"module":"Actions","action":"getEntryPageUrls","widget":1},"isHidden":false},{"uniqueId":"widgetActionsgetExitPageUrls","parameters":{"module":"Actions","action":"getExitPageUrls","widget":1},"isHidden":false},{"uniqueId":"widgetActionsgetOutlinks","parameters":{"module":"Actions","action":"getOutlinks","widget":1},"isHidden":false}],[{"uniqueId":"widgetVisitsSummarygetEvolutionGraphcolumnsArray","parameters":{"module":"VisitsSummary","action":"getEvolutionGraph","columns":["nb_visits","nb_uniq_visitors","nb_users","nb_actions_per_visit","nb_pageviews"],"widget":1,"columns_to_display":["nb_visits","nb_uniq_visitors","nb_users","nb_actions_per_visit","nb_pageviews"],"rows":[],"rows_to_display":[],"isFooterExpandedInDashboard":true,"evolution_day_last_n":30},"isHidden":false},{"uniqueId":"widgetReferrersgetReferrerType","parameters":{"module":"Referrers","action":"getReferrerType","widget":1,"isFooterExpandedInDashboard":true,"viewDataTable":"tableAllColumns"},"isHidden":false},{"uniqueId":"widgetVisitTimegetVisitInformationPerServerTime","parameters":{"module":"VisitTime","action":"getVisitInformationPerServerTime","widget":1},"isHidden":false},{"uniqueId":"widgetVisitorInterestgetNumberOfVisitsPerPage","parameters":{"module":"VisitorInterest","action":"getNumberOfVisitsPerPage","widget":1,"isFooterExpandedInDashboard":true,"viewDataTable":"graphVerticalBar"},"isHidden":false},{"uniqueId":"widgetVisitorInterestgetNumberOfVisitsPerVisitDuration","parameters":{"module":"VisitorInterest","action":"getNumberOfVisitsPerVisitDuration","widget":1,"isFooterExpandedInDashboard":true,"viewDataTable":"graphVerticalBar"},"isHidden":false},{"uniqueId":"widgetDevicesDetectiongetType","parameters":{"module":"DevicesDetection","action":"getType","widget":1},"isHidden":false}],[{"uniqueId":"widgetUserCountryMapvisitorMap","parameters":{"module":"UserCountryMap","action":"visitorMap","widget":1},"isHidden":false},{"uniqueId":"widgetDevicesDetectiongetBrowsers","parameters":{"module":"DevicesDetection","action":"getBrowsers","widget":1,"isFooterExpandedInDashboard":true,"viewDataTable":"tableAllColumns"},"isHidden":false},{"uniqueId":"widgetResolutiongetResolution","parameters":{"module":"Resolution","action":"getResolution","widget":1},"isHidden":false},{"uniqueId":"widgetLivewidget","parameters":{"module":"Live","action":"widget","widget":1},"isHidden":false}]]}';

        // values usefull for call addSite.
        $methodaddsite ='&method=SitesManager.addSite';
        $sitename ='&siteName='.$course->shortname;
        $urls = '&urls='.$CFG->wwwroot;
        $ecommerce ='&ecommerce=0';
        $sitesearch ='&siteSearch=1';
        $timezone ='&timezone=Europe/Paris';
        $currency ='&amp;currency=USD';
        $currentdate = date('m/d/Y');
        $startDate = '&startDate='.$currentdate;
        $keepurlfragments = '&keepURLFragments=0';
        $type = '&type=website';
        $excludeUnknowurls = '&excludeUnknowUrls=0';
        // url calling piwik API for add site.
        $urladdsite = $url.'?'.$module.$methodaddsite.$sitename.$urls.$ecommerce.$sitesearch.$timezone.$currency.$startDate.$keepurlfragments.$type.$excludeUnknowurls.$tokenauth;
        // We call the API PIWIK in order to create a id site piwik.
        // debugging('urladdsite: '.$urladdsite, DEBUG_DEVELOPER);
        $xmladdsite = xml_from_piwik($urladdsite);
        // We retreive the id site from piwik.
        $methodgetsite = '&method=SitesManager.getAllSitesId';
        $urlgetsites = $url.'?'.$module.$methodgetsite.$tokenauth;
        $xmlgetsite = xml_from_piwik($urlgetsites);
        $arraysiteid = (array)$xmlgetsite->row;
        $lastsiteid = array_pop($arraysiteid);
        // We feed piwik_site table.
        $site =new stdClass();
        $site->piwik_siteid = $lastsiteid;
        $site->courseid = $event->courseid;
        $lastinsertid = $DB->insert_record('piwik_site', $site, false);
        // We retreive idsite from piwik_site table.
        $idsite = $DB->get_record_sql('SELECT piwik_siteid FROM {piwik_site} WHERE courseid = ?', array($event->courseid));
        $piwiksiteid = '&idSites='.$idsite->piwik_siteid;
        // We call again API Piwik in order to create an account with an access and dashboard
        $urlaccount = $url.'?'.$module.$method.$userpiwik.$password.$email.$tokenauth;
        $urluseraccess = $url.'?'.$module.$methodaccessuser.$userpiwik.$access.$piwiksiteid.$tokenauth;
        $urluserdashboard = $url.'?'.$module.$methoddashboarduser.$logindashboard.$namedashboard.$layout.$tokenauth;
        $urlaccessformarket = $url.'?'.$module.$methodaccessuser.'&userLogin=market'.$access.$piwiksiteid.$tokenauth;
        // debugging('urlaccount: '.$urlaccount, DEBUG_DEVELOPER);
        // debugging('urluserdashboard: '.$urluserdashboard, DEBUG_DEVELOPER);
        // debugging('urluseraccess: '.$urluseraccess, DEBUG_DEVELOPER);
        // debugging('urlaccount: '.$urlaccount, DEBUG_DEVELOPER);
        $xmlaccount = xml_from_piwik($urlaccount);
        $xmlaccess = xml_from_piwik($urluseraccess);
        $xmldashboard = xml_from_piwik($urluserdashboard);
        $xmlaccessmarket = xml_from_piwik($urlaccessformarket);
        
        // We test xml Piwik responses to kwow if siteid and user are correctly created and send mail.
        $return = sendmail_to_admin_piwik($course,$event,$pass,$xmlaccount,$xmlaccess,$xmldashboard,$xmlaccessmarket);
    }
}
