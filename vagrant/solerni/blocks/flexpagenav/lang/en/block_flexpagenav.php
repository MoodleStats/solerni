<?php
/**
 * Flexpage Navigation Block
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
 * @package block_flexpagenav
 * @author Mark Nielsen
 */

/**
 * Plugin language
 *
 * @author Mark Nielsen
 * @package block_flexpagenav
 */

$string['pluginname'] = 'Flexpage Menu';
$string['flexpagenav:view'] = 'View Flexpage Menus';
$string['flexpagenav:manage'] = 'Manage Flexpage Menus';
$string['flexpagenav:addinstance'] = 'Add a new Flexpage Menu block';
$string['addexistingmenuaction'] = 'Add existing menu';
$string['managemenusaction'] = 'Manage all menus';
$string['managemenus'] = 'Manage menus';
$string['name'] = 'Name';
$string['manage'] = 'Manage';
$string['usedastabs'] = 'Used as tabs';
$string['addmenudotdotdot'] = 'Add new menu...';
$string['editmenu'] = 'Edit menu';
$string['useastab'] = 'Use as tabs';
$string['displayname'] = 'Display name';
$string['render'] = 'Display menu as';
$string['name'] = 'Name';
$string['tree'] = 'Tree';
$string['dropdown'] = 'Drop-down';
$string['navhorizontal'] = 'Horizontal navigation';
$string['navvertical'] = 'Vertical navigation';
$string['ajaxexception'] = 'Application error: {$a}';
$string['editmenuaction'] = 'Edit menu';
$string['deletemenuaction'] = 'Delete';
$string['managelinksaction'] = 'Manage links';
$string['managelinks'] = 'Manage links';
$string['editlink'] = 'Edit';
$string['movelink'] = 'Move';
$string['deletelink'] = 'Delete';
$string['type'] = 'Type';
$string['preview'] = 'Preview/Info';
$string['urllink'] = 'URL';
$string['addlinkdotdotdot'] = 'Add new link...';
$string['editingx'] = 'Editing {$a}';
$string['label'] = 'Label';
$string['url'] = 'URL';
$string['labelurlrequired'] = 'The label and URL fields are required.';
$string['editlinkaction'] = 'Edit';
$string['movelinkaction'] = 'Move';
$string['deletelinkaction'] = 'Delete';
$string['movelinkx'] = 'Move link {$a}';
$string['movebefore'] = 'before';
$string['moveafter'] = 'after';
$string['movelink'] = 'Move link';
$string['areyousuredeletelink'] = '<p>Are you sure that you want to delete this link?</p><p>{$a}</p>';
$string['areyousuredeletemenu'] = 'Are you sure that you want to delete <strong>{$a}</strong> menu?';
$string['deletemenu'] = 'Delete menu';
$string['displaymenu'] = 'Display menu';
$string['flexpage'] = 'Flexpage';
$string['flexpagelink'] = 'Flexpage';
$string['includechildren'] = 'Include children';
$string['excludechildren'] = 'Children to include';
$string['nochildpages'] = 'No child flexpages';
$string['flexpagewithchildren'] = '{$a} with children';
$string['flexpagewithoutchildren'] = '{$a} without children';
$string['flexpageerror'] = 'Error: Flexpage probably no longer exists';
$string['flexpagenav'] = 'Flexpage Menu';
$string['flexpagenavlink'] = 'Flexpage Menu';
$string['flexpagenavx'] = '{$a} menu';
$string['flexpagenaverror'] = 'Error: Flexpage menu probably no longer exists';
$string['nomenustoadd'] = 'There are no other Flexpage Menus that you can add to this menu.';
$string['coursemodule'] = 'Course activity';
$string['modlink'] = 'Activity';
$string['ticketlink'] = 'Trouble Ticket';
$string['subject'] = 'Subject';
$string['labelrequired'] = 'The label field is required.';
$string['menus'] = 'Menus';
$string['addexistingmenu'] = 'Add existing menu';
$string['addexistingmenu_help'] = 'Choose where you would like to place the block on the flexpage by selecting one of the buttons on the top of the <strong>Add existing menu</strong> window. Next, click on the name of the menu that you would like to add to the course.';
$string['migrationtoptabs'] = 'Course Top Tabs';
$string['moderror'] = 'Error: Activity probably no longer exists';
$string['noexistingmenustoadd'] = 'No menus have been created for this course.  Use <strong>Manage > Manage all menus</strong> to create new menus.';
$string['urlfailedcleaning'] = 'The entered URL failed the validation and cleaning process.  Please ensure that the entered URL is valid.';
$string['urlmuststartwith'] = 'The entered URL must start with either http:// or https://';
$string['managinglinksforx'] = 'Managing links for menu <em>{$a}</em>';
$string['formnamerequired'] = 'The menu name is required.';
$string['invalidurl'] = 'The entered URL is invalid and cannot be used.  Please verify the entered URL.';
$string['menudisplayerror'] = 'Could not display the associated Flexpage Menu.  The Flexpage Menu is either broken or no longer exists.  Please either delete this block or edit it to show a different Flexpage Menu.';
$string['dockable'] = 'Allow this block to be docked';

$string['dockable_help'] = 'Determine if this block can be docked by the user or not.  Please note though that docking can be disabled by the following exceptions:
<ul>
    <li>Theme setting can prevent docking of blocks.</li>
    <li>Only Flexpage Menus that display as Trees can be docked.</li>
    <li>Blocks without titles cannot be docked.</li>
</ul>';

$string['managemenus_help'] = '<p>Menus provide the navigation necessary for users to move through the flexpages of a course. Menus can be placed in any of the flexpage regions as blocks. Menus can contain links to flexpages within the course, external URLs, and links to other menus.</p>

<p>One of the menus in a course can also be marked as using "Tabs". This menu will appear as Top Tabs in the course. If you want each of the tabs to offer multiple options, create a Top Tab menu and link to a different Flexpage menu for each tab.</p>';
