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
 * Lang strings.
 * @package mod
 * @subpackage forumng
 * @copyright 2011 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['digestmailsubject'] = '{$a}: forum daily digest';
$string['deletedforumpost'] = 'Forum post deleted';
$string['emailcontentplain'] = 'This is a notification to advise you that your forum post with the
 following details has been deleted by \'{$a->firstname} {$a->lastname}\':

Subject: {$a->subject}
Forum: {$a->forum}
Module: {$a->course}

To view the discussion visit {$a->deleteurl}';
$string['emailcontenthtml'] = '<p>This is a notification to advise you that your forum post with the
 following details has been deleted by \'{$a->pseudo}\':</p>
<p>
<span class="txt18BNoir">Subject:</span> {$a->subject}<br />
<span class="txt18BNoir">Forum:</span> {$a->forum}<br />
<span class="txt18BNoir">Course:</span> {$a->course}<br/>
</p>
<a href="{$a->deleteurl}" title="view deleted post" class="lientxt18orange">View the discussion</a>';
$string['alert_emailsubject'] = 'Forum post reported';
$string['alert_emailpreface'] = '<p>Hello,</p><p>A forum post has been reported by <span class="txt18BNoir">{$a->fullname}</span> ({$a->username},
<a href="mailto:{$a->email}" class="lientxt18orange">{$a->email}</a>)</p><p>To access the message click on the followinglink:<br/>
<a href="{$a->url}" class="lientxt18orange">{$a->url}</a></p>';
$string['alert_emailappendix'] = '<p>You are receiving this email because your email address has been used on the forum for reporting unacceptable message.</p>';
$string['alert_reasons'] = '<p>Reasons for reporting post:</p>';
$string['emaileditedcontenthtml'] = '<p>Hello,</p><p>This is a notification to advise you that your forum post with the
following details has been edited by \'{$a->pseudo}\':</p>
<p>
<span class="txt18BNoir">Subject:</span> {$a->subject}<br />
<span class="txt18BNoir">Forum:</span> {$a->forum}<br />
<span class="txt18BNoir">Module:</span> {$a->course}<br/>
</p>
<a href="{$a->editurl}" title="view deleted post" class="lientxt18orange">View the discussion</a>';


