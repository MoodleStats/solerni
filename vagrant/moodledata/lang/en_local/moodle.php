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

$string['emailconfirmation'] = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><!doctype html>

<html lang="fr">
<head>
    <title></title>
</head>
<body style="margin: 0px; font-family : Helvetica, Arial, Verdana;" bgcolor="#f8f7f7" link="#ff004f" alink="#ff004f" vlink="#ff004f" style="margin:0px;">


    
    <table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tbody><tr bgcolor="#4b667c">
            <td width="620" align="center">
                <table border="0" width="620" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                        <td align="left">
                            <a href="'.$CFG->wwwroot.'"><img border="0" src="http://laborange.fr/sites/default/files/logo-beta.png" alt="Solerni"></a>
                        </td>
                    </tr>
                </tbody></table>
            </td>
        </tr>
        <tr>
            <td width="620" align="center">
                <table border="0" width="620" cellpadding="0" cellspacing="0">

                    <tbody><tr>
                        <td align="left" bgcolor="#ffffff">
                            <table border="0" width="100%" cellpadding="20" cellspacing="0">
                                <tbody><tr>
                                    <td>


Bonjour {$a->firstname}<br>
<br>
Nous avons reçu une demande d’inscription de votre part avec votre adresse e-mail.<br>
<br>
Afin de valider cette demande nous vous invitons à cliquer sur le lien suivant :<br>
<br>
<a href="{$a->link}">valider mon inscription</a><br>
<br>
Si le bouton ne fonctionne pas, copiez-collez le lien suivant dans la barre d’adresse de votre navigateur :  <a href="{$a->link}">{$a->link}</a><br>
<br>

<br>
<strong>L’équipe de <a href="'.$CFG->wwwroot.'">{$a->sitename}</a></strong><br>
Apprendre c’est toujours mieux ensemble
<a href="'.$CFG->wwwroot.'">{$a->sitename}</a><br>


                                    </td>
                                </tr>
                                <tr>
                                    <td bgcolor="#eeeeef">
                                        <table border="0" width="100%">
                                            <tbody><tr>
                                                <td>
                                                    <font color="#999999">Suivez-nous sur</font><br>
                                                    <a href="https://www.facebook.com/pages/Solerni/648508191861244?fref=ts"><img border="0" src="http://laborange.fr/sites/default/files/picto_facebook.png" alt="Suivez-nous sur Facebook"></a>
                                                    &nbsp;&nbsp;
                                                    <a href="https://twitter.com/SolerniOfficiel"><img border="0" src="http://laborange.fr/sites/default/files/picto_twitter.png" alt="Suivez-nous sur Twitter"></a>
                                                    &nbsp;&nbsp;
                                                    <a href="http://blog.solerni.org"><img border="0" src="http://laborange.fr/sites/default/files/picto_blog.png" alt="Suivez-nous sur notre blog"></a>
                                                </td>
                                                <td align="right" valign="bottom">
                                                    <a href="http://www.orange.com"><img border="0" src="http://laborange.fr/sites/default/files/byorange.png" alt="Powered by Orange"></a>
                                                </td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                </tr>
                                <tr bgcolor="#f8f7f7">
                                    <td>
                                        <font size="2">
                                        Vous recevez cet e-mail car votre adresse e-mail a été utilisée pour votre enregistrement sur notre site <a href="'.$CFG->wwwroot.'">{$a->sitename}</a>.Si vous ne vous êtes pas inscrit à Solerni, veuillez simplement ignorer ce message et votre compte sera supprimé automatiquement.

                                        Ce message vous est envoyé automatiquement, merci de ne pas y répondre directement.<br>
                                        Si vous avez des questions écrivez-nous à <a href="mailto:contact@solerni.com">contact@solerni.com</a>.<br>
                                        Afin de bien recevoir nos e-mails, ajoutez cette adresse <a href="mailto:noreply@solerni.com">noreply@solerni.com</a> dans votre carnet d’adresses.<br>
                                        </font>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody></table>

</div></blockquote></body></html>';
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
$string['emailagain'] = 'Email (verification)';
$string['createaccount'] = 'Register';
$string['policyagree'] = 'You must accept the general terms of use.';
$string['policyaccept'] = 'J’ai lu et j’accepte les conditions générales d’utilisation';
$string['policyagreementclick'] = 'Lire les conditions générales d’utilisation';
$string['newusernewpasswoardsubj'] = 'Creation of your user aacount';
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
$string['emailresetconfirmation'] = 'Hello {$a->firstname},

You have requested a password reset. If you did not request this reset, please ignore this message.

Your username is : \'{$a->username}\'.

Click on the link to reset your password :
{$a->link}

If the link does not work, copy and paste the URL to your browser\'s address bar.

The Solerni team {$a->sitename}
Learning is always better together ' . $CFG->wwwroot . '

		
You have received this email because your email address was used to sign up to our site {$a->sitename}. This is an automatic message, please do not reply to it directly. If you have any questions, write to us at contact@solerni.com.
To ensure that you never miss our email, add this address noreply@solerni.com to your address book.';		
$string['emailresetconfirmationhtml'] = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><!doctype html>

<html lang="fr">
<head>
    <title></title>
</head>
<body style="margin: 0px; font-family : Helvetica, Arial, Verdana;" bgcolor="#f8f7f7" link="#ff004f" alink="#ff004f" vlink="#ff004f" style="margin:0px;">



    <table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tbody><tr bgcolor="#4b667c">
            <td width="620" align="center">
                <table border="0" width="620" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                        <td align="left">
                            <a href="'.$CFG->wwwroot.'"><img border="0" src="http://laborange.fr/sites/default/files/logo-beta.png" alt="Solerni"></a>
                        </td>
                    </tr>
                </tbody></table>
            </td>
        </tr>
        <tr>
            <td width="620" align="center">
                <table border="0" width="620" cellpadding="0" cellspacing="0">

                    <tbody><tr>
                        <td align="left" bgcolor="#ffffff">
                            <table border="0" width="100%" cellpadding="20" cellspacing="0">
                                <tbody><tr>
                                    <td>

<p>Hello {$a->firstname},</p>

<p>You have requested a password reset. If you did not request this reset, please ignore this message.</p>

Your username is : \'{$a->username}\'.
<br />
<p><a href="{$a->link}">Click on the link to reset your password</a>

<br><br>
<strong>The Solerni team</strong><br>
Learning is always better together <a href="'.$CFG->wwwroot.'">{$a->sitename}</a><br>

                                    </td>
                                </tr>
                                <tr>
                                    <td bgcolor="#eeeeef">
                                        <table border="0" width="100%">
                                            <tbody><tr>
                                                <td>
                                                    <font color="#999999">Suivez-nous sur</font><br>
                                                    <a href="https://www.facebook.com/pages/Solerni/648508191861244?fref=ts"><img border="0" src="http://laborange.fr/sites/default/files/picto_facebook.png" alt="Suivez-nous sur Facebook"></a>
                                                    &nbsp;&nbsp;
                                                    <a href="https://twitter.com/SolerniOfficiel"><img border="0" src="http://laborange.fr/sites/default/files/picto_twitter.png" alt="Suivez-nous sur Twitter"></a>
                                                    &nbsp;&nbsp;
                                                    <a href="http://blog.solerni.org"><img border="0" src="http://laborange.fr/sites/default/files/picto_blog.png" alt="Suivez-nous sur notre blog"></a>
                                                </td>
                                                <td align="right" valign="bottom">
                                                    <a href="http://www.orange.com"><img border="0" src="http://laborange.fr/sites/default/files/byorange.png" alt="Powered by Orange"></a>
                                                </td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                </tr>
                                <tr bgcolor="#f8f7f7">
                                    <td>
                                        <font size="2">
											You have received this email because your email address was used to sign up to our site <a href="'.$CFG->wwwroot.'">{$a->sitename}</a>. 
											This is an automatic message, please do not reply to it directly. 
											If you have any questions, write to us at <a href="mailto:contact@solerni.com">contact@solerni.com</a>.
											To ensure that you never miss our email, add this address <a href="mailto:noreply@solerni.com">noreply@solerni.com</a> to your address book.		
		                                        </font>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody></table>

</div></blockquote></body></html>';
$string['commentscount'] = 'Write a comment';