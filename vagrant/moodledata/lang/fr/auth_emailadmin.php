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
 * Strings for component 'auth_emailadmin', language 'fr', branch 'MOODLE_29_STABLE'
 *
 * @package   auth_emailadmin
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['auth_emailadminconfirmationsubject'] = '{$a}: confirmation de compte';
$string['auth_emailadmindescription'] = '<p>L\'auto-inscription via email avec confirmation des Administrateurs permet à un utilisateur de créer son propre compte via un bouton « Créer un nouveau compte » sur la page de connexion. Les administrateurs du site reçoivent ensuite un email contenant un lien sécurisé sur une page où ils peuvent confirmer leur compte. Les futures connexions vérifient simplement le nom de l’utilisateur et son mot de passe par rapport aux valeurs stockées dans la base de données Moodle.</p><p>Note : Outre le fait d’activer le plugin, l’auto-inscription via email avec confirmation des administrateurs doit également être sélectionnée à partir du menu déroulant d’auto-inscription sur la page « Gérer l’authentification ».</p>';
$string['auth_emailadminnoemail'] = 'J’ai essayé de vous envoyer un email mais j\'ai échoué !';
$string['auth_emailadminrecaptcha'] = 'Ajoute un élément de formulaire de confirmation visuel/audio sur la page d’inscription pour les utilisateurs qui s’auto-inscrivent par email. Ceci protège votre site des spammeurs et contribue à une juste cause. Consulter http://www.google.com/recaptcha/learnmore pour de plus amples informations. <br /><em>L’extension PHP cURL est requise.</em>';
$string['auth_emailadminrecaptcha_key'] = 'Activer élément reCAPTCHA';
$string['auth_emailadminsettings'] = 'Paramétrages';
$string['pluginname'] = 'Auto-inscription via email avec confirmation des administrateurs';
