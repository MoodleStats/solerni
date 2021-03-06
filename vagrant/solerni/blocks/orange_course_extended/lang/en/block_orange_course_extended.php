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

$string['orange_course_extended:addinstance'] = 'Add a new course contents block';
$string['orange_course_extended:myaddinstance'] = 'Add a new course contents block to the My Moodle page';
$string['course_extended'] = 'Course extended contents';

// General configuration.
$string['defaulttitle'] = 'Course extended contents';
$string['headerconfig'] = 'headerconfig';
$string['descconfig'] = 'descconfig';
$string['blocktitle'] = 'Extended Course';
$string['blocktitle_default'] = 'Extended Course';
$string['title_help'] = 'Leave this field empty to use the default block title. If you define a title here, it will be used instead of the default one.';
$string['pluginname'] = 'Extended Course';
$string['basics_title'] = 'Extended Course';
$string['course_extended_settings'] = 'settings';
$string['week'] = 'week(s)';
$string['day'] = 'day(s)';
$string['hour'] = 'hour(s)';
$string['minute'] = 'minute(s)';
$string['second'] = 'second(s)';

// Course visibility.
$string['maxvisibility'] = 'Maximum visibility';
$string['maxvisibility_help'] = '
<p><strong>Visible only to the page owner (private)</strong> &ndash;
nobody* else can see this page.</p>
<p><<strong>Visible to participants on this course</strong> &ndash; to view the page you must
have been granted access to the course, usually by being enrolled on the course that contains it.</p>

<p><strong>Visible to everyone who is logged in to the system</strong> &ndash; everyone who is
logged in can view the page, even if they\'re not enrolled on a specific course.</p>
<p><strong>Visible to anyone in the world</strong> &ndash; any Internet user can see this page
if you give them the page\'s address.</p>';

$string['visiblecourseusers'] = 'Visible to participants on this course';
$string['visibleloggedinusers'] = 'Visible to everyone who is logged in to the system';
$string['visiblepublic'] = 'Visible to anyone in the world';

// Extended course parameters.
$string['title'] = 'Extended Course';
$string['true'] = 'true';
$string['false'] = 'false';
$string['inserterror'] = 'insert error';
$string['notinserterror'] = 'not insert error';
$string['invalidcourse'] = 'Course not defined';
$string['pagetitle'] = 'pagetitle';
$string['pagetitle_default'] = 'Extended Course';
$string['pagetitle_help'] = 'Extended Course';

// Status.
$string['status'] = 'status';
$string['status_help'] = 'status_help';
$string['current'] = 'current';
$string['startingsoon'] = 'startingsoon';
$string['closed'] = 'closed';
$string['coursestatus'] = 'coursestatus';
$string['coursestatus_default'] = 'coursestatus_default';
$string['coursestatus_help'] = 'coursestatus_help';

// Picture.
$string['filetitle'] = 'Course image';
$string['userfile_default'] = 'undefined';
$string['picturefields'] = 'picturefields';
$string['displaypicture'] = 'displaypicture';
$string['pictureselect'] = 'pictureselect';
$string['picturedesc'] = 'picturedesc';
$string['picture_help'] = 'picture_help';
$string['picture'] = 'Picture';

// Duration.
$string['duration'] = 'Duration: ';
$string['duration_help'] = 'duration_help ';
$string['duration_default'] = 0;
$string['in_four_weeks'] = 'Less than 4 weeks';
$string['four_six_weeks'] = '4 to 6 waeeks';
$string['sup_six_weeks'] = 'More than 6 weeks';

// Working time.
$string['workingtime'] = 'Working time per day: ';
$string['workingtime_help'] = 'working time per day_help ';
$string['workingtime_default'] = 'Less than 1 hour';
$string['inf_one'] = 'Less than 1 hour';
$string['one_two'] = '1 to 2 hours';
$string['two_three'] = '2 to 3 hours';

// Certification.
$string['badge'] = 'Badge';
$string['badges'] = 'Badges';
$string['badge_default'] = 'No badge available';
$string['certification'] = 'Certification:';
$string['certification_default'] = 'No certification';
$string['certification_help'] = 'Certificate of achievement';

// Start end date.
$string['startdate'] = 'Start date: ';
$string['enddate'] = 'End date: ';
$string['enddate_default'] = "0";
$string['enddate_help'] = 'End date of the mooc';

// Course replay.
$string['course_replay_default'] = 'Replay';

// Price.
$string['price'] = 'Price: ';
$string['price_help'] = 'MOOC price';
$string['price_default'] = 'Free MOOC';
$string['price_case1'] = 'free mooc';
$string['price_case2'] = 'free mooc<br>certification in option';
$string['price_case3'] = 'professional teaching';

// Language.
$string['language'] = 'Language: ';
$string['language_default'] = 'No language';
$string['french'] = 'French';
$string['english'] = 'English';

// Video.
$string['video'] = 'Video ';
$string['video_help'] = 'Video_help';
$string['video_default'] = 'false';
$string['subtitle'] = ' subtitles';

// Registration.
$string['registration'] = 'Registration: ';
$string['registration_default'] = 'Mooc registration';
$string['registration_startdate'] = 'Registration start date: ';
$string['registration_enddate'] = 'Registration end date: ';
$string['registration_startdate_default'] = 'No registration start date';
$string['registration_enddate_default'] = 'No registration end date';
$string['registration_startdate_help'] = 'Registration start date';
$string['registration_enddate_help'] = 'Registration end date';
$string['registeredusers_limitation'] = 'Registered users: ';
$string['registration_case1'] = 'Open for everybody ';
$string['registration_from'] = ' from ';
$string['registration_to'] = ' to ';
$string['registrationcompany'] = 'Registration company: ';
$string['registrationcompany_default'] = 'No registration company';
$string['registrationcompany_help'] = 'registration company name';
$string['registration_case2'] = '{$a} place(s) available';
$string['registration_case3'] = 'You may register by ';

// Registered users.
$string['registeredusers'] = 'Registered users: ';
$string['registeredusers_help'] = 'Number of registered users';
$string['registeredusers_default'] = 'No registered users';
$string['moocstatus_default'] = 'MOOC not started';

// Prerequestites.
$string['prerequesites'] = 'Prerequisites';
$string['prerequesites_help'] = 'Prerequisites for ';
$string['prerequesites_default'] = 'No prerequisites';

// Teaching team.
$string['teachingteam'] = 'Teaching team';
$string['teachingteam_help'] = 'Teaching team';
$string['teachingteam_default'] = 'Conception : Orange with Learning CRM';

// Contact email.
$string['contactemail'] = 'Contact Email:';
$string['contactemail_help'] = 'Mooc contact email used by the contact form';
$string['contactemail_default'] = 'contact@solerni.com';