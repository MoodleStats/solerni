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
 * Adds new instance of enrol_orangeinvitation to specified course
 * or edits current instance.
 *
 * @package    enrol
 * @subpackage orangenextsession
 * @copyright  Orange 2015 based on Waitlist Enrol plugin / emeneo.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("$CFG->dirroot/local/orange_mail/mail_init.php");

$string['customconfirmationmessage'] = 'Message de confirmation (en HTML)';
$string['pluginname'] = 'Inscription pour la prochaine session';
$string['pluginname_desc'] = 'Le plugin Inscription pour la prochaine session permet aux utilisateurs d\'indiquer qu\'ils souhaitent participer à la prochaine session du cours.';
$string['orangenextsession:config'] = 'Configuration du plugin OrangeNextSession';
$string['sendconfirmationmessage'] = 'Envoyer un message de confirmation d\'inscription';
$string['sendconfirmationmessage_help'] = 'Si l\'option est activée, l\'utilisateur recevra un email de confirmation d\'inscription sur la liste de la prochaine session du cours.';
$string['status'] = 'Autoriser les inscription OrangeNextSession';
$string['status_desc'] = 'Permet d\'activer par défaut la méthode d\'inscription OrangeNextSession.';
$srting['custominformationmessage'] = 'Personnalisation du mail d\'information';
$string['informationmessage'] = 'Incription sur la liste d\'attente du cours {$a}';
$string['informationmessagetext'] = mail_init::init('informationmessagetext','html');
$string['orangenextsessioninfo'] = '<b>Les inscriptions pour ce cours sont terminées</b>. <br/>Vous serez prévenu du lancement d\'une prochaine session de ce cours.';
$string['exportuserlist'] = 'Exporter la liste des utilisateurs au format CSV';
$string['alreadyenrolled'] = 'Vous êtes déjà inscrit au cours';
$string['alreadyinlist'] = 'Vous êtes déjà inscrit sur la liste pour être averti de la prochaine session.';