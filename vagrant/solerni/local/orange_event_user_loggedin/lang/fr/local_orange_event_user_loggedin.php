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
 * @package    local_orange_event_user_loggedin
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("$CFG->dirroot/local/orange_mail/mail_init.php");

$string['pluginname'] = 'Orange Evt user_loggedin';
$string['local_orange_event_user_loggedin'] = 'Orange Evt user_loggedin';
$string['subjectuseraccountemail'] = 'Rappel de vos identifiants {$a->customername}';
$string['contentuseraccountemail'] = mail_init::init('contentuseraccountemail', 'html');
$string['subjectuseraccountemailprivate'] = 'Rappel de vos identifiants {$a->customername}';
$string['contentuseraccountemailprivate'] = mail_init::init('contentuseraccountemailprivate', 'html');