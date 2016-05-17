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
$string['emailconfirmationsubject'] = 'Confirmation de votre adresse email sur {$a}';
$string['emailconfirmsent'] = '<h2>Votre inscription a été enregistrée, il ne reste plus qu’à valider votre compte.</h2><p>Pour valider définitivement votre inscription, cliquez sur le lien contenu dans le mail que nous venons de vous envoyer à l’adresse <strong>{$a}</strong></p>
<ul><li>si vous ne recevez pas notre mail, veuillez vérifier si celui-ci n’est pas bloqué dans vos courriers indésirables.</li>
<li>Si c’est le cas, merci d’ajouter cette adresse noreply@solerni.com dans votre carnet d’adresses.</li>
</ul>
<p>Sinon, <a href=\'/local/orange_email_confirm/index.php?mail={$a}\'>cliquez sur ce lien pour recevoir de nouveau notre mail</a>.<p>';
$string['mustconfirm'] = 'Confirmation de votre inscription';
$string['confirmed'] = '<h2>Votre compte est validé avec succès.</h2><p>Nous allons vous conduire vers la page demandée. Si la redirection ne s’affiche pas automatiquement, vous pouvez cliquer sur le bouton ci-dessous.</p>';
$string['alreadyconfirmed'] = '<h2>Votre compte est déjà validé.</h2><p>Nous allons vous conduire vers la page demandée. Si la redirection ne s’affiche pas automatiquement, vous pouvez cliquer sur le bouton ci-dessous.</p>';
$string['email'] = 'Adresse e-mail';
$string['emailactive'] = 'E-mail activé';
$string['emailagain'] = 'E-mail (confirmation)';
$string['createaccount'] = 'Je m’inscris';
$string['policyagree'] = 'Vous devez accepter les conditions générales d’utilisation pour vous inscrire.';
$string['policyaccept'] = 'J’ai lu et j’accepte les conditions générales d’utilisation';
$string['policyagreementclick'] = 'Lire les conditions générales d’utilisation';

$string['emaildisable'] = 'Cet e-mail est désactivé';
$string['emaildisplay'] = 'Affichage de l’e-mail';
$string['emaildisplaycourse'] = 'Seuls les membres du cours sont autorisés à voir mon adresse e-mail';
$string['emaildisplayhidden'] = 'E-mail caché';
$string['emaildisplayno'] = 'Cacher à tous mon adresse e-mail';
$string['emaildisplayyes'] = 'Autoriser tout le monde à voir mon adresse e-mail';
$string['emailenable'] = 'Cette e-mail est activé';
$string['emailmustbereal'] = 'Remarque : votre adress e-mail doit être valide';
$string['emailnotfound'] = 'Cette adresse e-mail n\'a pas été trouvé dans la base de données';
$string['emailonlyallowed'] = 'Cette adresse e-mail ne fait pas partie de celles qui sont autorisées ({$a})';
$string['enteremail'] = 'Tapez votre adresse e-mail';
$string['enteremailaddress'] = 'Tapez votre adresse e-mail afin qu\'un nouveau mot de passe vous soit envoyé par e-mail';
$string['invalidemail'] = 'Adresse e-mail incorrecte';
$string['missingemail'] = 'L\'e-mail ne peut pas être vide';
$string['nosuchemail'] = 'Adresse e-mail inconnue';
$string['username'] = 'Pseudo';
$string['usernameemail'] = 'Pseudo/adresse e-mail';
$string['usernameemailmatch'] = 'Le pseudo et l\'adresse e-mail donnés ne correspondent pas au même utilisateur';
$string['usernameoremail'] = 'Veuillez indiquer soit le pseudo, soit l\'adresse e-mail';
$string['newusernewpasswordsubj'] = 'Création de votre compte utilisateur';
$string['newusernewpasswordtext'] = mail_init::init('newusernewpasswordtext','html');
$string['commentscount'] = 'Commentaires ({$a})';
$string['emailresetconfirmation'] = mail_init::init('emailresetconfirmation','html');
$string['newpasswordtext'] = mail_init::init('newpasswordtext','html');
$string['maxbytesforfile'] = 'Le fichier {$a} dépasse la taille maximale autorisée.';
$string['passwordforgotteninstructions2'] = '<p>Pour recevoir votre nouveau mot de passe, veuillez indiquer soit votre adresse e-mail soit votre pseudo dans le champ de saisie correspondant. Un message vous sera envoyé par e-mail, avec les instructions vous permettant de vous connecter.</p>';
$string['searchbyemail'] = 'Récupération par adresse e-mail';
$string['searchbyusername'] = 'Récupération par pseudo';
$string['forgottenduplicate'] = 'Cette adresse e-mail est utilisée dans plusieurs comptes. Veuillez indiquer votre pseudo dans le champ pseudo';
$string['emailpasswordconfirmmaybesent'] = '<p>Si vous avez renseigné correctement votre pseudo ou votre adresse e-mail dans le champ de saisie correspondant vous recevrez un e-mail vous permettant de modifier votre mot de passe.</p> '
        . '<p>Dans le cas contraire, veuillez recommencer la procédure "mot de passe oublié" en renseignant bien le champ sélectionné.</p> '
        . '<p>Si vous n\'arrivez toujours pas à vous connecter, veuillez <a href="'.$CFG->wwwroot.'/contact/">contacter l\'administrateur du site</a>.</p>';
$string['invalidemail'] = 'Adresse e-mail incorrecte';
$string['again'] = 'vérification';
$string['setpassword'] = 'Définir un nouveau mot de passe';
$string['setpasswordinstructions'] = '<p>Veuillez saisir et répéter votre nouveau mot de passe ci-dessous, puis cliquer sur « Enregistrer ».<br />Votre nouveau mot de passe sera alors enregistré et vous serez connecté.</p>';
$string['resetrecordexpired'] = '<p>Le lien de réinitialisation de mot de passe que vous avez utilisé a été généré il y a {$a} minutes, il n\'est plus valide. Veuillez effectuer une nouvelle demande de réinitialisation de mot de passe.</p>';
$string['changedpassword'] = 'Réinitialisation de votre mot de passe';
$string['emailresetconfirmationsubject'] = 'Réinitialisation de votre mot de passe sur {$a}';
$string['lastsiteaccess'] = 'Dernière connexion';
$string['firstsiteaccess'] = 'Première connexion';
