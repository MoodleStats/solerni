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
 * Strings for component 'auth', language 'fr', branch 'MOODLE_29_STABLE'
 *
 * @package   auth
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->dirroot/local/orange_mail/mail_init.php");

$string['auth_changingemailaddress'] = 'Vous avez demandé la modification de votre adresse e-mail, de {$a->oldemail} à {$a->newemail}. Pour des raisons de sécurité, un message de confirmation vous est envoyé à la nouvelle adresse afin de confirmer qu\'elle vous appartient. Votre adresse e-mail sera modifiée dès que vous aurez cliqué sur l\'URL indiquée dans le message envoyé.';
$string['emailupdate'] = 'Modification d\'adresse e-mail';
$string['emailupdatemessage'] = mail_init::init('emailupdatemessage','html');
$string['emailupdatesuccess'] = 'L\'adresse e-mail de votre compte <em>{$a->fullname}</em> a été modifiée. L\'adresse est maintenant <em>{$a->email}</em>.';
