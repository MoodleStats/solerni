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


$string['welcome_enrolment_message_inscription'] = 'You enrol on the MOOC {$a}.';
$string['welcome_enrolment_message_notstarted'] = 'This MOOC is not started : it will start on {$a}.. We will send you a reminder few days before the MOOC start. See you soon.';
$string['welcome_enrolment_message_started'] = 'The MOOC is open : you can start now. Good MOOC !';
$string['content_piwik_fail'] = 'The creation of Solerni course  didn\'t generate a new Piwik account or Piwik segment. Please contact the manager of Solerni statistics';
$string['content_piwik_success'] = '<p>Hello <span class="txt18BNoir">{$a->username}</span>,</p>
<p>The creation of new course \'{$a->coursename}\'on platform {$a->sitename} generated automatically a new account and Segment Piwik.</p>
<p>Please find bebow Your Piwik login details :</p>
<ul>
   <li>user name : {$a->userpiwik}</li>
   <li>password  : {$a->passwordpiwik}</li>
</ul>
<p><strong>Remarque : </strong>This password can be changed at any time on Piwik by the new account</p>';
$string['subject_piwik_success'] = '{$a->sitename} - Creations of Piwik account and segment';
$string['subject_piwik_fail'] = '{$a->sitename} - Fail to create an account and/or segment on piwik';