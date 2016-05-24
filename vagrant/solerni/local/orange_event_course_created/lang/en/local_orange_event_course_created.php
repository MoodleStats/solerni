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

$string['pluginname'] = 'Orange Event course_created';
$string['content_piwik_success'] = '<p>Hello <strong>{$a->firstname} {$a->lastname}</strong>,</p>
<p>The creation of new course \'{$a->coursename}\' on platform {$a->sitename} has generated automatically a new account on Piwik, our web analytics platform.</p><br/>
<p>Please find below your Piwik login details:</p>
<ul>
   <li>user name: {$a->userpiwik}</li>
   <li>password: {$a->passwordpiwik}</li>
</ul>
<br/>
<p><i>Please note: This password can be changed at any time on Piwik by the new account.</i></p>';
$string['content_piwik_fail'] = '<p>Hello <strong>{$a->firstname} {$a->lastname}</strong>,</p>
<p>Sorry but a technical problem prevented the automatic creation of your account access to web data MOOC \'{$a->coursename}\'on the Piwik platform.</p><br/>
<p>Please contact our support at {$a->emailcontact} to finish creating your account.</p>';
$string['subject_piwik_success'] = '{$a->coursename}: Creation of your Piwik account';
$string['subject_piwik_fail'] = '{$a->coursename}: Failed to create your account on Piwik';
