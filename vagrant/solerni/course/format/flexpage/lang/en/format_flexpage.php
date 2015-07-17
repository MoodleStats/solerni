<?php
/**
 * Flexpage
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://opensource.org/licenses/gpl-3.0.html.
 *
 * @copyright Copyright (c) 2009 Moodlerooms Inc. (http://www.moodlerooms.com)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @package format_flexpage
 * @author Mark Nielsen
 */

/**
 * Flexpage language definitions
 *
 * @author Mark Nielsen
 * @package format_flexpage
 */
$string['pluginname'] = 'Flexpage format';
$string['defaultcoursepagename'] = 'Default flexpage (Change me)';
$string['pagenotfound'] = 'The flexpage with id = {$a} does not exist in this course.';
$string['addmenu'] = 'Add';
$string['managemenu'] = 'Manage';
$string['addactivityaction'] = 'Add activity';
$string['addpagesaction'] = 'Add flexpages';
$string['managepagesaction'] = 'Manage all flexpages';
$string['editpageaction'] = 'Manage flexpage settings';
$string['editpage'] = 'Flexpage settings';
$string['movebefore'] = 'before';
$string['moveafter'] = 'after';
$string['movechild'] = 'as first child of';
$string['ajaxexception'] = 'Application error: {$a}';
$string['addedpages'] = 'Added flexpages: {$a}';
$string['addpages'] = 'Add flexpages';
$string['error'] = 'Error';
$string['genericasyncfail'] = 'The request failed for an unknown reason, please try the action again.';
$string['close'] = 'Close';
$string['gotoa'] = 'Go to "{$a}"';
$string['movepageaction'] = 'Move flexpage';
$string['movepage'] = 'Move flexpage';
$string['movepagea'] = 'Move flexpage <strong>{$a}</strong>';
$string['movedpage'] = 'Moved flexpage "{$a->movepage}" {$a->move} flexpage "{$a->refpage}"';
$string['addactivity'] = 'Add activity';
$string['addactivity_help'] = 'Choose where you would like to place the new activity on the flexpage by selecting one of the buttons at the top of the <strong>Add activity</strong> window. Next, choose the activity or resource that you would like to add to the course and flexpage.';
$string['addto'] = 'Add to region:';
$string['addexistingactivity'] = 'Add existing activity';
$string['addexistingactivity_help'] = 'Choose where you would like to place the existing activity on the flexpage by selecting one of the buttons at the top of the <strong>Add existing activity</strong> window. Next, place a checkmark next to the activities that you would like to add to this flexpage. Finally, click the "Add activities" button at the bottom of the window to complete the action.';
$string['addexistingactivityaction'] = 'Add existing activity';
$string['addactivities'] = 'Add activities';
$string['addblock'] = 'Add block';
$string['addblock_help'] = 'Choose where you would like to place the block on the flexpage by selecting one of the buttons at the top of the <strong>Add block</strong> window. Next, click on the name of the block that you would like to add to the course.';
$string['addblockaction'] = 'Add block';
$string['block'] = 'Block';
$string['displayhidden'] = 'Hidden';
$string['displayvisible'] = 'Visible but not in menus';
$string['displayvisiblemenu'] = 'Visible and in menus';
$string['navnone'] = 'No navigation';
$string['navprev'] = 'Previous flexpage only';
$string['navnext'] = 'Next flexpage only';
$string['navboth'] = 'Both previous and next flexpage';
$string['navigation'] = 'Navigation';
$string['navigation_help'] = 'Used to display next and/or previous buttons on this flexpage.  The buttons take the user to the next/previous available flexpage.';
$string['display'] = 'Display';
$string['name'] = 'Name';
$string['name_help'] = 'This is the name of your flexpage and it will appear to course users in menus and the like.';
$string['formnamerequired'] = 'The flexpage name is a required field.';
$string['regionwidths'] = 'Block region widths';
$string['regionwidths_help'] = 'One can specify in pixels how wide each region of blocks can be.  An example would be to set left to 200, main to 500 and right to 200.  Please note though that available regions and their names can change from theme to theme.';
$string['managepages'] = 'Manage flexpages';
$string['managepages_help'] = 'From this window, you can view the index of all flexpages; quickly manage, move or delete an individual flexpage; alter display settings; and control navigation settings.';
$string['pagename'] = 'Flexpage name';
$string['deletepage'] = 'Delete flexpage';
$string['deletepageaction'] = 'Delete flexpage';
$string['areyousuredeletepage'] = 'Are you sure that you want to permanently delete flexpage <strong>{$a}</strong>?';
$string['deletedpagex'] = 'Deleted flexpage "{$a}"';
$string['flexpage:managepages'] = 'Manage flexpages';
$string['pagexnotavailable'] = '{$a} is not available';
$string['pagenotavailable'] = 'Not available';
$string['pagenotavailable_help'] = 'This flexpage is not available to you.  Below might be a list of conditions that you must satisfy in order to view the flexpage.';
$string['sectionname'] = 'Section';
$string['page'] = 'Flexpage';
$string['copydotdotdot'] = 'Copy...';
$string['nextpage'] = 'Next >';
$string['next'] = 'Next';
$string['previouspage'] = '< Previous';
$string['previous'] = 'Previous';
$string['themelayoutmissing'] = 'Your current theme does not support Flexpage.  Please change the theme (or if enabled, the course theme or your preferred theme in your profile) to one that has a "{$a}" layout.';
$string['deletemodwarn'] = 'If this activity is deleted, then it will be removed from all flexpages.';
$string['continuedotdotdot'] = 'Continue...';
$string['warning'] = 'Warning';
$string['actionbar'] = 'Action bar';
$string['availablefrom'] = 'Allow access from';
$string['availablefrom_help'] = 'This flexpage will be available to course users after this date.';
$string['availableuntil'] = 'Allow access until';
$string['availableuntil_help'] = 'This flexpage will be available to course users before this date.';
$string['showavailability'] = 'Before this can be accessed';
$string['showavailability_help'] = 'If the flexpage is unavailable to the user, this setting determines whether this flexpage\'s restriction information or nothing at all is displayed.';
$string['nomoveoptionserror'] = 'You cannot move this flexpage because there are no available positions to place this flexpage.  Try adding new flexpages before or after this flexpage.';
$string['frontpage'] = 'Use Flexpage on front page';
$string['frontpagedesc'] = 'This will enable the Flexpage format on the front page.';
$string['hidefromothers'] = 'Hide flexpage';
$string['showfromothers'] = 'Show flexpage';
$string['jumptoflexpage'] = 'Jump to a flexpage';
$string['preventactivityview'] = 'You cannot access this activity yet because it is on a flexpage that is currently not available to you.';
$string['showavailability_hide'] = 'Hide flexpage entirely';
$string['showavailability_show'] = 'Show flexpage greyed-out with restriction information';

$string['display_help'] = 'Configure if this flexpage is:
<ol>
    <li>Hidden completely to non-editors.</li>
    <li>Visible to course users, but does not appear in Flexpage Menus and course navigation.</li>
    <li>Visible to course users and appears in Flexpage Menus and course navigation.</li>
</ol>';

$string['addpages_help'] = 'From here you can add new flexpages to your course.  Going from left to right on the form:
 <ol>
    <li>Enter the name of your flexpage (blank names are not added).</li>
    <li>The next <em>two</em> drop-downs determine where in the index of flexpages your new flexpage will be added.  So, you can
     add your new flexpage before, after or as a child (sub-flexpage) of another flexpage.</li>
    <li>(Optional) In the last drop-down, you can choose an existing flexpage to copy into your newly created flexpage.</li>
</ol>
To add more than one flexpage at a time, click on the "+" icon and fill out the new row.  If you click on the "+" icon too many times, just blank out the flexpage names and they will not be added.';

$string['actionbar_help'] = '
<p>With Flexpage, course designers can create multiple flexpages within the course. Each flexpage can have unique or shared content on them.</p>

<p>With the Action bar, one can jump to different flexpages within this course by clicking the name of the flexpage in the
 drop-down menu.</p>

<p>Available actions under the <strong>Add</strong> Action bar menu item:
    <ul>
        <li>To add a flexpage, select the <strong>Add flexpages</strong> link from the drop-down menu. When you add new flexpages
        , you will want to determine where they are located in the index of flexpages. Flexpages can be children of other flexpages (sub-flexpages). Or they can simply be placed before or after other flexpages. New flexpages can also be blank, or a copy of an existing flexpage. To add multiple flexpages to a course, press the "+" icon on the right side of the <strong>Add flexpages</strong> window.</li>
        <li>To add a new activity to this flexpage, select <strong>Add activity</strong> from the drop-down menu.  Choose where
         you would like to place the new activity on the flexpage by selecting one of the buttons at the top of the <strong>Add activity</strong> window. Next, choose the activity or resource that you would like to add to the course and flexpage.</li>
        <li>To add an existing activity to this flexpage, select <strong>Add existing activity</strong> from the drop-down menu.
        Choose where you would like to place the existing activity on the flexpage by selecting one of the buttons at the top of the <strong>Add existing activity</strong> window. Next, place a checkmark next to the activities that you would like to add to this flexpage. Finally, click the "Add activities" button at the bottom of the window to complete the action.</li>
        <li>To add a block to this flexpage, select <strong>Add block</strong> from the drop-down menu. Choose where you would
        like to place the block on the flexpage by selecting one of the buttons at the top of the <strong>Add block</strong> window. Next, click on the name of the block that you would like to add to the course.</li>
        <li>To add an existing menu to this flexpage, select <strong>Add existing menu</strong> from the drop-down menu. Choose
         where you would like to place the block on the flexpage by selecting one of the buttons at the top of the <strong>Add existing menu</strong> window. Next, click on the name of the menu that you would like to add to the course.</li>
    </ul>
</p>

<p>Available actions under the <strong>Manage</strong> Action bar menu item:
    <ul>
        <li>To configure the settings for this flexpage, click the <strong>Manage flexpage settings</strong> link from the
        drop-down menu. From this window, you can edit the flexpage name; change the widths of the flexpage regions; indicate whether the flexpage should be hidden, visible, or visible in menus; as well as determine whether the flexpages should have "previous and next" navigation buttons.</li>
        <li>To move a flexpage, click the <strong>Move flexpage</strong> link from the drop-down menu. From this window, you can
         choose whether the flexpage is a child of another flexpage, or whether it is before or after another flexpage in the index.</li>
        <li>To delete a flexpage, click the <strong>Delete flexpage</strong> link from the drop-down menu. From this window, you
        can confirm that you want to delete the current flexpage.</li>
        <li>To manage the settings of multiple flexpages, click the <strong>Manage all flexpages</strong> link from the drop-down
         menu. From this window, you can view the index of all flexpages; quickly manage, move or delete individual flexpages; alter display settings; as well as control navigation settings.</li>
        <li>To manage tabs for your course, as well as other menus, click the <strong>Manage all menus</strong> link from the
        drop-down menu. From this window you can create menus, as well as quickly edit menus, delete menus, and manage links within the menus.</li>
    </ul>
</p>';

// These are here for legacy support of old condition UI.
$string['none']           = '(none)';
$string['grade_atleast']  = 'must be at least';
$string['grade_upto']     = 'and less than';
$string['contains']       = 'contains';
$string['doesnotcontain'] = 'doesn\'t contain';
$string['isempty']        = 'is empty';
$string['isequalto']      = 'is equal to';
$string['isnotempty']     = 'is not empty';
$string['endswith']       = 'ends with';
$string['startswith']     = 'starts with';
$string['completion_complete']   = 'must be marked complete';
$string['completion_fail']       = 'must be complete with fail grade';
$string['completion_incomplete'] = 'must not be marked complete';
$string['completion_pass']       = 'must be complete with pass grade';
$string['completioncondition'] = 'Activity completion condition';
$string['completioncondition_help'] = 'This setting determines any activity completion conditions which must be met in order to access the flexpage. Note that completion tracking must first be set before an activity completion condition can be set.

Multiple activity completion conditions may be set if desired.  If so, access to the flexpage will only be permitted when ALL activity completion conditions are met.';
$string['gradecondition'] = 'Grade condition';
$string['gradecondition_help'] = 'This setting determines any grade conditions which must be met in order to access the flexpage.

Multiple grade conditions may be set if desired. If so, the flexpage will only allow access when ALL grade conditions are met.';
$string['userfield'] = 'User field';
$string['userfield_help'] = 'You can restrict access based on any field from the users profile.';
$string['releasecode'] = 'Release code';
$string['releasecode_help'] = 'This course item will not be available to students until the student acquires the release code entered here.';

/*
 * Adding the extended page parameters
 */
$string['picture'] = 'picture';
$string['picture_help'] = 'picture_help';
$string['coursereplay'] = 'After closed';
$string['coursereplay_help'] = 'Choose the action';
$string['replay'] = 'Replay';
$string['notreplay'] = 'Don\'t replay';

$string['current'] = 'current';
$string['startingsoon'] = 'startingsoon';
$string['closed'] = 'closed';
$string['picture'] = 'picture';
$string['badge'] = 'Badge';
$string['badge_help'] = 'Badge_help';
$string['certification'] = 'Certification';
$string['certification_help'] = 'Certification_help';

$string['coursethematics'] = 'Thematics';
$string['coursethematics_help'] = 'List of possibles thematics. Choose one or more thematics';

$string['startdate'] = 'start date: ';
$string['enddate'] = 'end date: ';
$string['enddate_default'] = "0";
$string['enddate_help'] = 'enddate_help ';

$string['duration'] = 'duration: ';
$string['duration_help'] = 'duration_help ';
$string['duration_default'] = 'inferior at four weeks';
$string['duration0'] = 'inferior at four weeks';
$string['duration1'] = 'four to six weeks';
$string['duration2'] = 'superior at six weeks';

$string['workingtime'] = 'working time per day: ';
$string['workingtime_help'] = 'working time per day_help ';
$string['workingtime_default'] = 'inf_one';
$string['workingtime0'] = 'inferior at one hour';
$string['workingtime1'] = 'one to two hours';
$string['workingtime2'] = 'two to three hours';

$string['price'] = 'price: ';
$string['price_help'] = 'price_help';
$string['price_default'] = '0';
$string['price_case1'] = 'free mooc';
$string['price_case2'] = 'free mooc<br>certification in option';
$string['price_case3'] = 'professional teaching';

$string['certification'] = 'Certification';
$string['certification_default'] = 'Badges<br>Certificate of achievement';
$string['certification_help'] = 'No Certification';

$string['language'] = 'Language: ';
$string['language_default'] = 'french';
$string['language_help'] = 'Language';
$string['french'] = 'French';
$string['english'] = 'English';


$string['video'] = 'Video: ';
$string['video_help'] = 'Video_help';
$string['video_default'] = 'false';
$string['true'] = 'true';
$string['false'] = 'false';

$string['subtitle'] = 'Subtitle: ';
$string['subtitle_help'] = 'subtitle_help';
$string['subtitle_default'] = 'false';


$string['registration'] = 'registration: ';
$string['registration_default'] = 'registration';
$string['registration_help'] = 'registration help';
$string['registration_startdate'] = 'registration start date: ';
$string['registration_enddate'] = 'registration end date: ';
$string['registration_startdate_default'] = 'registration start date_default';
$string['registration_enddate_default'] = 'registration end date_default';
$string['registration_startdate_help'] = 'registration start date_help';
$string['registration_enddate_help'] = 'registration end date_help ';
$string['registeredusers_limitation'] = 'registeredusers: ';
$string['registration_case1'] = 'registration without quota ';
$string['registration_case2'] = 'limited registration ';
$string['registration_case3'] = 'private registration';
$string['registrationcompany'] = 'registration_company: ';
$string['registrationcompany_default'] = 'registration_company';
$string['registrationcompany_help'] = 'registration_company help';


$string['registeredusers'] = 'registered users: ';
$string['registeredusers_help'] = 'registeredusers_help';
$string['registeredusers_default'] = 'no registered users';
$string['moocstatus_default'] = 'MOOC not started';

$string['status'] = 'status';
$string['status_help'] = 'status_help';
$string['status_default'] = 'MOOC not started ';

$string['prerequesites'] = 'Prerequisites';
$string['prerequesites_help'] = ' It allows the user to enter rich text content in a variety of formats.';
$string['prerequesites_default'] = 'No Prerequisites';

$string['teachingteam'] = 'Teaching team';
$string['teachingteam_help'] = 'It allows the user to enter rich text content in a variety of formats.';
$string['teachingteam_default'] = 'Conception : Orange with Learning CRM';