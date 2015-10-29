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
 * @package    local_orange_event_user_loggedin
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Orange Evt user_loggedin';
$string['local_orange_event_user_loggedin'] = 'Orange Evt user_loggedin';
$string['subjectuseraccountemail'] = 'Rappel de vos identifiants sur {$a->sitename}';
$string['contentuseraccountemail'] = '<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body dir="auto">

    <table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tbody><tr bgcolor="#4b667c">
            <td width="620" align="center">
                <table border="0" width="620" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                        <td align="left">
                            <a href="{$a->siteurl}"><img border="0" src="http://laborange.fr/sites/default/files/logo-beta.png" alt="Solerni"></a>
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


Bonjour {$a->fullname}<br>
<br>
Nous vous remercions pour votre inscription sur le site <strong>{$a->sitename}</strong>.<br>
<br>
Voici un rappel de vos identifiants de connexion pour accéder à votre compte :<br>
<ul>
	<li>Identifiant : <a href="mailto:{$a->email}">{$a->email}</a></li>
	<li>Mot de passe : vous seul le connaissez</li>
</ul>
Vous pouvez dès à présent accéder à votre compte en cliquant <a href="{$a->profileurl}">ici</a>.<br>
<br>
A très vite sur {$a->sitename}, votre nouvelle plateforme de Moocs francophone collaborative.<br>
<br>
<br>
<strong>L\'équipe de <a href="{$a->siteurl}">{$a->sitename}</a></strong><br>
Apprendre c\'est toujours mieux ensemble
<a href="{$a->siteurl}">{$a->sitename}</a><br>


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
                                        Vous recevez cet e-mail car votre adresse e-mail <a href="mailto:{$a->email}">{$a->email}</a> a été utilisée pour votre enregistrement sur notre site <a href="{$a->siteurl}">{$a->sitename}</a>.Si vous ne vous êtes pas inscrit à {$a->sitename}, veuillez simplement ignorer ce message et votre compte sera supprimé automatiquement.

                                        Ce message vous est envoyé automatiquement, merci de ne pas y répondre directement.<br>
                                        Si vous avez des questions écrivez-nous à <a href="mailto:contact@solerni.com">contact@solerni.com</a>.<br>
                                        Afin de bien recevoir nos e-mails, ajoutez cette adresse <a href="mailto:noreply@solerni.com">noreply@solerni.com</a> dans votre carnet d\'adresses.<br>
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


</body></html>';
$string['subjectwelcomeemail'] = 'Bienvenue sur {$a->sitename}';
$string['contentwelcomeemail'] = '<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body dir="auto">

    <table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tbody><tr bgcolor="#4b667c">
            <td width="620" align="center">
                <table border="0" width="620" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                        <td align="left">
                            <a href="{$a->siteurl}"><img border="0" src="http://laborange.fr/sites/default/files/logo-beta.png" alt="Solerni"></a>
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


Bienvenue  {$a->fullname}<br>
<br>
Nous sommes ravis de vous accueillir sur {$a->sitename}, votre nouvelle plateforme de Moocs francophone collaborative.<br>
<br>
Plus que l’acquisition de connaissances, nous souhaitons que cette plateforme vous aide à développer vos compétences. Nous pensons en effet qu’aujourd’hui, l’apprentissage ne peut plus se faire seul face à un professeur ou un formateur mais aussi ensemble, en réseau. C\'est à travers un parcours favorisant les échanges et les activités que vous développerez vos compétences. Vous serez à tout moment accompagné(e) par vos pairs mais aussi par des pédagogues dont l’objectif est de faciliter vos apprentissages en stimulant le partage d’information et l\'enrichissement mutuel.<br>
<br>
<strong>C’est parti, inscrivez-vous à un Mooc</strong><br>
<br>
Notre plateforme vient tout juste d’être lancée et s’enrichira au fil des semaines de nouveaux Moocs aux contenus variés. <br>
<br>
Vous pouvez d’ores et déjà consulter <a href="">notre catalogue</a> et vous inscrire à l’un des Moocs disponibles aujourd’hui. Notre plateforme est ouverte et gratuite, les inscriptions sont donc illimitées&nbsp;! <br>
<br>
<strong>Restez en contact, restez connecté</strong> <br>
<br>
Pour être au courant des nouveautés et des évènements sur {$a->sitename}, rejoignez nous sur <a href=\'https://www.facebook.com/pages/Solerni/648508191861244?fref=ts\' target=\'_new\'>Facebook</a> et <a href=\'https://twitter.com/SolerniOfficiel\' target=\'_new\'>Twitter</a>, sans oublier d\'aller faire un tour sur notre <a href=\'http://blog.solerni.org\' target=\'_new\'>Blog</a> qui vous informera des actualités liées  à l’univers de ces nouvelles méthodes d’apprentissage sociales et collaboratives.<br>
<br>
<strong>Pour bien communiquer, remplissez votre profil</strong><br>
<br>
Et pour être sûr(e) de pouvoir échanger avec les autres apprenants et les pédagogues, n’oubliez pas de remplir et de paramétrer votre <a href="{$a->profileurl}">profil public</a>.<br>
<br>
Voilà, vous êtes prêt(e) à présent pour vous lancer avec nous dans l’aventure des Moocs collaboratifs.
En espérant vous retrouver très vite sur {$a->sitename} où nous vous souhaitons de vivre de nouvelles expériences enrichissantes&nbsp;!<br>
<br>
<br>
<strong>L’équipe {$a->sitename}</strong><br>
Apprendre c’est toujours mieux ensemble<br>
<a href="{$a->siteurl}">{$a->sitename}</a><br>


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
                                        Vous recevez cet e-mail car votre adresse e-mail <a href="mailto:{$a->email}">{$a->email}</a> a été utilisée pour votre enregistrement sur notre site <a href="{$a->sitename}">{$a->sitename}</a>.Si vous ne vous êtes pas inscrit à {$a->sitename}, veuillez simplement ignorer ce message et votre compte sera supprimé automatiquement.

                                        Ce message vous est envoyé automatiquement, merci de ne pas y répondre directement.<br>
                                        Si vous avez des questions écrivez-nous à <a href="mailto:contact@solerni.com">contact@solerni.com</a>.<br>
                                        Afin de bien recevoir nos e-mails, ajoutez cette adresse <a href="mailto:noreply@solerni.com">noreply@solerni.com</a> dans votre carnet d\'adresses.<br>
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


</body></html>';