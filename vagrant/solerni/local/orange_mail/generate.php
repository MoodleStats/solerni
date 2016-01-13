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
 * @package    local
 * @subpackage orange_mail
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(__FILE__) . '/classes/mail_generate.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->libdir . '/sessionlib.php');

$action = optional_param('action', 'rules_form', PARAM_ALPHAEXT);

// Access control.
require_login();
require_capability('local/orange_mail:config', context_system::instance());

$context = context_system::instance();

$url = new moodle_url('/admin/settings.php', array('section' => 'orange_mail_settings'));
$PAGE->set_url($url);
$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');

mail_generate::generate();

$url = new moodle_url('/admin/settings.php', array('section' => 'orange_mail_settings'));
$message = get_string('mailgeneratestatus', 'local_orange_mail');
redirect($url, $message);
