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
 * Strings for component 'local_mailtest', language 'fr', branch 'MOODLE_29_STABLE'
 *
 * @package   local_mailtest
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['errorsend'] = 'Le message électronique de test n\'a pas pu être remis au serveur SMTP. Vérifiez vos <a href="../../admin/settings.php?section=messagesettingemail" target="blank">paramètres SMTP</a>.';
$string['heading'] = 'Test de configuration de courriel';
$string['message'] = '<p>Il s\'agit d\'un message de test. S\'il vous plaît ne pas tenir compte.</p>
<hr><p><strong>Informations d\'utilisateur supplémentaires</strong></p>
<ul>
<li><strong>L\'état d\'enregistrement&nbsp;:</strong> {$a->regstatus}</li>
<li><strong>Langue préféré&nbsp;:</strong> {$a->lang}</li>
<li><strong>Navigateur web de l\'utilisateur&nbsp;:</strong> {$a->browser}</li>
<li><strong>Message soumis à partir de&nbsp;:</strong> {$a->referer}</li>
<li><strong>Version de Moodle&nbsp;:</strong> {$a->release}</li>
<li><strong>Adresse IP de l\'utilisateur&nbsp;:</strong> {$a->ip}</li>
</ul>';
$string['notregistered'] = 'N\'est pas enregistré ou vous n\'avez pas une session ouverte.';
$string['pluginname'] = 'Test du système de courriel';
$string['pluginname_help'] = 'Test du système de courriel va vérifier la configuration de courriel du site en envoyant un message électronique à une adresse spécifiée. Uniquement pour les administrateurs de site Moodle.';
$string['recipientisrequired'] = 'Vous devez spécifier l\'adresse courriel du destinataire.';
$string['registered'] = 'Utilisateur enregistré ({$a}).';
$string['sendtest'] = 'Envoyer un message de test';
$string['sentmail'] = 'Le message de test a été livré avec succès au serveur SMTP.';
