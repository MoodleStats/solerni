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
 * Adds new instance of enrol_orangeinvitation to specified course
 * or edits current instance.
 *
 * @package    enrol
 * @subpackage orangenextsession
 * @copyright  Orange 2015 based on Waitlist Enrol plugin / emeneo.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['customconfirmationemessage'] = 'Custom confirmation message (in HTML)';
$string['pluginname'] = 'Enrol for next session';
$string['pluginname_desc'] = 'The NextSession enrolment plugin allows users to indicates that they are interesting to follow next session of this course.';
$string['orangenextsession:config'] = 'Configure OrangeNextSession enrol instances';
$string['sendconfirmationmessage'] = 'Send confirmation message';
$string['sendconfirmationmessage_help'] = 'If enabled, users will receive a confirmation email of his inscription on the list for next session.';
$string['status'] = 'Allow OrangeNextSession enrolments';
$string['status_desc'] = 'Allow to activate by default the OrangeNextSession enrolment.';
$srting['custominformationmessage'] = 'Custom information mail';
$string['informationmessage'] = 'INscription on the waiting list for {$a}';
$string['informationmessagetext'] = 'Hello

Thanks for your interest for the courss {$a->coursename}. You will be informed when the new session will start.
';
$string['orangenextsessioninfo'] = '<b>This course is presently booked</b>. <br/>Thank you for your application request. You will be informed via email when a new session will start.';
$string['nextsessionnotavailable'] = 'An error occurs while recording your request.';
$string['exportuserlist'] = 'Export users in CSV files';
$string['alreadyenrolled'] = 'You are already enrolled for this course';
$string['alreadyinlist'] = 'You are already on the list to be informed of next session.';