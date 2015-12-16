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
 * Local language pack from http://moodle
 *
 * @package    core
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->dirroot/local/orange_mail/mail_init.php");

$string['emailconfirmation'] = mail_init::init('emailconfirmation','html');
$string['emailconfirmationsubject'] = 'Confirmation of your email address on {$a}';
$string['emailconfirmsent'] = '<h2>Votre inscription a été enregistrée, il ne reste plus qu’à valider votre compte.</h2><p>Pour valider définitivement votre inscription, cliquez sur le lien contenu dans le mail que nous venons de vous envoyer à l’adresse <strong>{$a}</strong></p>
<ul><li>si vous ne recevez pas notre mail, veuillez vérifier si celui-ci n’est pas bloqué dans vos courriers indésirables.</li>
<li>Si c’est le cas, merci d’ajouter cette adresse noreply@solerni.com dans votre carnet d’adresses.</li>
</ul>
<p>Sinon, <a href=\'/local/orange_email_confirm/index.php?mail={$a}\'>cliquez sur ce lien pour recevoir de nouveau notre mail</a>.<p>';
$string['mustconfirm'] = 'Confirmation de votre inscription';
$string['confirmed'] = '<h2>Votre compte est validé avec succès.</h2><p>Nous allons vous conduire vers la page demandée. Si la redirection ne s’affiche pas automatiquement, vous pouvez cliquer sur le bouton ci-dessous.</p>';
$string['alreadyconfirmed'] = '<h2>Votre compte est déjà validé.</h2><p>Nous allons vous conduire vers la page demandée. Si la redirection ne s’affiche pas automatiquement, vous pouvez cliquer sur le bouton ci-dessous.</p>';
$string['email'] = 'Email';
$string['emailagain'] = 'Email (verification)';
$string['createaccount'] = 'Register';
$string['policyagree'] = 'You must accept the general terms of use.';
$string['policyaccept'] = 'J’ai lu et j’accepte les conditions générales d’utilisation';
$string['policyagreementclick'] = 'Lire les conditions générales d’utilisation';
$string['newusernewpasswoardsubj'] = 'Creation of your user account';
$string['newusernewpasswoardtext'] = 'Dear {$a->firstname}

Your user account has been created on {$a->sitename}, your new collaborative company learning platform, on which you have been invited to follow one or more online courses.

Your login details:
    user name: {$a->username}
    password: {$a->newpassword}

Please note: this is a temporary password, you must change it when you connect for the first time.

Click on the following link, to connect to {$a->sitename} now:
   {$a->link}
and personalise your password.

If the link does not work, copy and paste the URL to your browser\'s address bar.

See you soon on {$a->sitename}.

You have received this email because your company wanted to automatically register you on our platform. This is an automatic message, please do not reply to it directly.
If you have any questions, write to us at contact@solerni.com.
To make sure you receive our emails, please add the following address to your contacts: noreply@solerni.com.';
$string['emailresetconfirmation'] = mail_init::init('emailresetconfirmation','text');		
$string['emailresetconfirmationhtml'] = mail_init::init('emailresetconfirmationhtml','html');
$string['newpasswordtext'] = mail_init::init('newpasswordtext','html');