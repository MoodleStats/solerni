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
 * English language file.
 *
 * @package local_eledia_makeanonymous
 * @author Matthias Schwabe <support@eledia.de>
 * @copyright 2013 & 2014 eLeDia GmbH
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'makeanonymous';

$string['anonymousauth'] = 'Méthode d\'authentification des utilisateurs anonymisés';
$string['anonymouscountry'] = 'Pays des utilisateurs anonymisés';
$string['anonymouscity'] = 'Ville des utilisateurs anonymisés';
$string['anonymousfirstname'] = 'Prénom des utilisateurs anonymisés';
$string['anonymoussurname'] = 'Nom de famille des utilisateurs anonymisés';
$string['anonymoususername_prefix'] = 'Préfixe pour constituer le nom d\'utilisateur des utilisateurs anonymisés';
$string['anonymousdomainemail'] = 'Domaine (email) des utilisateurs anonymisés';
$string['anonymousprefixemail'] = 'Préfixe pour constituer l\'email des utilisateurs anonymisés';
$string['makeanonymous_desc'] = 'Plugin eLeDia makeanonymous pour anonymiser les utilisateurs supprimés';
$string['makeanonymous_delay_desc'] = 'Vous pouvez retarder l\'anonymisation';
$string['makeanonymous_delay'] = 'Activer le retardement';
$string['makeanonymous_delay_config'] = 'Activer le retardement pour anonymiser les utilisateurs après un certain délai.';
$string['makeanonymous_delay_time'] = 'Délai (minutes)';
$string['makeanonymous_anonymize_old_head'] = 'Anonymisation des utilisateurs déjà supprimés';
$string['makeanonymous_enable'] = 'Activé le plugin makeanonymous';
$string['makeanonymous_enable_desc'] = 'Si cette option est désactivée, le plugin n\'aura aucun effet.';
$string['makeanonymous_anonymize_no_users'] = 'Il n\'y a actuellement pas d\'utilisateurs à anonymiser.';
$string['makeanonymous_anonymize_users_available'] = 'Il y a {$a} utilisateurs supprimés qui peuvent être anionymisés. Vous pouvez le faire en cliquant sur le bouton ci-dessous.';
$string['makeanonymous_button'] = 'Anonymiser les utilisateurs supprimés';
$string['makeanonymous_anonymize_old_desc'] = 'Vous pouvez également anonymiser les utilisateusr que vous avez supprimés par le passé.';
$string['eledia_makeanonymous_task'] = 'Tâche pour retarder l\'anonymisation des utilisateurs supprimés.';
$string['email_desc'] = 'Vous pouvez envoyer un mail aux utilisateurs anonymisés';
$string['mailerror'] = 'L\'email ne peut pas être envoyé';
$string['emailsubject'] = 'Sujet du mail';
$string['emailsubject_desc'] = 'Sujet affiché dans le mail';
$string['defaultemailsubject'] = 'Votre compte a été supprimé dans Solerni';
$string['emailmsg'] = 'Message du mail';
$string['emailmsg_desc'] = 'Message affiché dans le mail';
$string['defaultemailmsg'] = 'Votre compte a été supprimé dans Solerni. <br>Merci d\'avoir utilisé Solerni!';
$string['enabledemail'] = 'Activé l\'envoi de mail';
$string['enabledemail_desc'] = 'Active l\envoi de mail à l\'utilisateur';
