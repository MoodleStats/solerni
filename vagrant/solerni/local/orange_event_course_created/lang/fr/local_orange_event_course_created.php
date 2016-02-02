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

$string['pluginname'] = 'Orange Evt course_created';
$string['welcome_enrolment_message_title'] = 'Bienvenue';
$string['welcome_enrolment_message_inscription'] = 'Vous vous êtes inscrit au MOOC {$a}.';
$string['welcome_enrolment_message_notstarted'] = 'Le cours n\'a pas commencé : il débutera le {$a} prochain.. Nous vous enverrons une notification quelques jours avant le début des cours afin de vous rappeler la date de début du MOOC. A très bientôt.';
$string['welcome_enrolment_message_started'] = 'Le cours est ouvert : vous pouvez y accéder dès à présent. Bon MOOC !';
$string['content_piwik_success'] = '<p>Bonjour <span class="txt18BNoir">{$a->username}</span>,</p>
<p>Suite à la création un nouveau mooc {$a->coursename} sur la plateforme {$a->sitename} , un nouveau compte et segment Piwik ont été automatiquement créés avec succes.</p>
<p>Les nouveaux identifiants de connexion à Piwik sont :</p>
<ul>
   <li>nom d\'utilisateur : {$a->userpiwik}</li>
   <li>mot de passe       : {$a->passwordpiwik}</li>
</ul>
<p><strong>Remarque : </strong>Vous pouvez changer le mot de passe à tout moment sur Piwik</p>';
$string['content_piwik_fail'] = '<p>Bonjour <span class="txt18BNoir">{$a->username}</span>,</p>
<p>Lors de la création du nouveau mooc \'{$a->coursename}\' dans Solerni sur la plateforme {$a->sitename}, la création d\'un compte et/ou segment Piwik a échouée. Merci d\'en informé le reponsable Piwik sur Solerni </p>';
$string['subject_piwik_success'] = '{$a->sitename} - Créations d\'un compte et segment piwik';
$string['subject_piwik_fail'] = '{$a->sitename} - Echec dans la création du compte et/ou du segment Piwik';
        