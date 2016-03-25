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
 * Strings for component 'descriptionpage', language 'en', branch 'MOODLE_20_STABLE'
 *
 * @package mod
 * @subpackage orange libary
 * @copyright  2015 Orange based on mod_page plugin from 2009 Petr Skoda (http://skodak.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname']           = 'Orange Library';
$string['local_orange_library'] = 'Orange Library';

// Subscription button object.
$string['subscribe_to_mooc']    = 'Subscription';
$string['access_to_mooc']       = 'Access to the mooc';
$string['status_default']       = 'In coming';
$string['status_running']       = 'MOOC running';
$string['status_closed']        = 'MOOC closed';
$string['alert_mooc']           = 'Alert me for next MOOC session';
$string['registration_closed']  = 'Registration stopped';
$string['registration_open']    = 'Registration open';
$string['registration_not_open']    = 'Registration not open';
$string['mooc_complete']        = 'Mooc complete';
$string['mooc_open_date']       = 'Available on {$a}';
$string['acces_to_archive']     = 'Access to course archive';
$string['enrolled_users']       = 'enrolled users';
$string['unsubscribe']          = 'unsubscribe';
$string['new_session']          = 'new_session';

// Extended course object.
$string['english']              = 'English';
$string['french']               = 'French';
$string['duration_default']     = 'Less than four weeks';
$string['workingtime_default']  = 'Less than one hour';
$string['prerequesites_default'] = 'No prerequisites';
$string['subtitle']             = ' subtitles';
$string['subtitle_default']     = 'subtitles';
$string['teachingteam_default'] = 'Conception : Orange with Learning CRM';

// Badges.
$string['certification']        = 'Certificate of achievement';
$string['certification_default'] = 'No certificate available';
$string['badges']               = 'Badges';
$string['badge_default']        = 'No badge available';
$string['badge']                = 'Badge ';

// Exception.
$string['missing_course_in_construct'] = 'You tried to instanciante a subscription_button_object without passing a $course object';

$string['price']                = 'price: ';
$string['price_help']           = 'price_help';
$string['price_default']        = 'Free mooc';
$string['price_case1']          = 'Free mooc';
$string['price_case2']          = 'free mooc<br>certification in option';
$string['price_case3']          = 'professional teaching';

$string['coursereplay']         = 'After closed';
$string['coursereplay_help']    = 'Choose the action';
$string['replay']               = 'Replay';
$string['notreplay']            = 'Don\'t replay';

// Configuration check.
$string['configuration_error']  = 'Configuration errors for this course:';
$string['enrolmentmethodmissing'] = 'Enrolment method "{$a}" missing.';
$string['enrolmentmethoddisabled'] = 'Enrolment method "{$a}" should be enabled.';
$string['moddescriptionpagemissing'] = '"{$a}" page missing.';
$string['moddescriptionpagemultiple'] = 'More than one "{$a}" page found.';
$string['blockmissing'] = 'Block "{$a}" missing.';
$string['startenrolmentdatemissing'] = "The enrolment start date is missing on Self Enrol method";
$string['endenrolmentdatemissing'] = "The enrolment end date is missing on Self Enrol method";
$string['orangeinvitationconfigmissing'] = "The configuration of 'MOOC URLs access' enrolment method need to be save once";

$string['today'] = "tda, ";
$string['yesterday'] = "yda, ";