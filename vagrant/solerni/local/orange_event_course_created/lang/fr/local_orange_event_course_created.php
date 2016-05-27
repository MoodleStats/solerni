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

$string['pluginname'] = 'Orange Event course_created';
$string['content_piwik_success'] = '<p>Bonjour <strong>{$a->firstname} {$a->lastname}</strong></p>
<p>Un compte a été créé automatiquement sur la plateforme de web analytique Piwik afin de vous donner accès aux données web du MOOC \'{$a->coursename}\'</p>
<br/>
<p>Pour accéder à votre compte Piwik, veuillez utiliser les identifiant suivants : </p>
<ul>
   <li>Pseudo : {$a->userpiwik}</li>
   <li>Mot de passe : {$a->passwordpiwik}</li>
</ul>
<br/>
<p><i>Remarque : Vous pouvez personnaliser votre mot de passe sur la plateforme Piwik</i></p>';
$string['content_piwik_fail'] = '<p>Hello <strong>{$a->firstname} {$a->lastname}</strong>,</p>
<p>Nous sommes désolés mais un problème technique a empêché la création automatique de votre compte d’accès aux données web du MOOC "{$a->coursename}" sur la plateforme Piwik</p>
<br/>
<p>Veuillez s’il vous plait contacter notre support à l’adresse e-mail ci-contre {$a->emailcontact} afin de finaliser la création de votre compte.</p>';
$string['subject_piwik_success'] = '{$a->coursename} : Création de votre compte sur Piwik';
$string['subject_piwik_fail'] = '{$a->coursename} : Echec lors de la création de votre compte sur Piwik';
        