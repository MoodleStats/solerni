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
 * @package    blocks
 * @subpackage course_extended
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


$string['course_extended:addinstance'] = 'Add a new course contents block';
$string['course_extended:myaddinstance'] = 'Add a new course contents block to the My Moodle page';
$string['course_extended'] = 'Course extended contents';
$string['defaulttitle'] = 'Course extended contents';

$string['headerconfig'] = 'headerconfig';
$string['descconfig'] = 'descconfig';
$string['labelallowhtml'] = 'labelallowhtml';
$string['descallowhtml'] = 'descallowhtml';
$string['descallow'] = 'descallow';
$string['title'] = 'Extended Course';
$string['current'] = 'current';
$string['startingsoon'] = 'startingsoon';
$string['closed'] = 'closed';
$string['picture'] = 'picture';
$string['true'] = 'true';
$string['false'] = 'false';
$string['in_four_weeks'] = 'in_four_weeks';
$string['four_six_weeks'] = 'four_six_weeks';
$string['sup_six_weeks'] = 'sup_six_weeks';

$string['inserterror'] = 'insert error';

$string['notinserterror'] = 'not insert error';

$string['invalidcourse'] = 'Course not defined';
$string['addpage'] = 'addpage';
$string['editpage'] = 'editpage';
$string['course_extended_settings'] = 'settings';

$string['maxvisibility'] = 'Maximum visibility';
$string['maxvisibility_help'] = '
<p><em>On a personal blog:</em> <strong>Visible only to the blog owner (private)</strong> &ndash;
nobody* else can see this post.</p>
<p><em>On a course blog:</em> <strong>Visible to participants on this course</strong> &ndash; to view the post you must
have been granted access to the blog, usually by being enrolled on the course that contains it.</p>

<p><strong>Visible to everyone who is logged in to the system</strong> &ndash; everyone who is
logged in can view the post, even if they\'re not enrolled on a specific course.</p>
<p><strong>Visible to anyone in the world</strong> &ndash; any Internet user can see this post
if you give them the blog\'s address.</p>

<p>This option exists on the whole blog as well as on individual posts. If the
option is set on the whole blog, that becomes a maximum. For example, if
the whole blog is set to the first level, you cannot change the
level of an individual post at all.</p>';
$string['visiblecourseusers'] = 'Visible to participants on this course';
$string['visibleloggedinusers'] = 'Visible to everyone who is logged in to the system';
$string['visiblepublic'] = 'Visible to anyone in the world';

$string['coursestatus'] = 'coursestatus';
$string['coursestatus_default'] = 'coursestatus_default';
$string['coursestatus_help'] = 'coursestatus_help';

$string['pagetitle'] = 'pagetitle';
$string['pagetitle_default'] = 'Extended Course';
$string['pagetitle_help'] = 'Extended Course';
$string['displayedhtml'] = 'displayedhtml';
$string['picturefields'] = 'picturefields';
$string['displaypicture'] = 'displaypicture';
$string['pictureselect'] = 'pictureselect';
$string['picturedesc'] = 'picturedesc';
$string['picture_help'] = 'picture_help';
$string['inf_one'] = 'inf_one';
$string['one_two'] = 'one_two';
$string['two_three'] = 'two_three';
$string['badge'] = 'Badge';
$string['status'] = 'status';
$string['status_help'] = 'status_help';
$string['status_default'] = 'MOOC not started ';


$string['filetitle'] = 'Course image';
$string['userfile_default'] = 'undefined';

$string['blocktitle'] = 'Extended Course';
$string['blocktitle_default'] = 'Extended Course';
$string['title_help'] = 'Leave this field empty to use the default block title. If you define a title here, it will be used instead of the default one.';
$string['enumerate'] = 'Enumerate section titles';
$string['enumerate_label'] = 'If enabled, the section number is displayed before the section title';
$string['notusingsections'] = 'This course format does not use sections.';
$string['pluginname'] = 'Extended Course';
$string['basics_title'] = 'Extended Course';


$string['startdate'] = 'start date: ';
$string['enddate'] = 'end date: ';
$string['enddate_default'] = "0";
$string['enddate_help'] = 'enddate_help ';



$string['duration'] = 'duration: ';
$string['duration_help'] = 'duration_help ';
$string['duration_default'] = 'in_four_weeks ';


$string['workingtime'] = 'working time per day: ';
$string['workingtime_help'] = 'working time per day_help ';
$string['workingtime_default'] = 'inf_one';

$string['price'] = 'price: ';
$string['price_help'] = 'price_help';
$string['price_default'] = 'Free MOOC';

$string['certification'] = 'Certification';
$string['certification_default'] = 'No Certification';
$string['certification_help'] = 'No Certification';

$string['language'] = 'Language: ';
$string['language_default'] = 'No language';

$string['video'] = 'Video: ';
$string['video_help'] = 'Video_help';
$string['video_default'] = 0;

$string['registration'] = 'registration: ';
$string['registration_default'] = 'registration';
$string['registration_startdate'] = 'registration start date: ';
$string['registration_enddate'] = 'registration end date: ';
$string['registration_startdate_default'] = 'registration start date_default';
$string['registration_enddate_default'] = 'registration end date_default';
$string['registration_startdate_help'] = 'registration start date_help';
$string['registration_enddate_help'] = 'registration end date_help ';

$string['registeredusers'] = 'registeredusers: ';
$string['registeredusers_help'] = 'registeredusers_help';
$string['registeredusers_default'] = 'no registered users';
$string['moocstatus_default'] = 'MOOC not started';

$string['prerequesites'] = 'Prerequisites';
$string['prerequesites_help'] = 'Prerequisites_help';
$string['prerequesites_default'] = 'No Prerequisites';

$string['teachingteam'] = 'Teaching team';
$string['teachingteam_help'] = 'Teaching team_help';
$string['teachingteam_default'] = 'Conception : Orange with Learning CRM';