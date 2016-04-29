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
$string['emailconfirmationsubject'] = 'Confirmation of your e-mail address on {$a}';
$string['emailconfirmsent'] = '<h2>Votre inscription a été enregistrée, il ne reste plus qu’à valider votre compte.</h2><p>Pour valider définitivement votre inscription, cliquez sur le lien contenu dans le mail que nous venons de vous envoyer à l’adresse <strong>{$a}</strong></p>
<ul><li>si vous ne recevez pas notre mail, veuillez vérifier si celui-ci n’est pas bloqué dans vos courriers indésirables.</li>
<li>Si c’est le cas, merci d’ajouter cette adresse noreply@solerni.com dans votre carnet d’adresses.</li>
</ul>
<p>Sinon, <a href=\'/local/orange_email_confirm/index.php?mail={$a}\'>cliquez sur ce lien pour recevoir de nouveau notre mail</a>.<p>';
$string['mustconfirm'] = 'Confirmation de votre inscription';
$string['confirmed'] = '<h2>Votre compte est validé avec succès.</h2><p>Nous allons vous conduire vers la page demandée. Si la redirection ne s’affiche pas automatiquement, vous pouvez cliquer sur le bouton ci-dessous.</p>';
$string['alreadyconfirmed'] = '<h2>Votre compte est déjà validé.</h2><p>Nous allons vous conduire vers la page demandée. Si la redirection ne s’affiche pas automatiquement, vous pouvez cliquer sur le bouton ci-dessous.</p>';
$string['email'] = 'E-mail Address';
$string['emailagain'] = 'E-mail (verification)';
$string['createaccount'] = 'Register';
$string['policyagree'] = 'You must accept the general terms of use.';
$string['policyaccept'] = 'J’ai lu et j’accepte les conditions générales d’utilisation';
$string['policyagreementclick'] = 'Lire les conditions générales d’utilisation';
$string['newusernewpasswordsubj'] = 'Creation of your user account';
$string['newusernewpasswordtext'] = mail_init::init('newusernewpasswordtext','html');
$string['emailresetconfirmation'] = mail_init::init('emailresetconfirmation','html');		
$string['newpasswordtext'] = mail_init::init('newpasswordtext','html');
$string['commentscount'] = 'Write a comment';
$string['passwordforgotteninstructions2'] = '<p>To reset your password, submit your username or your e-mail address in the appropriate fields below. An e-mail will be sent to your e-mail address, with instructions how to get access again.</p>';
$string['emailpasswordconfirmmaybesent'] = '<p>If you supplied a correct username or e-mail address in the corresponding input field then an e-mail should have been sent to you.</p>
   <p>If not, please repeat the procedure "forgotten password".</p>
<p>If you continue to have difficulty, please <a href="'.$CFG->wwwroot.'/contact/">contact the site administrator</a>.</p>';
$string['searchbyemail'] = 'Search by e-mail address';
$string['invalidemail'] = 'Invalid e-mail address';
$string['setpasswordinstructions'] = '<p>Please enter and repeat your new password below, then click "Set password". <br />Your new password will be saved, and you will be logged in.</p>';
$string['resetrecordexpired'] = '<p>The password reset link you used is more than {$a} minutes old and has expired. Please initiate a new password reset.</p>';


