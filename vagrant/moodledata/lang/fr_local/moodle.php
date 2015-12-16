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
$string['emailconfirmationsubject'] = 'Confirmation de l’ouverture du compte sur {$a}';
$string['emailconfirmsent'] = '<h2>Votre inscription a été enregistrée, il ne reste plus qu’à valider votre compte.</h2><p>Pour valider définitivement votre inscription, cliquez sur le lien contenu dans le mail que nous venons de vous envoyer à l’adresse <strong>{$a}</strong></p>
<ul><li>si vous ne recevez pas notre mail, veuillez vérifier si celui-ci n’est pas bloqué dans vos courriers indésirables.</li>
<li>Si c’est le cas, merci d’ajouter cette adresse noreply@solerni.com dans votre carnet d’adresses.</li>
</ul>
<p>Sinon, <a href=\'/local/orange_email_confirm/index.php?mail={$a}\'>cliquez sur ce lien pour recevoir de nouveau notre mail</a>.<p>';
$string['mustconfirm'] = 'Confirmation de votre inscription';
$string['confirmed'] = '<h2>Votre compte est validé avec succès.</h2><p>Nous allons vous conduire vers la page demandée. Si la redirection ne s’affiche pas automatiquement, vous pouvez cliquer sur le bouton ci-dessous.</p>';
$string['alreadyconfirmed'] = '<h2>Votre compte est déjà validé.</h2><p>Nous allons vous conduire vers la page demandée. Si la redirection ne s’affiche pas automatiquement, vous pouvez cliquer sur le bouton ci-dessous.</p>';
$string['email'] = 'Email';
$string['emailactive'] = 'Email activé';
$string['emailagain'] = 'Email (confirmation)';
$string['createaccount'] = 'Je m’inscris';
$string['policyagree'] = 'Vous devez accepter les conditions générales d’utilisation pour vous inscrire.';
$string['policyaccept'] = 'J’ai lu et j’accepte les conditions générales d’utilisation';
$string['policyagreementclick'] = 'Lire les conditions générales d’utilisation';

$string['emaildisable'] = 'Cet email est désactivé';
$string['emaildisplay'] = 'Affichage de l’email';
$string['emaildisplaycourse'] = 'Seuls les membres du cours sont autorisés à voir mon email';
$string['emaildisplayhidden'] = 'Email caché';
$string['emaildisplayno'] = 'Cacher à tous mon email';
$string['emaildisplayyes'] = 'Autoriser tout le monde à voir mon email';
$string['emailenable'] = 'Cette email est activé';
$string['emailmustbereal'] = 'Remarque : votre email doit être valide';
$string['emailnotfound'] = 'Cette email n\'a pas été trouvé dans la base de données';
$string['emailonlyallowed'] = 'Cet email ne fait pas partie de ceux qui sont autorisés ({$a})';
$string['enteremail'] = 'Tapez votre email';
$string['enteremailaddress'] = 'Tapez votre adresse email afin qu\'un nouveau mot de passe vous soit envoyé par email';
$string['invalidemail'] = 'Adresse email incorrecte';
$string['missingemail'] = 'L\'email ne peut pas être vide';
$string['nosuchemail'] = 'Adresse email inconnue';
$string['usernameemail'] = 'Nom d\'utilisateur/email';
$string['usernameemailmatch'] = 'Le nom d\'utilisateur et l\'adresse email donnés ne correspondent pas au même utilisateur';
$string['usernameoremail'] = 'Veuillez indiquer soit le nom d\'utilisateur, soit l\'adresse email';
$string['newusernewpasswoardsubj'] = 'Création de votre compte utilisateur';
$string['newusernewpasswoardtext'] = 'Bonjour {$a->firstname},

Votre compte utilisateur a été créé sur « {$a->sitename} », votre nouvelle plateforme d\'apprentissage collaborative d\'entreprise, sur laquelle vous êtes  invité(e)  à suivre une ou plusieurs formations en ligne.

Vos identifiants de connexion sont :
   nom d\'utilisateur : {$a->username}
   mot de passe       : {$a->newpassword}

Attention : ce mot de passe est provisoire, vous devrez  le changer à votre 1ere connexion.

Connectez-vous dès maintenant  sur {$a->sitename}  en cliquant sur le lien suivant :
   {$a->link}
afin de personnaliser votre mot de passe.

Si le lien ne fonctionne pas, copiez-collez le lien dans la barre d\'adresse de votre navigateur.

A très bientôt sur {$a->sitename}

Vous recevez cet e-mail car votre entreprise a souhaité vous inscrire automatiquement sur notre plateforme. Ce message vous est envoyé automatiquement, merci de ne pas y répondre directement.
Si vous avez des questions écrivez-nous à contact@solerni.com.
Afin de bien recevoir nos e-mails, ajoutez cette adresse noreply@solerni.com  dans votre carnet d\'adresses.';
$string['newusernewpasswordhtml'] = 'Bonjour {$a->firstname},

Votre compte utilisateur a été créé sur « {$a->sitename} », votre nouvelle plateforme d\'apprentissage collaborative d\'entreprise, sur laquelle vous êtes  invité(e)  à suivre une ou plusieurs formations en ligne.

Vos identifiants de connexion sont :
   nom d\'utilisateur : {$a->username}
   mot de passe       : {$a->newpassword}

Attention : ce mot de passe est provisoire, vous devrez  le changer à votre 1ere connexion.

Connectez-vous dès maintenant  sur {$a->sitename}  en cliquant sur le lien suivant :
   {$a->link}
afin de personnaliser votre mot de passe.

Si le lien ne fonctionne pas, copiez-collez le lien dans la barre d\'adresse de votre navigateur.

A très bientôt sur {$a->sitename}

Vous recevez cet e-mail car votre entreprise a souhaité vous inscrire automatiquement sur notre plateforme. Ce message vous est envoyé automatiquement, merci de ne pas y répondre directement.
Si vous avez des questions écrivez-nous à contact@solerni.com.
Afin de bien recevoir nos e-mails, ajoutez cette adresse noreply@solerni.com  dans votre carnet d\'adresses.';
$string['commentscount'] = 'Commentaires ({$a})';
$string['emailresetconfirmation'] = mail_init::init('emailresetconfirmation','text');
$string['emailresetconfirmationhtml'] = mail_init::init('emailresetconfirmationhtml','html');
$string['newpasswordtext'] = mail_init::init('newpasswordtext','html');
$string['maxbytesforfile'] = 'Le fichier {$a} dépasse la taille maximale autorisée.';
