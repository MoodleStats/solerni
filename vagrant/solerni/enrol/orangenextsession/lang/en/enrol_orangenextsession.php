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
$string['enrolme'] = 'Enrol me';
 $string['pluginname'] = 'Enrol for next session';
 $string['pluginname_desc'] = 'The NextSession enrolment plugin allows users to indicates that they are interesting to follow next session of this course.';
$string['role'] = 'Assign role';
$string['waitlist:config'] = 'Configure waitlist enrol instances';
$string['waitlist:manage'] = 'Manage enrolled users';
$string['waitlist:unenrol'] = 'Unenrol users from course';
$string['waitlist:unenrolwaitlist'] = 'Unenrol waitlist from the course';
 $string['sendconfirmationmessage'] = 'Send confirmation message';
 $string['sendconfirmationmessage_help'] = 'If enabled, users will receive a confirmation email of his inscription on the list for next session.';
$string['showhint'] = 'Show hint';
$string['showhint_desc'] = 'Show first letter of the guest access key.';
 $string['status'] = 'Allow OrangeNextSession enrolments';
 $string['status_desc'] = 'Allow to activate by default the OrangeNextSession enrolment.';
$string['status_help'] = 'This setting determines whether a user can enrol (and also unenrol if they have the appropriate permission) themselves from the course.';
$string['unenrolwaitlistconfirm'] = 'Do you really want to unenrol "{$a}"?';
$string['welcometocourse'] = 'Welcome to {$a}';
$string['welcometocoursetext'] = 'Welcome to {$a->coursename}!

If you have not done so already, you should edit your profile page so that we can learn more about you:

  {$a->profileurl}';
$string['confirmation'] = 'If you proceed you will be enrolled to this course.<br><br>Are you absolutely sure you want to do this?';
$string['confirmationfull'] = '<strong>This course is presently booked.</strong> If you proceed you will be placed on a waiting list and will be enrolled automatically and informed by email in case enough spaces becomes available.<br>';
$string['confirmation_yes'] = 'Yes';
$string['confirmation_no'] = 'No';
$string['waitlistinfo'] = '<b>This course is presently booked</b>. <br/><br/>Thank you for your application request. You have been placed on a waiting list and will be informed via email in case a space becomes available.';
$string['waitlist:unenrolself'] = 'Unenrol self from the course';
$string['lineconfirm'] = '<br>Are you absolutely sure you want to do this?';
$string['confirmation_cancel'] = 'Cancel';
$string['enrolusers'] = 'Enrol users';

$string['nextsessionnotavailable'] = 'An error occurs while recording your request. This feature is not enabled.';
$string['exportuserlist'] = 'Export users in CSV files';