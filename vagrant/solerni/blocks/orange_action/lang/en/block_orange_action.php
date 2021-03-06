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
 * Orange Action block
 *
 * @package    block_orange_action
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Orange Action';
$string['config_default_title'] = 'Orange Action';
$string['hideblockheader'] = 'Hide title';
$string['hideblockheaderdesc'] = 'Allow to hide the block title';
$string['enrolledusers'] = '{$a->number} registered user{$a->plural}';
$string['coursetopush'] = 'Course to push';
$string['coursetopush_help'] = 'Select the course which will be push on user dashboard (Only non closed MOOCs are in the list).';
$string['eventtopush'] = 'Event to push';
$string['eventtopush_help'] = 'Select the event which will be push on user dashboard (Only not passed events are on the list).';
$string['selectcourse'] = "Select a course";
$string['selectevent'] = "Select an event";
$string['generalconfig'] = "General block configuration";
$string['myconfig'] = "Block configuration";
$string['myconfigdesc'] = "Select the course or the event to be pushed. If both are set, only the course will be displayed on the my page.";
$string['gotocalendar'] = "Access the event";
$string['gotosequence'] = "Go to the sequence";

$string['titledefault'] = '<span lang="fr" class="multilang">Titre</span><span lang="en" class="multilang">Title</span>';
$string['subtitledefault'] = '<span lang="fr" class="multilang">Sous-titre</span><span lang="en" class="multilang">Subtitle</span>';

$string['homepagebuttonmore'] = "Learn more about Solerni";

$string['title'] = 'Title';
$string['title_help'] = 'Enter the main text to be displayed in large characters under the video. Format :<br/>
&lt;span  lang="fr" class="multilang"><strong><i>Titre</i></strong>&lt;/span&gt;<br/>
&lt;span  lang="en" class="multilang"><strong><i>Title</i></strong>&lt;/span&gt;';


$string['subtitle'] = 'Subtitle';
$string['subtitle_help'] = 'Enter the text to be displayed under the title. Format :<br/>
&lt;span  lang="fr" class="multilang"><strong><i>Sous-titre</i></strong>&lt;/span&gt;<br/>
&lt;span  lang="en" class="multilang"><strong><i>Subtitle</i></strong>&lt;/span&gt;';

// For capabilities.
$string['orange_action:addinstance'] = 'Add a new Orange Action block';
$string['orange_action:myaddinstance'] = 'Add a new Orange Action block to My home page';
